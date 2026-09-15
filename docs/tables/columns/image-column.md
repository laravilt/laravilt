---
title: ImageColumn
description: Display single, circular, or stacked images in a table.
order: 2
---

# ImageColumn

```php
use Laravilt\Tables\Columns\ImageColumn;

ImageColumn::make('avatar')
    ->circular()
    ->imageSize(40);
```

## Shapes and sizes

```php
ImageColumn::make('photo')->square();
ImageColumn::make('avatar')->circular();

ImageColumn::make('cover')
    ->imageWidth(120)
    ->imageHeight(80);
```

## Stacked images

For attributes holding several image paths:

```php
ImageColumn::make('team_members')
    ->circular()
    ->stacked()
    ->ring(2)
    ->overlap(3)
    ->limit(3)
    ->limitedRemainingText();
```

## Storage and fallback

```php
ImageColumn::make('avatar')
    ->disk('s3')
    ->visibility('private')
    ->defaultImageUrl('/images/default-avatar.png')
    ->checkFileExistence();
```

## API reference

| Method | Description |
|--------|-------------|
| `circular()`, `square()` | Shape |
| `imageSize()`, `imageWidth()`, `imageHeight()` | Image dimensions |
| `stacked()`, `ring()`, `overlap()` | Stacked layout |
| `limit()`, `limitedRemainingText()` | Show at most N images plus a "+N" label |
| `wrap()` | Wrap images onto multiple lines |
| `disk()`, `visibility()` | Storage disk and visibility |
| `defaultImageUrl()` | Fallback image |
| `checkFileExistence()` | Use the fallback when the file is missing |
| `extraImgAttributes()` | Extra `<img>` attributes |
