---
title: Sessions
description: Show active sessions and let users log out other devices.
order: 3
---

# Session Management

`->sessionManagement()` adds a **Sessions** page (`Laravilt\Auth\Pages\Profile\ManageSessions`) listing the user's active sessions. Each session shows its IP address, browser, platform, device and last activity, and the page can log out a single session or all other sessions.

```php
$panel->sessionManagement();
```

## Requirements

Sessions are read from the database, so use the database session driver:

```env
SESSION_DRIVER=database
```

Laravel 13 ships the `sessions` table migration by default. Device details are parsed with `jenssegers/agent`.

## Routes

```
GET     /{panel}/profile/sessions               List sessions
DELETE  /{panel}/profile/sessions/{sessionId}   Log out one session
DELETE  /{panel}/profile/sessions/others        Log out all other sessions
```

## In code

The `LaraviltUser` trait exposes the same data:

```php
$user->sessions();            // Collection of the user's sessions
$user->otherSessions();       // Excludes the current session
$user->deleteOtherSessions(); // Returns the number of sessions removed
```

## Related

- [API Tokens](api-tokens.md)
- [User Model](../user-model.md)
