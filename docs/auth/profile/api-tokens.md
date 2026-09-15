---
title: API Tokens
description: Let users create and revoke Sanctum personal access tokens.
order: 4
---

# API Tokens

`->apiTokens()` adds an **API tokens** page (`Laravilt\Auth\Pages\Profile\ManageApiTokens`). There, users can:

- create a token with a name and a set of abilities (the plain-text token is shown once),
- delete individual tokens,
- revoke all tokens after confirming their password.

```php
$panel->apiTokens();
```

Tokens are Laravel Sanctum personal access tokens. The `LaraviltUser` trait already includes `HasApiTokens`, and the auth migrations create `personal_access_tokens` if it doesn't exist.

## Routes

```
GET     /{panel}/profile/api-tokens            List tokens
POST    /{panel}/profile/api-tokens            Create a token
PUT     /{panel}/profile/api-tokens/{tokenId}  Update a token
DELETE  /{panel}/profile/api-tokens/{tokenId}  Delete a token
```

## Using a token

Send the token as a bearer token to any route protected by `auth:sanctum`:

```bash
curl -H "Authorization: Bearer <token>" https://your-app.test/api/user
```

Check abilities in your code with Sanctum's API:

```php
if ($request->user()->tokenCan('posts:write')) {
    // ...
}
```

## Related

- [Sessions](sessions.md)
- [Connected Accounts](connected-accounts.md)
