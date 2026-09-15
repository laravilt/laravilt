---
title: Custom Tools
description: Write your own tools for AI function calling.
order: 3
---

# Custom Tools

`Laravilt\AI\Tools\Tool` is abstract. Extend it and implement `handle()`:

```php
use Illuminate\Support\Facades\Http;
use Laravilt\AI\Tools\Tool;

class WeatherTool extends Tool
{
    protected function handle(array $arguments): mixed
    {
        $weather = Http::get('https://api.example.com/weather', [
            'city' => $arguments['city'],
        ])->json();

        return [
            'city' => $arguments['city'],
            'temperature' => $weather['temp'] ?? null,
        ];
    }
}

$tool = WeatherTool::make('get_weather')
    ->description('Get the current weather for a city')
    ->addParameter('city', 'string', 'The city name', required: true);
```

## Closure handlers

When `handler()` is set, `execute()` calls the closure instead of `handle()`. You still need a concrete class, for example an anonymous one:

```php
use App\Models\Product;
use Laravilt\AI\Tools\Tool;

$tool = (new class('get_low_stock') extends Tool {
    protected function handle(array $arguments): mixed
    {
        return [];
    }
})
    ->description('Get products with low stock')
    ->addParameter('threshold', 'integer', 'Stock threshold', required: true)
    ->handler(fn (array $args) => Product::where('stock', '<', $args['threshold'])
        ->get(['id', 'name', 'stock'])
        ->toArray());
```

## Parameters

```php
$tool->addParameter('name', 'string', 'Product name', required: true);
$tool->addParameter('price', 'number', 'Product price');
$tool->addParameter('active', 'boolean', 'Is the product active');

// Or set them all at once
$tool->parameters([
    'name' => ['type' => 'string', 'description' => 'Product name', 'required' => true],
]);
```

`toArray()` turns the parameters into a JSON Schema object (`type`, `properties`, `required`) for the provider.

> `schema()` stores a custom schema on the tool, but `toArray()` builds the definition from the parameters. Use `addParameter()` or `parameters()` to shape what the model sees.

## Methods

| Method | Description |
|--------|-------------|
| `make(string $name)` | Create the tool |
| `description(string)` | Description sent to the model |
| `addParameter($name, $type, $description, $required = false)` | Add one parameter |
| `parameters(array)` | Replace all parameters |
| `handler(Closure)` | Use a closure instead of `handle()` |
| `execute(array $arguments)` | Run the tool |
| `toArray()` | Export the definition for providers |
