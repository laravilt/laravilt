---
title: Plugin Manager
description: Inspect and control registered plugins with the LaraviltPlugins facade.
order: 4
---

# Plugin Manager

`Laravilt\Plugins\Support\PluginManager` keeps track of plugins across the application. It is a singleton, reachable through the `Laravilt\Plugins\Facades\LaraviltPlugins` facade.

- [Registration](registration.md): register plugins on panels and understand auto-discovery

## Facade methods

```php
use Laravilt\Plugins\Facades\LaraviltPlugins;

LaraviltPlugins::all();                 // Collection of all plugins
LaraviltPlugins::enabled();             // Collection of enabled plugins
LaraviltPlugins::has('blog-manager');   // bool
LaraviltPlugins::get('blog-manager');   // Plugin instance
LaraviltPlugins::plugin('blog-manager'); // same as get()
LaraviltPlugins::plugin();              // the PluginManager itself

LaraviltPlugins::register($plugin);     // add a plugin instance
LaraviltPlugins::boot('blog-manager');
LaraviltPlugins::bootAll();
LaraviltPlugins::discover();            // scan installed packages
LaraviltPlugins::getManifest();         // PluginManifest (toArray(), toJson())
```

| Method | Returns | Description |
|--------|---------|-------------|
| `register(Plugin $plugin)` | `void` | Register a plugin |
| `boot(string $id)` | `void` | Boot one plugin |
| `bootAll()` | `void` | Boot every plugin |
| `get(string $id)` | `Plugin` | Get a plugin |
| `has(string $id)` | `bool` | Check a plugin exists |
| `all()` | `Collection` | All plugins |
| `enabled()` | `Collection` | Enabled plugins |
| `discover()` | `void` | Discover plugins from `composer.lock` |
| `getManifest()` | `PluginManifest` | Manifest of registered plugins |
