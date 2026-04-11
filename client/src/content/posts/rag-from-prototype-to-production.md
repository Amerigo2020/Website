---
title: "RAG: From Prototype to Production in Practice"
description: "Retrieval-Augmented Generation is easy to demo and hard to ship. Here's what actually matters when you take a RAG system from 'it works on my laptop' to production."
date: "2026-04-08"
author: "Amerigo Velletti"
tags: "RAG, AI, LLM, Vector Database, Production"
---

Every RAG demo looks impressive. You upload some documents, ask a question, and the AI answers using your data. Twenty minutes of setup, and you have a "working" system.

Then you try to put it in front of real users. And everything falls apart.

I've built RAG systems for my Bachelor's thesis (a multi-source data integration approach for transfer pricing) and for client projects. The gap between prototype and production is where most teams give up. Here's what I've learned about closing it.

## The Prototype Trap

A typical RAG prototype:

1. Split documents into chunks (500 tokens, no overlap)
2. Embed chunks with OpenAI's embedding model
3. Store vectors in an in-memory database
4. On query, find the top 5 similar chunks
5. Pass them to an LLM with "Answer based on the following context"

This works for demos because you control the questions. You know which documents contain the answer, and you ask questions that map cleanly to individual chunks.

Production users don't do this. They ask vague questions. They ask multi-part questions. They ask questions where the answer spans three documents. They ask questions where the answer isn't in your data at all.

## What Breaks in Production

### Chunking Strategy

Fixed-size chunking (split every N tokens) is the default, and it's almost always wrong. It cuts sentences in half, separates tables from their headers, and splits code examples from their explanations.

What works better:

- **Semantic chunking**: Split at paragraph or section boundaries. A chunk should contain one complete idea.
- **Overlap**: Include 10-20% overlap between adjacent chunks so you don't lose context at boundaries.
- **Metadata preservation**: Attach the document title, section heading, and page number to every chunk. This helps the LLM cite sources and helps you debug retrieval.

### Retrieval Quality

Cosine similarity on embeddings is a blunt instrument. The top 5 most similar chunks aren't always the top 5 most relevant chunks. Embedding models optimize for semantic similarity, not for answer relevance.

Techniques that improve retrieval:

- **Hybrid search**: Combine vector similarity with keyword matching (BM25). Some queries need semantic understanding, others need exact term matching.
- **Reranking**: Retrieve the top 20 candidates, then use a cross-encoder model to rerank them by actual relevance to the query. This is slower but dramatically more accurate.
- **Query expansion**: Before searching, use an LLM to generate 2-3 reformulations of the user's question. Search with all of them and deduplicate results.

### The "I Don't Know" Problem

The hardest challenge in production RAG: the system should say "I don't know" when the answer isn't in the data. Instead, most systems hallucinate confidently.

Approaches that help:

- **Relevance scoring**: If no retrieved chunk scores above a threshold, return "I couldn't find information about this" instead of generating an answer.
- **Citation enforcement**: Require the LLM to cite specific chunks for every claim. If it can't cite a source, it shouldn't make the claim.
- **Grounded generation**: Structure the prompt so the LLM can only use information from the provided context, with explicit instructions to decline when the context is insufficient.

## Architecture Decisions That Matter

### Embedding Model Selection

Don't default to OpenAI's `text-embedding-3-small`. It's decent but not optimal for every domain. For technical or domain-specific content, fine-tuned embedding models or models like `nomic-embed-text` often outperform general-purpose embeddings.

Test your embedding model against your actual data. Create a test set of 50 question-answer pairs, run retrieval, and measure whether the correct chunks appear in the top 5. If retrieval precision is below 80%, your embedding model is the bottleneck.

### Vector Database Choice

For prototypes, in-memory FAISS or ChromaDB work fine. For production, you need:

- **Persistence**: Your vectors survive a restart.
- **Filtering**: Query vectors with metadata filters (e.g., "only search documents from 2026").
- **Scalability**: Handle millions of vectors without degrading search latency.

Weaviate, Qdrant, and Pinecone all handle these requirements. The choice depends on whether you want self-hosted (Weaviate, Qdrant) or managed (Pinecone), and whether you need hybrid search built in (Weaviate).

### Agentic RAG

For complex questions, a single retrieve-then-generate pass isn't enough. The system needs to:

1. Analyze the question and decide which data sources to query
2. Retrieve from multiple sources in parallel
3. Evaluate whether the retrieved context is sufficient
4. Ask follow-up queries if gaps remain
5. Synthesize the final answer from all retrieved context

This is the "agentic" approach: the LLM acts as a reasoning agent that orchestrates its own retrieval. It's more complex to build but handles real-world queries far better than a static pipeline.

In my thesis, I built specialized retriever agents (one for Excel data, one for text documents) coordinated by a reasoning-first orchestrator. The key insight: letting the LLM decide *how* to retrieve, not just *what* to retrieve, made the system dramatically more robust.

## The Minimum Viable RAG Stack

If you're building RAG for production today:

1. **Chunking**: Semantic chunking with overlap and metadata
2. **Embeddings**: Test at least two models against your data before committing
3. **Storage**: Weaviate or Qdrant (self-hosted) for full control
4. **Retrieval**: Hybrid search (vector + keyword) with reranking
5. **Generation**: Structured prompts with citation requirements and refusal instructions
6. **Evaluation**: A test set of 50+ questions with expected answers, run weekly

The prototype-to-production gap in RAG isn't a technology problem. It's an evaluation problem. If you can't measure retrieval quality, you can't improve it. Build the measurement first, then iterate on everything else.

---

**Weitere Artikel:** [Weaviate: A Practical Guide to Self-Hosted Vector Search](/blog/post.php?slug=weaviate-vector-database-practical-guide) | [Context Windows: What Developers Get Wrong About AI Coding Assistants](/blog/post.php?slug=context-windows-what-developers-get-wrong)
