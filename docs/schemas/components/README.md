---
title: Layout Components
description: Section, Grid, Tabs, Wizard, Split and Fieldset.
order: 2
---

# Layout Components

Layout components live in `Laravilt\Schemas\Components`. They hold form fields or infolist entries through `schema()` (Tabs and Wizard use `tabs()` and `steps()`). Except for `Section::make()` and `Grid::make()`, every component's `make()` requires a name.

1. [Section](section.md): grouped content with heading, icon and collapse
2. [Grid](grid.md): responsive columns
3. [Tabs](tabs.md): tabbed panels
4. [Wizard](wizard.md): multi-step flow
5. [Split](split.md): start and end panes
6. [Fieldset](fieldset.md): labelled group

> The panel's schema renderer maps Section, Grid, Tabs, Wizard and Split (plus all built-in fields and entries) on both stacks. Fieldset has no dedicated frontend component yet, so use Section for grouped content.
