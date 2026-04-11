---
title: "Weaviate: A Practical Guide to Self-Hosted Vector Search"
description: "Weaviate is one of the best open-source vector databases for production RAG systems. Here's how to set it up, structure your data, and avoid the common mistakes."
date: "2026-04-07"
author: "Amerigo Velletti"
tags: "Weaviate, Vector Database, RAG, AI, Infrastructure"
---

When you outgrow ChromaDB or in-memory FAISS, you need a real vector database. After evaluating Pinecone, Qdrant, Milvus, and Weaviate for multiple projects, I keep coming back to Weaviate. It's open source, self-hostable, has built-in hybrid search, and the developer experience is genuinely good.

Here's what I've learned running it in production.

## Why Weaviate

Three features set it apart:

**Hybrid search out of the box.** Most vector databases do pure vector similarity. Weaviate combines vector search with BM25 keyword search in a single query. For RAG systems, this is critical: some queries need semantic understanding ("What are the risks of this approach?") and others need exact matching ("What does § 1 Abs. 3d AStG say?").

**Schema-first design.** You define collections with typed properties, not just raw vectors. This means you can filter by metadata (date, category, source) without post-processing. The query planner handles filtering and vector search together.

**Modular vectorization.** You can bring your own vectors, or let Weaviate call an embedding API (OpenAI, Cohere, local models) automatically when you insert data. This simplifies the pipeline significantly.

## Getting Started with Docker

The fastest way to run Weaviate locally:

```yaml
services:
  weaviate:
    image: cr.weaviate.io/semitechnologies/weaviate:1.28.2
    ports:
      - "8080:8080"
      - "50051:50051"
    environment:
      QUERY_DEFAULTS_LIMIT: 25
      AUTHENTICATION_ANONYMOUS_ACCESS_ENABLED: "true"
      PERSISTENCE_DATA_PATH: "/var/lib/weaviate"
      ENABLE_MODULES: "text2vec-openai,generative-openai"
      DEFAULT_VECTORIZER_MODULE: "text2vec-openai"
      OPENAI_APIKEY: "${OPENAI_API_KEY}"
    volumes:
      - weaviate_data:/var/lib/weaviate

volumes:
  weaviate_data:
```

Run `docker compose up -d` and Weaviate is available at `localhost:8080`. Data persists across restarts via the Docker volume.

For production without OpenAI dependency, swap the vectorizer to a local model like `text2vec-transformers` and add the transformer container. This keeps everything self-hosted.

## Designing Your Schema

The schema is where most people make mistakes. A well-designed Weaviate schema makes querying natural. A bad one forces you into workarounds.

### Example: Document Store for RAG

```python
import weaviate

client = weaviate.connect_to_local()

documents = client.collections.create(
    name="Document",
    properties=[
        weaviate.classes.config.Property(
            name="content",
            data_type=weaviate.classes.config.DataType.TEXT,
        ),
        weaviate.classes.config.Property(
            name="source",
            data_type=weaviate.classes.config.DataType.TEXT,
            skip_vectorization=True,
        ),
        weaviate.classes.config.Property(
            name="section",
            data_type=weaviate.classes.config.DataType.TEXT,
            skip_vectorization=True,
        ),
        weaviate.classes.config.Property(
            name="page_number",
            data_type=weaviate.classes.config.DataType.INT,
            skip_vectorization=True,
        ),
    ],
)
```

Key decisions:

- **`skip_vectorization=True`** on metadata fields. You don't want the filename or page number influencing the vector. Only the actual content should be vectorized.
- **Separate `content` from `section` and `source`.** This lets you filter by source document before searching, dramatically improving relevance.

## Inserting Data

Batch inserts are critical for performance. Don't insert documents one at a time.

```python
documents = client.collections.get("Document")

with documents.batch.dynamic() as batch:
    for chunk in chunks:
        batch.add_object(
            properties={
                "content": chunk["text"],
                "source": chunk["filename"],
                "section": chunk["heading"],
                "page_number": chunk["page"],
            }
        )
```

Weaviate handles vectorization automatically if you've configured a vectorizer module. The batch processes hundreds of objects per second.

## Querying: The Part That Matters

### Pure Vector Search

```python
results = documents.query.near_text(
    query="What are the compliance requirements?",
    limit=5,
)
```

This finds the 5 chunks most semantically similar to the query.

### Hybrid Search

```python
results = documents.query.hybrid(
    query="§ 1 Abs. 3d AStG Schuldentragfähigkeitstest",
    alpha=0.5,
    limit=5,
)
```

`alpha` controls the balance: 0.0 is pure keyword, 1.0 is pure vector, 0.5 is equal weight. For domain-specific terms, legal references, or product names, lowering alpha toward keyword search produces better results.

### Filtered Search

```python
results = documents.query.hybrid(
    query="transfer pricing documentation requirements",
    filters=weaviate.classes.query.Filter.by_property("source").equal("oecd-guidelines-2022.pdf"),
    limit=5,
)
```

This searches only within a specific document. Filtering happens at the database level, before the vector search, so it's fast even with millions of objects.

## Production Considerations

### Backups

Weaviate supports native backups to S3 or local filesystem:

```bash
curl -X POST http://localhost:8080/v1/backups/filesystem \
  -H 'Content-Type: application/json' \
  -d '{"id": "daily-backup", "include": ["Document"]}'
```

Run this daily via cron. A full backup of 100K objects takes seconds.

### Monitoring

Weaviate exposes Prometheus metrics at `/v2/metrics`. Track:

- Query latency (p50, p95, p99)
- Object count per collection
- Memory usage
- Vector index size

If p95 query latency exceeds 200ms, you likely need to tune the HNSW index parameters or add more RAM.

### Multi-Tenancy

If you're building a SaaS product where each customer has their own documents, use Weaviate's multi-tenancy feature. Each tenant gets isolated data with shared infrastructure:

```python
documents = client.collections.create(
    name="Document",
    multi_tenancy_config=weaviate.classes.config.Configure.multi_tenancy(enabled=True),
    # ... properties
)

documents.tenants.create(
    tenants=[weaviate.classes.tenants.Tenant(name="customer-123")]
)
```

This is cheaper than running separate Weaviate instances per customer and provides proper data isolation.

## When Not to Use Weaviate

Weaviate is overkill if:

- You have fewer than 10,000 vectors. Use FAISS or ChromaDB.
- You don't need filtering or hybrid search. Qdrant is simpler for pure vector similarity.
- You want a fully managed service with zero ops. Use Pinecone.

But if you need self-hosted vector search with hybrid capabilities, filtering, and multi-tenancy, Weaviate is the strongest option in the open-source ecosystem. The documentation is thorough, the Python client is well-designed, and the Docker setup means you can run it locally in under a minute.

---

**Weitere Artikel:** [RAG: From Prototype to Production in Practice](/blog/post.php?slug=rag-from-prototype-to-production) | [How AI Automation Saves Startups 20+ Hours Per Week](/blog/post.php?slug=ai-automation-for-startups)
