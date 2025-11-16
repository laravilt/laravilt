# Component System Architecture

## Overview

Every UI element in Laravilt is a **Component**. Components are defined once in PHP and automatically rendered in Vue (web) and Flutter (mobile). This creates perfect platform parity while maintaining a single source of truth.

## Core Principle

```
PHP Component Definition (Single Source of Truth)
    ↓
Serialize to Props/Schema
    ↓
├─→ Vue Component (receives props, renders UI)
├─→ Flutter Widget (receives props, renders UI)
└─→ API Response (returns schema + data for custom clients)
```

## Component Hierarchy

```
Component (abstract base)
├── FieldComponent (form fields)
│   ├── TextInput
│   ├── Textarea
│   ├── Select
│   ├── Checkbox
│   ├── Radio
│   ├── Toggle
│   ├── FileUpload
│   ├── DatePicker
│   ├── RichEditor
│   ├── Repeater
│   └── [30+ more field types]
│
├── ColumnComponent (table columns)
│   ├── TextColumn
│   ├── ImageColumn
│   ├── IconColumn
│   ├── BadgeColumn
│   ├── BooleanColumn
│   ├── DateColumn
│   ├── SelectColumn (inline editing)
│   └── [20+ more column types]
│
├── CardComponent (grid cards)
│   ├── ProductCard
│   ├── ProfileCard
│   ├── PostCard
│   ├── ImageCard
│   ├── CustomCard
│   └── [10+ more card types]
│
├── EntryComponent (infolist entries)
│   ├── TextEntry
│   ├── ImageEntry
│   ├── IconEntry
│   ├── KeyValueEntry
│   └── [15+ more entry types]
│
├── ActionComponent (actions)
│   ├── Action
│   ├── ActionGroup
│   ├── BulkAction
│   └── [10+ more action types]
│
├── WidgetComponent (dashboard widgets)
│   ├── StatsWidget
│   ├── ChartWidget
│   ├── TableWidget
│   └── [custom widgets]
│
└── PageComponent (pages)
    ├── ListPage
    ├── CreatePage
    ├── EditPage
    ├── ViewPage
    └── [custom pages]
```

## Component Lifecycle

### 1. PHP Definition

```php
use Laravilt\Forms\Components\TextInput;

$component = TextInput::make('name')
    ->label('Full Name')
    ->required()
    ->maxLength(255)
    ->placeholder('Enter your name')
    ->hint('This will be displayed publicly')
    ->prefix('👤')
    ->suffix('.com');
```

### 2. Serialization to Inertia Props

```php
$component->toInertiaProps();

// Returns:
[
    'name' => 'name',
    'label' => 'Full Name',
    'required' => true,
    'maxLength' => 255,
    'placeholder' => 'Enter your name',
    'hint' => 'This will be displayed publicly',
    'prefix' => '👤',
    'suffix' => '.com',
    'component' => 'TextInput', // Vue component name
    'props' => [...], // Vue-specific props
]
```

### 3. Serialization to Flutter JSON

```php
$component->toFlutterProps();

// Returns:
[
    'name' => 'name',
    'label' => 'Full Name',
    'required' => true,
    'maxLength' => 255,
    'placeholder' => 'Enter your name',
    'hint' => 'This will be displayed publicly',
    'prefix' => '👤',
    'suffix' => '.com',
    'widget' => 'LaraviltTextInput', // Flutter widget name
    'props' => [...], // Flutter-specific props
]
```

### 4. Vue Rendering

```vue
<script setup lang="ts">
import { TextInput } from '@laravilt/forms'

interface Props {
  field: {
    name: string
    label: string
    required: boolean
    maxLength: number
    placeholder: string
    hint: string
    prefix: string
    suffix: string
    props: Record<string, any>
  }
  modelValue: string
}

const props = defineProps<Props>()
const emit = defineEmits(['update:modelValue'])
</script>

<template>
  <TextInput
    v-bind="field.props"
    :model-value="modelValue"
    @update:model-value="emit('update:modelValue', $event)"
  />
</template>
```

### 5. Flutter Rendering

```dart
import 'package:laravilt_forms/laravilt_forms.dart';

class FormField extends StatelessWidget {
  final Map<String, dynamic> field;
  final String? value;
  final Function(String?) onChanged;

  Widget build(BuildContext context) {
    return LaraviltTextInput(
      name: field['name'],
      label: field['label'],
      required: field['required'] ?? false,
      maxLength: field['maxLength'],
      placeholder: field['placeholder'],
      hint: field['hint'],
      prefix: field['prefix'],
      suffix: field['suffix'],
      value: value,
      onChanged: onChanged,
    );
  }
}
```

## Component Base Class

### PHP Base Implementation

```php
// packages/laravilt/core/src/Component.php
namespace Laravilt\Core;

use Closure;
use Laravilt\Core\Contracts\Buildable;
use Laravilt\Core\Contracts\InertiaSerializable;
use Laravilt\Core\Contracts\FlutterSerializable;

abstract class Component implements
    Buildable,
    InertiaSerializable,
    FlutterSerializable
{
    protected string $name;
    protected ?string $label = null;
    protected ?string $hint = null;
    protected bool $required = false;
    protected bool $hidden = false;
    protected bool $disabled = false;
    protected ?Closure $visibleUsing = null;
    protected array $extraAttributes = [];

    /**
     * Create a new component instance
     */
    public static function make(string $name): static
    {
        $component = new static();
        $component->name = $name;
        return $component;
    }

    /**
     * Set the label
     */
    public function label(string $label): static
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Set the hint text
     */
    public function hint(string $hint): static
    {
        $this->hint = $hint;
        return $this;
    }

    /**
     * Mark as required
     */
    public function required(bool $required = true): static
    {
        $this->required = $required;
        return $this;
    }

    /**
     * Hide the component
     */
    public function hidden(bool $hidden = true): static
    {
        $this->hidden = $hidden;
        return $this;
    }

    /**
     * Conditionally show/hide
     */
    public function visible(Closure $callback): static
    {
        $this->visibleUsing = $callback;
        return $this;
    }

    /**
     * Disable the component
     */
    public function disabled(bool $disabled = true): static
    {
        $this->disabled = $disabled;
        return $this;
    }

    /**
     * Add extra HTML attributes
     */
    public function extraAttributes(array $attributes): static
    {
        $this->extraAttributes = array_merge($this->extraAttributes, $attributes);
        return $this;
    }

    /**
     * Convert to Inertia props for Vue
     */
    public function toInertiaProps(): array
    {
        return [
            'name' => $this->name,
            'label' => $this->label,
            'hint' => $this->hint,
            'required' => $this->required,
            'hidden' => $this->evaluateHidden(),
            'disabled' => $this->disabled,
            'component' => $this->getVueComponent(),
            'props' => array_merge(
                $this->getVueProps(),
                ['extraAttributes' => $this->extraAttributes]
            ),
        ];
    }

    /**
     * Convert to Flutter props
     */
    public function toFlutterProps(): array
    {
        return [
            'name' => $this->name,
            'label' => $this->label,
            'hint' => $this->hint,
            'required' => $this->required,
            'hidden' => $this->evaluateHidden(),
            'disabled' => $this->disabled,
            'widget' => $this->getFlutterWidget(),
            'props' => $this->getFlutterWidgetProps(),
        ];
    }

    /**
     * Evaluate visibility
     */
    protected function evaluateHidden(): bool
    {
        if ($this->hidden) {
            return true;
        }

        if ($this->visibleUsing) {
            return ! ($this->visibleUsing)();
        }

        return false;
    }

    /**
     * Get Vue component name (must implement in subclass)
     */
    abstract protected function getVueComponent(): string;

    /**
     * Get Vue-specific props (must implement in subclass)
     */
    abstract protected function getVueProps(): array;

    /**
     * Get Flutter widget name (must implement in subclass)
     */
    abstract protected function getFlutterWidget(): string;

    /**
     * Get Flutter-specific props (must implement in subclass)
     */
    abstract protected function getFlutterWidgetProps(): array;
}
```

## Component Contracts

### Buildable Contract

```php
// packages/laravilt/core/src/Contracts/Buildable.php
namespace Laravilt\Core\Contracts;

interface Buildable
{
    /**
     * Create a new component instance with fluent interface
     */
    public static function make(string $name): static;
}
```

### InertiaSerializable Contract

```php
// packages/laravilt/core/src/Contracts/InertiaSerializable.php
namespace Laravilt\Core\Contracts;

interface InertiaSerializable
{
    /**
     * Convert component to Inertia props for Vue rendering
     */
    public function toInertiaProps(): array;
}
```

### FlutterSerializable Contract

```php
// packages/laravilt/core/src/Contracts/FlutterSerializable.php
namespace Laravilt\Core\Contracts;

interface FlutterSerializable
{
    /**
     * Convert component to Flutter-compatible JSON
     */
    public function toFlutterProps(): array;
}
```

## Component Registration

### ComponentRegistry

```php
// packages/laravilt/core/src/ComponentRegistry.php
namespace Laravilt\Core;

class ComponentRegistry
{
    protected static array $components = [];

    /**
     * Register a component
     */
    public static function register(string $name, string $class): void
    {
        if (! is_subclass_of($class, Component::class)) {
            throw new \InvalidArgumentException(
                "Component {$class} must extend " . Component::class
            );
        }

        static::$components[$name] = $class;
    }

    /**
     * Get registered component class
     */
    public static function get(string $name): ?string
    {
        return static::$components[$name] ?? null;
    }

    /**
     * Get all registered components
     */
    public static function all(): array
    {
        return static::$components;
    }

    /**
     * Check if component is registered
     */
    public static function has(string $name): bool
    {
        return isset(static::$components[$name]);
    }

    /**
     * Auto-discover components in a directory
     */
    public static function discoverComponents(string $namespace, string $directory): void
    {
        if (! is_dir($directory)) {
            return;
        }

        $files = glob($directory . '/*.php');

        foreach ($files as $file) {
            $className = basename($file, '.php');
            $class = $namespace . '\\' . $className;

            if (class_exists($class) && is_subclass_of($class, Component::class)) {
                static::register($className, $class);
            }
        }
    }
}
```

## Example: TextInput Component

See `02-CORE-CONCEPTS/02-forms.md` for complete TextInput implementation example.

## Component Best Practices

### 1. Single Responsibility
Each component should do one thing well. Don't create "mega components" that try to handle multiple use cases.

### 2. Fluent Interface
All configuration methods should return `static` for method chaining.

### 3. Sensible Defaults
Components should work with minimal configuration. Required options should be obvious.

### 4. Platform Parity
Ensure the component behaves consistently across Vue and Flutter platforms.

### 5. Type Safety
Use TypeScript for Vue components and proper Dart types for Flutter widgets.

### 6. Documentation
Every component must have documentation with examples.

### 7. Testing
Every component must have unit tests (PHP, Vue, Flutter).

## Next Steps

- Read `02-CORE-CONCEPTS/` to understand how components are used in Forms, Tables, Grids, etc.
- Read `03-COMPONENT-SYSTEM/04-custom-components.md` to learn how to create custom components
- Read `04-IMPLEMENTATION-GUIDES/` to follow the implementation sprint by sprint
