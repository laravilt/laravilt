---
title: Polling
description: Refresh table data automatically at an interval.
order: 7
---

# Polling

```php
$table->poll('10s');
```

The interval is a string such as `'5s'`, `'30s'`, or `'1m'`. Pass `null` to disable polling (the default).

## API reference

| Method | Description |
|--------|-------------|
| `poll(?string $interval)` | Auto-refresh interval |
