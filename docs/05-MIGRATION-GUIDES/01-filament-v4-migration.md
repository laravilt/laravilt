# FilamentPHP v4 → Laravilt Migration Guide

This guide helps you migrate from FilamentPHP v4 to Laravilt Framework.

## Why Migrate?

| FilamentPHP v4 | Laravilt |
|---------------|----------|
| Web-only (Livewire) | Web (Vue + Inertia) + Mobile (Flutter) + API |
| Server-rendered components | SPA experience with better performance |
| Manual API development | Auto-generated REST APIs |
| Manual mobile app | Auto-generated Flutter app with Riverpod |
| No AI integration | Built-in AI agents & MCP servers |
| Tables only | Tables **OR** Grids (infinite scroll cards) |

## Key Differences

### 1. Architecture

**FilamentPHP v4**:
```php
// Everything in one Resource class
class UserResource extends Resource
{
    public static function form(Form $form): Form { }
    public static function table(Table $table): Table { }
    public static function infolist(Infolist $infolist): Infolist { }
}
```

**Laravilt** (Class-Based, Recommended):
```php
// Separate classes for better organization
class UserResource extends Resource
{
    protected static string $model = User::class;
    protected static string $formClass = Forms\UserForm::class;
    protected static string $tableClass = Tables\UserTable::class;
    protected static string $gridClass = Grids\UserGrid::class;
    protected static string $infolistClass = Infolists\UserInfolist::class;
}

// Separate form definition
class UserForm extends Form
{
    public function schema(): array
    {
        return [
            TextInput::make('name')->required(),
            TextInput::make('email')->email()->required(),
        ];
    }
}
```

**Laravilt** (Inline, Alternative):
```php
// If you prefer inline like Filament
class UserResource extends Resource
{
    protected static string $model = User::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->required(),
            TextInput::make('email')->email()->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name'),
            TextColumn::make('email'),
        ]);
    }
}
```

### 2. Component Naming Compatibility

Laravilt maintains **100% naming compatibility** with FilamentPHP v4 components:

| FilamentPHP v4 | Laravilt | Status |
|---------------|----------|--------|
| `TextInput` | `TextInput` | ✅ Same |
| `Select` | `Select` | ✅ Same |
| `DatePicker` | `DatePicker` | ✅ Same |
| `Toggle` | `Toggle` | ✅ Same |
| `RichEditor` | `RichEditor` | ✅ Same |
| `FileUpload` | `FileUpload` | ✅ Same |
| `TextColumn` | `TextColumn` | ✅ Same |
| `BadgeColumn` | `BadgeColumn` | ✅ Same |
| `IconColumn` | `IconColumn` | ✅ Same |
| `ImageColumn` | `ImageColumn` | ✅ Same |

### 3. API Methods Compatibility

All fluent API methods are compatible:

```php
// FilamentPHP v4 syntax works in Laravilt
TextInput::make('email')
    ->label('Email Address')
    ->email()
    ->required()
    ->maxLength(255)
    ->helperText('We will never share your email')
    ->placeholder('john@example.com')
    ->default('user@example.com')
    ->disabled()
    ->hidden()
    ->columnSpan(2);

Select::make('status')
    ->options([
        'draft' => 'Draft',
        'published' => 'Published',
    ])
    ->default('draft')
    ->required()
    ->searchable()
    ->multiple()
    ->native(false);
```

### 4. Grid Display Mode (New in Laravilt)

Laravilt adds **Grid mode** for card-based layouts with infinite scroll:

```php
// NEW: Grid class for card layouts
class PostGrid extends Grid
{
    public function schema(): array
    {
        return [
            CardComponent::make()
                ->image(fn ($record) => $record->featured_image)
                ->title(fn ($record) => $record->title)
                ->description(fn ($record) => $record->excerpt)
                ->footer([
                    TextComponent::make('author.name'),
                    BadgeComponent::make('status'),
                ]),
        ];
    }
}

// In Resource
class PostResource extends Resource
{
    // Choose display mode: 'table', 'grid', or 'both'
    protected static string $displayMode = 'both'; // User can toggle

    protected static string $gridClass = Grids\PostGrid::class;
    protected static string $tableClass = Tables\PostTable::class;
}
```

## Step-by-Step Migration

### Step 1: Install Laravilt

```bash
composer require laravilt/panel
php artisan laravilt:install
```

### Step 2: Convert Resources

#### Option A: Automatic Conversion (Recommended)

```bash
php artisan laravilt:convert-filament UserResource
```

This converts FilamentPHP Resource to Laravilt format automatically.

#### Option B: Manual Conversion

**Before (FilamentPHP v4)**:
```php
<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('email')->email()->required(),
            Forms\Components\Select::make('role')
                ->options([
                    'admin' => 'Admin',
                    'user' => 'User',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\BadgeColumn::make('role'),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
```

**After (Laravilt - Class-Based)**:

```php
<?php

namespace App\Laravilt\Resources;

use Laravilt\Panel\Resources\Resource;
use App\Models\User;

class UserResource extends Resource
{
    protected static string $model = User::class;
    protected static string $formClass = Forms\UserForm::class;
    protected static string $tableClass = Tables\UserTable::class;
}
```

```php
<?php

namespace App\Laravilt\Resources\Forms;

use Laravilt\Forms\Form;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Forms\Components\Select;

class UserForm extends Form
{
    public function schema(): array
    {
        return [
            TextInput::make('name')->required(),
            TextInput::make('email')->email()->required(),
            Select::make('role')
                ->options([
                    'admin' => 'Admin',
                    'user' => 'User',
                ])
                ->required(),
        ];
    }
}
```

```php
<?php

namespace App\Laravilt\Resources\Tables;

use Laravilt\Tables\Table;
use Laravilt\Tables\Columns\TextColumn;
use Laravilt\Tables\Columns\BadgeColumn;
use Laravilt\Tables\Filters\SelectFilter;
use Laravilt\Actions\EditAction;
use Laravilt\Actions\DeleteAction;

class UserTable extends Table
{
    public function columns(): array
    {
        return [
            TextColumn::make('name')->searchable(),
            TextColumn::make('email')->searchable(),
            BadgeColumn::make('role'),
            TextColumn::make('created_at')->dateTime(),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('role'),
        ];
    }

    public function actions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
```

### Step 3: Generate Multi-Platform Code

After converting your Resource, generate Vue/Flutter/API:

```bash
# Generate everything (Vue pages + Flutter module + API endpoints)
php artisan laravilt:generate UserResource

# Generate specific platforms
php artisan laravilt:generate UserResource --vue
php artisan laravilt:generate UserResource --flutter
php artisan laravilt:generate UserResource --api
```

This generates:
- ✅ Vue admin panel pages (list, create, edit, view)
- ✅ Flutter HMVC module with Riverpod state management
- ✅ REST API endpoints with Sanctum authentication
- ✅ API documentation
- ✅ TypeScript types for Vue
- ✅ Dart models for Flutter

### Step 4: Add Grid Display (Optional)

Add a Grid view for card-based display:

```bash
php artisan laravilt:make-grid UserGrid --resource=UserResource
```

Edit the generated Grid class:

```php
<?php

namespace App\Laravilt\Resources\Grids;

use Laravilt\Grids\Grid;
use Laravilt\Grids\Components\CardComponent;
use Laravilt\Grids\Components\TextComponent;
use Laravilt\Grids\Components\BadgeComponent;

class UserGrid extends Grid
{
    public function schema(): array
    {
        return [
            CardComponent::make()
                ->image(fn ($record) => $record->avatar)
                ->title(fn ($record) => $record->name)
                ->description(fn ($record) => $record->email)
                ->footer([
                    BadgeComponent::make('role'),
                    TextComponent::make('created_at')->dateTime(),
                ]),
        ];
    }
}
```

Update the Resource:

```php
class UserResource extends Resource
{
    protected static string $model = User::class;
    protected static string $formClass = Forms\UserForm::class;
    protected static string $tableClass = Tables\UserTable::class;
    protected static string $gridClass = Grids\UserGrid::class; // Add this
    protected static string $displayMode = 'both'; // Allow user to toggle
}
```

## Migration Checklist

- [ ] Install Laravilt
- [ ] Convert Resources from Filament format
- [ ] Update component imports (`Filament\Forms` → `Laravilt\Forms`)
- [ ] Test all Resources in browser
- [ ] Generate Vue pages
- [ ] Generate Flutter app
- [ ] Generate REST APIs
- [ ] Test multi-platform functionality
- [ ] Add Grid views where appropriate
- [ ] Set up AI agents (optional)
- [ ] Set up MCP servers (optional)

## Key Benefits After Migration

1. **Mobile App**: Your admin panel is now a Flutter mobile app
2. **REST API**: Auto-generated APIs for third-party integrations
3. **Better Performance**: SPA experience with Inertia.js
4. **Grid Display**: Card-based layouts with infinite scroll
5. **AI Integration**: Built-in AI agent and MCP server support
6. **Type Safety**: TypeScript for Vue, strong typing for Flutter

## Need Help?

- Documentation: `/docs/`
- Examples: `/docs/examples/`
- Issues: [GitHub Issues](https://github.com/laravilt/laravilt/issues)
- Discussions: [GitHub Discussions](https://github.com/laravilt/laravilt/discussions)

## What's Different in Resource Structure

### FilamentPHP v4 Convention

```php
class PostResource extends Resource
{
    // Methods defined directly in Resource class
    public static function form(Form $form): Form { }
    public static function table(Table $table): Table { }
    public static function infolist(Infolist $infolist): Infolist { }
    public static function getRelations(): array { }
    public static function getPages(): array { }
}
```

### Laravilt Convention (Recommended)

```php
// Main Resource - orchestrates everything
class PostResource extends Resource
{
    // Reference separate classes (better organization)
    protected static string $formClass = Forms\PostForm::class;
    protected static string $tableClass = Tables\PostTable::class;
    protected static string $gridClass = Grids\PostGrid::class;
    protected static string $infolistClass = Infolists\PostInfolist::class;
}

// Each aspect in its own class
class PostForm extends Form { }
class PostTable extends Table { }
class PostGrid extends Grid { }
class PostInfolist extends Infolist { }
```

### Laravilt Convention (Inline Alternative)

```php
// If you prefer Filament-style inline
class PostResource extends Resource
{
    // Same as Filament - methods return configured instances
    public static function form(Form $form): Form { }
    public static function table(Table $table): Table { }
    public static function grid(Grid $grid): Grid { } // NEW
    public static function infolist(Infolist $infolist): Infolist { }
}
```

**Both conventions are supported**. Class-based is recommended for:
- Better code organization
- Easier testing
- Better IDE support
- Reusability across Resources

## Component-Level Compatibility

All FilamentPHP v4 component methods work in Laravilt:

```php
// ✅ All these work in Laravilt exactly as in Filament
TextInput::make('name')
    ->label('Full Name')
    ->required()
    ->maxLength(255)
    ->default('John Doe')
    ->helperText('Enter your full name')
    ->placeholder('John Doe')
    ->disabled()
    ->dehydrated()
    ->reactive()
    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state)));

DatePicker::make('published_at')
    ->label('Publish Date')
    ->default(now())
    ->minDate(now())
    ->maxDate(now()->addYear())
    ->format('Y-m-d')
    ->displayFormat('F j, Y')
    ->native(false);

RichEditor::make('content')
    ->label('Content')
    ->required()
    ->toolbarButtons([
        'bold',
        'italic',
        'link',
    ])
    ->fileAttachmentsDirectory('uploads');
```

All of these serialize to Vue components and Flutter widgets automatically!
