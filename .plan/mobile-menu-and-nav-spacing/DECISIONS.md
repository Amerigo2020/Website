# Decisions: Mobile Menu & Nav Spacing Fixes

## Decision Log

### 2026-01-03 - CSS Selector Specificity Fix

**Kontext**: 
Das Mobile Menu (`.mobile-menu .nav`) wurde nicht angezeigt, weil eine generische Media Query (`.nav { display: none }`) auch die Navigation innerhalb des Mobile Menüs ausgeblendet hat.

**Optionen**:
1. Option A: `.nav` in Media Query belassen und `!important` für Mobile Menu nutzen. -> Contra: Code Smell, schwer zu warten.
2. Option B: Selektoren präzisieren (`.header__container > .nav`). -> Pro: Sauber, logisch korrekt, keine Side-Effects auf andere Navs.

**Entscheidung**: Option B

**Begründung**: 
Durch die Beschränkung des `display: none` auf die direkte Desktop-Navigation (`.header__container > .nav`) bleibt die Mobile-Navigation unberührt und kann separat gestyled werden.

**Konsequenzen**: 
Mobile Menu funktioniert nun korrekt unabhängig von der Desktop-Nav.

---

### 2026-01-03 - Header Spacing

**Kontext**: 
Titel und erster Menüpunkt waren auf mittleren Bildschirmgrößen zu nah beieinander.

**Entscheidung**: 
`gap: var(--spacing-lg)` zum Flex-Container (`.header__container`) hinzugefügt.

**Begründung**: 
Garantiert einen Mindestabstand zwischen allen Flex-Items im Header, unabhängig von `margin-left: auto` der Navigation.
