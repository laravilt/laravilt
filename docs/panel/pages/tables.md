---
title: Page Tables
description: Display tabular data on standalone pages
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
concept: pages
---

# Page Tables

Display tabular data on standalone pages.

## Basic Table Page

```php
<?php

namespace App\Laravilt\Admin\Pages;

use App\Models\ActivityLog;
use Laravilt\Panel\Pages\Page;
use Laravilt\Tables\Table;
use Laravilt\Tables\Columns\TextColumn;

class ActivityLogs extends Page
{
    protected static ?string $navigationIcon = 'Activity';
    protected static ?string $title = 'Activity Logs';

    public function table(Table $table): Table
    {
        return $table
            ->query(ActivityLog::query()->latest())
            ->columns([
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('User'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->paginated([10, 25, 50]);
    }
}
```

## With Filters and Actions

```php
<?php

namespace App\Laravilt\Admin\Pages;

use App\Models\Order;
use Laravilt\Panel\Pages\Page;
use Laravilt\Tables\Table;
use Laravilt\Tables\Columns\TextColumn;
use Laravilt\Tables\Columns\BadgeColumn;
use Laravilt\Tables\Filters\SelectFilter;
use Laravilt\Tables\Filters\DateFilter;
use Laravilt\Actions\Action;
use Laravilt\Actions\ViewAction;

class RecentOrders extends Page
{
    protected static ?string $navigationIcon = 'ShoppingCart';
    protected static ?string $title = 'Recent Orders';

    public function table(Table $table): Table
    {
        return $table
            ->query(Order::query()->latest()->limit(100))
            ->columns([
                TextColumn::make('order_number')
                    ->label('Order #')
                    ->searchable(),
                TextColumn::make('customer.name')
                    ->label('Customer'),
                TextColumn::make('total')
                    ->money('USD')
                    ->sortable(),
                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'processing',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ]),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                DateFilter::make('created_at'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->url(fn ($record) => route('orders.show', $record)),
            ])
            ->paginated([10, 25, 50]);
    }
}
```

## Multiple Tables

```php
<?php

namespace App\Laravilt\Admin\Pages;

use App\Models\User;
use App\Models\Order;
use Laravilt\Panel\Pages\Page;
use Laravilt\Tables\Table;
use Laravilt\Tables\Columns\TextColumn;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'LayoutDashboard';

    public function usersTable(Table $table): Table
    {
        return $table
            ->query(User::query()->latest()->limit(5))
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('created_at')->dateTime(),
            ]);
    }

    public function ordersTable(Table $table): Table
    {
        return $table
            ->query(Order::query()->latest()->limit(5))
            ->columns([
                TextColumn::make('order_number'),
                TextColumn::make('total')->money('USD'),
                TextColumn::make('status'),
            ]);
    }
}
```
