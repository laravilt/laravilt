---
title: Page Tables
description: Show tabular data on a page by building on a resource's list page.
order: 2
---

# Page Tables

Tables in Laravilt come from resources. To show a data listing on its own page, extend `Laravilt\Panel\Pages\ListRecords` and point it at a resource. `php artisan laravilt:page --type=table` generates a page with this base class.

## Custom Listing Page

```php
<?php

namespace App\Laravilt\Admin\Pages;

use App\Laravilt\Admin\Resources\Order\OrderResource;
use Laravilt\Actions\ViewAction;
use Laravilt\Panel\Pages\ListRecords;
use Laravilt\Tables\Columns\TextColumn;
use Laravilt\Tables\Filters\SelectFilter;
use Laravilt\Tables\Table;

class RecentOrders extends ListRecords
{
    protected static ?string $resource = OrderResource::class;

    protected static ?string $navigationIcon = 'ShoppingCart';

    protected static ?string $title = 'Recent Orders';

    protected static ?string $slug = 'recent-orders';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label('Order #')
                    ->searchable(),
                TextColumn::make('customer.name')
                    ->label('Customer'),
                TextColumn::make('total')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }

    public function getTableQuery()
    {
        return parent::getTableQuery()->where('created_at', '>=', now()->subDays(30));
    }
}
```

`ListRecords` reads records from the resource's `getEloquentQuery()` (with tenant scoping), and adds a create action if the resource has a create page. Override `headerActions()` to add more actions.

## Tables on Dashboards

To show a small table next to other content, use a widget. See [Page Widgets & Actions](widgets.md) and the [Widgets](../../widgets/README.md) section.

## Related

- [Resource Tables](../resources/tables.md)
- [Tables](../../tables/README.md)
