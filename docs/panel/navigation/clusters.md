---
title: Clusters
description: Group related pages under a single navigation item with sub-navigation.
order: 3
---

# Clusters

A cluster groups related pages under a single navigation item. The pages then share a sub-navigation.

## Creating a Cluster

```bash
php artisan laravilt:cluster Admin Reports --icon=BarChart3 --sort=10
```

| Argument / option | Description |
|-------------------|-------------|
| `panel` | Panel name |
| `name` | Cluster class name |
| `--icon=Folder` | Navigation icon |
| `--sort=0` | Navigation sort order |
| `--group=` | Navigation group |

This creates `app/Laravilt/Admin/Clusters/Reports.php`:

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

## Assigning Pages to a Cluster

```php
<?php

namespace App\Laravilt\Admin\Pages;

use App\Laravilt\Admin\Clusters\Reports;
use Laravilt\Panel\Pages\Page;

class SalesAnalytics extends Page
{
    protected static ?string $cluster = Reports::class;

    protected static ?string $navigationIcon = 'TrendingUp';

    protected static ?string $navigationLabel = 'Sales Analytics';

    protected static ?int $navigationSort = 1;
}
```

## Cluster Properties

| Property | Type | Description |
|----------|------|-------------|
| `$navigationIcon` | `?string` | Lucide icon |
| `$navigationLabel` | `?string` | Navigation label |
| `$navigationSort` | `?int` | Sort order |
| `$navigationGroup` | `?string` | Parent navigation group |
| `$slug` | `?string` | URL segment |
| `$shouldRegisterNavigation` | `bool` | Show in navigation |
| `$clusterBreadcrumb` | `?string` | Breadcrumb label |
