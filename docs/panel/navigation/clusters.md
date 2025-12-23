---
title: Clusters
description: Group related pages under a single navigation item
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
concept: navigation
---

# Clusters

Clusters allow you to group related pages under a single navigation item with sub-navigation.

## Creating a Cluster

```bash
php artisan laravilt:cluster Reports
```

## Basic Cluster

```php
<?php

namespace App\Laravilt\Admin\Clusters;

use Laravilt\Panel\Cluster;

class Reports extends Cluster
{
    protected static ?string $navigationIcon = 'BarChart3';

    protected static ?string $navigationLabel = 'Reports';

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationGroup = null;

    protected static bool $shouldRegisterNavigation = true;
}
```

## Assigning Pages to Cluster

```php
<?php

namespace App\Laravilt\Admin\Pages;

use App\Laravilt\Admin\Clusters\Reports;
use Laravilt\Panel\Pages\Page;

class SalesAnalytics extends Page
{
    protected static ?string $navigationIcon = 'TrendingUp';

    protected static ?string $navigationLabel = 'Sales Analytics';

    protected static ?string $title = 'Sales Analytics';

    protected static ?int $navigationSort = 1;

    protected static ?string $cluster = Reports::class;

    public static function getCluster(): ?string
    {
        return static::$cluster;
    }
}
```

## Cluster Properties

| Property | Type | Description |
|----------|------|-------------|
| `$navigationIcon` | `string` | Lucide icon |
| `$navigationLabel` | `string` | Navigation label |
| `$navigationSort` | `int` | Sort order |
| `$navigationGroup` | `string` | Parent navigation group |
| `$shouldRegisterNavigation` | `bool` | Show in navigation |
