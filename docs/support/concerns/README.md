---
title: Concerns
description: Reusable traits for labels, visibility, state, layout and closure evaluation.
order: 2
---

# Concerns

The `Laravilt\Support\Concerns` traits are used by `Component` and by most form fields, table columns and schema components. Almost every setter also accepts a `Closure`, which is evaluated with [dependency injection](#evaluatesclosures).

| Trait | Methods |
|-------|---------|
| `CanBeDisabled` | `disabled(bool\|Closure $condition = true)`, `isDisabled()`, `isEnabled()` |
| `CanBeReadonly` | `readonly(bool\|Closure $condition = true)`, `isReadonly()` |
| `CanBeRequired` | `required(bool\|Closure $condition = true)`, `isRequired()` |
| `HasLabel` | `label(string\|Closure $label)`, `getLabel()` (generated from the name if not set) |
| `HasPlaceholder` | `placeholder(string\|Closure\|null $placeholder)`, `getPlaceholder()` |
| `HasHelperText` | `helperText(string\|Closure $text)`, `hint(string\|Closure $text)`, `getHelperText()` |
| `HasVisibility` | `hidden(bool\|Closure $condition = true)`, `visible(bool\|Closure $condition = true)`, `isHidden()`, `isVisible()` |
| `HasColumnSpan` | `columnSpan(int\|string\|array\|Closure $span)`, `columnStart(...)`, `columnSpanFull()`, `getColumnSpan()`, `getColumnStart()` |
| `HasId` | `id(string\|Closure\|null $id)`, `getId()` |
| `InteractsWithState` | `state(mixed $state)`, `default(mixed $state)`, `getState()`, `hasState()` |
| `EvaluatesClosures` | `evaluationContext(array $data = [], mixed $record = null, ?string $operation = null)`, `operation(?string)`, `getOperation()`, `getEvaluationRecord()` |

## Examples

```php
$component
    ->label('Email address')
    ->placeholder('you@example.com')
    ->helperText('We never share your email.')
    ->required()
    ->disabled(fn ($record) => $record?->is_locked)
    ->visible(fn ($operation) => $operation !== 'view')
    ->columnSpan(['default' => 1, 'md' => 2]);
```

## EvaluatesClosures

When a closure is evaluated, its parameters are injected by name or type. Available values include:

- `Get $get` and `Set $set`: read and write other fields' state (see [Utilities](../utilities.md))
- `$data`: the full evaluation data array
- `$record`: the current Eloquent record, if any
- `$operation`: `create`, `edit` or `view`
- `$state`: the component's current state

```php
use Laravilt\Support\Utilities\Get;

$component->visible(fn (Get $get) => $get('country') === 'US');
```

## Related

- [Component](../component.md)
- [Utilities](../utilities.md)
