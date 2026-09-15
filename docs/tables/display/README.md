---
title: Display
description: Table styling, empty states, pagination, and the card grid view.
order: 5
---

# Display

1. [Pagination](pagination.md): page sizes, extreme links, and infinite scroll
2. [Grid View](grid-view.md): show records as cards
3. [Cards](cards.md): card layouts and fields

## Row styling

```php
$table
    ->striped()
    ->hoverable();
```

## Empty state

```php
$table->emptyState(
    heading: 'No posts yet',
    description: 'Create your first post to get started.',
    icon: 'Inbox',
);

// or individually
$table
    ->emptyStateHeading('No records found')
    ->emptyStateDescription('Try adjusting your filters.')
    ->emptyStateIcon('SearchX');
```
