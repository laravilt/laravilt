# Platform Parity Architecture

## Overview

Platform parity means that features defined in PHP work identically across all platforms: Vue (web), Flutter (mobile), and REST APIs. This document explains how we achieve this.

## The Challenge

Building admin panels that work on web and mobile typically requires:
- Writing UI code twice (web and mobile)
- Maintaining feature parity manually
- Synchronizing behavior and validation
- Duplicating business logic

Laravilt solves this by defining everything once in PHP and generating platform-specific implementations automatically.

## How It Works

### 1. Single Source of Truth (PHP)

```php
// app/Laravilt/Resources/UserResource/Forms/UserForm.php
class UserForm extends Form
{
    public function schema(): array
    {
        return [
            TextInput::make('name')
                ->label('Full Name')
                ->required()
                ->maxLength(255)
                ->placeholder('Enter your name'),

            TextInput::make('email')
                ->label('Email Address')
                ->email()
                ->required()
                ->unique(ignoreRecord: true),

            FileUpload::make('avatar')
                ->label('Profile Picture')
                ->image()
                ->maxSize(1024),
        ];
    }
}
```

### 2. Platform-Specific Generation

**Vue (Web)**:
```vue
<!-- Auto-generated: resources/js/Pages/Admin/Users/Create.vue -->
<template>
  <AppLayout>
    <Form :schema="form.schema" v-model="form.data">
      <template #actions>
        <Button type="submit">Create User</Button>
      </template>
    </Form>
  </AppLayout>
</template>

<script setup lang="ts">
const form = useForm({
  schema: props.formSchema, // From PHP
  data: {}
})
</script>
```

**Flutter (Mobile)**:
```dart
// Auto-generated: packages/features/users/lib/pages/create_user_page.dart
class CreateUserPage extends StatelessWidget {
  final Map<String, dynamic> formSchema;

  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Create User')),
      body: LaraviltForm(
        schema: formSchema, // From PHP via API
        onSubmit: (data) => _createUser(data),
      ),
    );
  }
}
```

**API Response**:
```json
{
  "form": {
    "schema": [
      {
        "name": "name",
        "label": "Full Name",
        "type": "text",
        "required": true,
        "maxLength": 255,
        "placeholder": "Enter your name",
        "validation": {
          "required": true,
          "max": 255
        }
      },
      {
        "name": "email",
        "label": "Email Address",
        "type": "email",
        "required": true,
        "validation": {
          "required": true,
          "email": true,
          "unique": {
            "table": "users",
            "column": "email"
          }
        }
      }
    ]
  }
}
```

## Platform-Specific Adaptations

### Component Mapping

Each PHP component maps to platform-specific implementations:

```php
// PHP
TextInput::make('email')->email()->required()

// Maps to Vue
<TextInput type="email" required />

// Maps to Flutter
LaraviltTextInput(
  inputType: TextInputType.emailAddress,
  required: true,
)
```

### Platform Adapter Pattern

```php
// packages/laravilt/core/src/Component.php
abstract class Component
{
    public function toInertiaProps(): array
    {
        return [
            'component' => $this->getVueComponent(),
            'props' => $this->getVueProps(),
        ];
    }

    public function toFlutterProps(): array
    {
        return [
            'widget' => $this->getFlutterWidget(),
            'props' => $this->getFlutterWidgetProps(),
        ];
    }

    // Platform-specific implementations
    abstract protected function getVueComponent(): string;
    abstract protected function getVueProps(): array;
    abstract protected function getFlutterWidget(): string;
    abstract protected function getFlutterWidgetProps(): array;
}
```

## Feature Parity Matrix

### Forms

| Feature | PHP | Vue | Flutter | API |
|---------|-----|-----|---------|-----|
| Text Input | ✅ | ✅ | ✅ | ✅ |
| Textarea | ✅ | ✅ | ✅ | ✅ |
| Select | ✅ | ✅ | ✅ | ✅ |
| File Upload | ✅ | ✅ | ✅ | ✅ |
| Date Picker | ✅ | ✅ | ✅ | ✅ |
| Rich Editor | ✅ | ✅ | ✅ | ✅ |
| Repeater | ✅ | ✅ | ✅ | ✅ |
| Validation | ✅ | ✅ | ✅ | ✅ |

### Tables

| Feature | PHP | Vue | Flutter | API |
|---------|-----|-----|---------|-----|
| Columns | ✅ | ✅ | ✅ | ✅ |
| Sorting | ✅ | ✅ | ✅ | ✅ |
| Filtering | ✅ | ✅ | ✅ | ✅ |
| Pagination | ✅ | ✅ | ✅ | ✅ |
| Search | ✅ | ✅ | ✅ | ✅ |
| Bulk Actions | ✅ | ✅ | ✅ | ✅ |

### Grids

| Feature | PHP | Vue | Flutter | API |
|---------|-----|-----|---------|-----|
| Cards | ✅ | ✅ | ✅ | ✅ |
| Infinite Scroll | ✅ | ✅ | ✅ | ✅ |
| Filtering | ✅ | ✅ | ✅ | ✅ |
| Sorting | ✅ | ✅ | ✅ | ✅ |
| Layouts | ✅ | ✅ | ✅ | ✅ |

## Validation Parity

Validation rules defined in PHP are enforced on all platforms:

```php
TextInput::make('email')
    ->required()
    ->email()
    ->unique('users', 'email')
    ->maxLength(255)
```

**Vue (Client-side)**:
```typescript
const rules = {
  email: [
    { required: true, message: 'Email is required' },
    { type: 'email', message: 'Invalid email format' },
    { max: 255, message: 'Maximum 255 characters' },
    // unique checked on server
  ]
}
```

**Flutter (Client-side)**:
```dart
final validators = [
  RequiredValidator(),
  EmailValidator(),
  MaxLengthValidator(255),
  // unique checked on server
];
```

**API (Server-side)**:
```php
$request->validate([
    'email' => ['required', 'email', 'unique:users,email', 'max:255'],
]);
```

## State Management Parity

### Vue (Inertia)
- Form state managed by Inertia's `useForm`
- Automatic CSRF protection
- Optimistic UI updates
- Error handling

### Flutter (Riverpod)
- Form state managed by Riverpod providers
- API token authentication (Sanctum)
- Optimistic UI updates
- Error handling

### Synchronization
Both platforms receive the same data structure:

```json
{
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "meta": {
    "validation_rules": {...},
    "can": {
      "update": true,
      "delete": false
    }
  }
}
```

## Platform-Specific Features

Some features are platform-specific due to technical limitations:

### Web-Only Features
- SSR (Server-Side Rendering)
- SEO optimization
- Browser-specific APIs

### Mobile-Only Features
- Offline storage
- Push notifications (native)
- Biometric authentication
- Camera access

### Handling Platform Differences

```php
TextInput::make('photo')
    ->when(
        request()->isInertia(),
        fn($field) => $field->fileUpload(),
        fn($field) => $field->camera(), // Flutter: use camera
    );
```

## API Versioning

APIs support versioning for backward compatibility:

```php
// routes/api/v1.php
Route::apiResource('users', UserController::class);

// routes/api/v2.php (with breaking changes)
Route::apiResource('users', V2\UserController::class);
```

Flutter apps can target specific API versions:

```dart
final apiClient = LaraviltApiClient(
  baseUrl: 'https://api.example.com',
  version: 'v1',
);
```

## Testing Parity

Tests verify behavior is consistent across platforms:

```php
// tests/Feature/UserFormTest.php
it('validates email uniqueness', function() {
    // Test PHP validation
});
```

```typescript
// tests/vue/UserForm.spec.ts
it('validates email uniqueness', () => {
    // Test Vue validation
})
```

```dart
// tests/flutter/user_form_test.dart
test('validates email uniqueness', () {
    // Test Flutter validation
});
```

## Performance Considerations

### Vue (Web)
- Vite for fast builds
- Code splitting
- Lazy loading
- SSR for initial load

### Flutter (Mobile)
- Ahead-of-time compilation
- Tree shaking
- Image optimization
- Lazy loading lists

### API
- Response caching
- Database query optimization
- Eager loading (N+1 prevention)
- API rate limiting

## Deployment Strategy

### Web (Vue)
- Build assets: `npm run build`
- Deploy Laravel app
- CDN for static assets

### Mobile (Flutter)
- Build APK/IPA: `flutter build`
- Submit to stores
- OTA updates for non-native changes

### API
- Same Laravel deployment
- Versioned endpoints
- Backward compatibility

## Benefits of Platform Parity

1. **Single Source of Truth**: Define once, use everywhere
2. **Consistency**: Same UX across platforms
3. **Maintainability**: Update in one place
4. **Type Safety**: TypeScript + Dart from PHP definitions
5. **Testing**: Test once, verify everywhere
6. **Documentation**: Generate from PHP definitions

## Trade-offs

### Pros
- Fast development
- Consistent UX
- Easy maintenance
- Automatic updates

### Cons
- Less platform-specific optimization
- Learning curve for the abstraction
- Some features require platform-specific code

## Next Steps

- Read `03-component-system.md` for package organization
- Read `02-CORE-CONCEPTS/` for specific implementations
- Read `04-IMPLEMENTATION-GUIDES/` to build this system
