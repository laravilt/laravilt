---
title: Concepts
description: How Laravilt plugin classes, traits, configuration and dependencies work.
order: 2
---

# Plugin Concepts

A Laravilt plugin is a Composer package with two main classes: a Laravel service provider that loads its files, and a `PluginProvider` subclass that registers resources, pages and widgets on a panel.

- [Plugin classes](plugin-classes.md): the `PluginProvider` base class and `Plugin` contract
- [Traits](traits.md): helpers for migrations, translations, views, assets, commands and components
- [Configuration](configuration.md): config files and fluent plugin options
- [Dependencies](dependencies.md): depend on other packages and plugins
