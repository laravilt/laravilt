---
title: Your First Resource
description: The files laravilt:resource generates, and how to customize the resource, form and table.
order: 5
---

# Your First Resource

This page walks through the `Product` resource from the [Quick Start](quick-start.md) and customizes each part.

## The resource class

`app/Laravilt/Admin/Resources/Product/ProductResource.php` connects the model to its form, table, infolist and pages:

```php
namespace App\Laravilt\Admin\Resources\Product;

use App\Laravilt\Admin\Resources\Product\Form\ProductForm;
use App\Laravilt\Admin\Resources\Product\InfoList\ProductInfoList;
use App\Laravilt\Admin\Resources\Product\Pages\CreateProduct;
use App\Laravilt\Admin\Resources\Product\Pages\EditProduct;
use App\Laravilt\Admin\Resources\Product\Pages\ListProduct;
use App\Laravilt\Admin\Resources\Product\Pages\ViewProduct;
use App\Laravilt\Admin\Resources\Product\Table\ProductTable;
use App\Models\Product;
use Laravilt\Panel\Resources\Resource;
use Laravilt\Schemas\Schema;
use Laravilt\Tables\Table;

class ProductResource extends Resource
{
    protected static string $model = Product::class;

    protected static ?string $navigationIcon = 'Package';   // any Lucide icon name

    protected static ?string $navigationGroup = 'Shop';

    protected static int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProductInfoList::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'list' => ListProduct::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
            'view' => ViewProduct::route('/{record}'),
        ];
    }
}
```

With `--simple` (or by answering "yes" to the simple question), you get one `ManageProduct` page that handles create and edit in modals.

## The form

`Form/ProductForm.php` returns a schema of fields. Fields come from `laravilt/forms`, and layout components such as `Section` come from `laravilt/schemas`:

```php
namespace App\Laravilt\Admin\Resources\Product\Form;

use Laravilt\Forms\Components\FileUpload;
use Laravilt\Forms\Components\MarkdownEditor;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Forms\Components\Toggle;
use Laravilt\Schemas\Components\Section;
use Laravilt\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $form): Schema
    {
        return $form->schema([
            Section::make('Basic information')
                ->columns(2)
                ->schema([
                    TextInput::make('name')->required()->maxLength(255),
                    TextInput::make('slug')->required()->unique(ignoreRecord: true),
                    MarkdownEditor::make('description')->columnSpanFull(),
                    FileUpload::make('image')->image()->directory('products')->columnSpanFull(),
                ]),

            Section::make('Pricing & stock')
                ->columns(2)
                ->schema([
                    TextInput::make('price')->numeric()->prefix('$')->required()->minValue(0),
                    TextInput::make('stock')->integer()->default(0)->minValue(0),
                    Toggle::make('is_active')->label('Active')->default(true),
                ]),
        ]);
    }
}
```

Fields can react to each other with `->live()` and `->afterStateUpdated(...)`. See [Reactive Fields](../forms/reactive/README.md) and [Validation](../forms/validation/README.md).

## The table

`Table/ProductTable.php` defines columns, filters and actions. Actions come from `laravilt/actions`:

```php
namespace App\Laravilt\Admin\Resources\Product\Table;

use Laravilt\Actions\BulkActionGroup;
use Laravilt\Actions\DeleteAction;
use Laravilt\Actions\DeleteBulkAction;
use Laravilt\Actions\EditAction;
use Laravilt\Actions\ViewAction;
use Laravilt\Tables\Columns\ImageColumn;
use Laravilt\Tables\Columns\TextColumn;
use Laravilt\Tables\Columns\ToggleColumn;
use Laravilt\Tables\Filters\TernaryFilter;
use Laravilt\Tables\Table;

class ProductTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->circular(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('price')->money('USD')->sortable(),
                TextColumn::make('stock')->badge(),
                ToggleColumn::make('is_active')->label('Active'),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('is_active')->label('Active'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
```

See [Columns](../tables/columns/README.md), [Filters](../tables/filters/README.md) and [Actions](../actions/README.md).

## More generators

| Command | Creates |
|---------|---------|
| `php artisan laravilt:relation admin Product reviews` | A relation manager for a relationship. |
| `php artisan laravilt:nested Variant --parent=Product` | A resource nested under another. |
| `php artisan laravilt:page admin Reports --type=table` | A custom page (`.vue` or `.tsx`, depending on your stack). |
| `php artisan laravilt:widget --panel=admin --type=stats` | A dashboard widget. |

Continue with [Panel & Resources](../panel/README.md).
