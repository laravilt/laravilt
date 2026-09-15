---
title: Perplexity
description: Use Perplexity Sonar models with built-in web search.
order: 5
---

# Perplexity Provider

`Laravilt\AI\Providers\PerplexityProvider` uses the Perplexity API (`https://api.perplexity.ai`). Sonar models answer with up-to-date web results.

## Configuration

```env
PERPLEXITY_API_KEY=...
PERPLEXITY_MODEL=sonar
# Optional
PERPLEXITY_BASE_URL=
PERPLEXITY_TEMPERATURE=0.7
PERPLEXITY_MAX_TOKENS=2048
```

## Models

`Laravilt\AI\Enums\PerplexityModel`:

| Case | Value |
|------|-------|
| `SONAR` | `sonar` (default) |
| `SONAR_PRO` | `sonar-pro` |
| `SONAR_REASONING` | `sonar-reasoning` |
| `SONAR_REASONING_PRO` | `sonar-reasoning-pro` |

## Registering the provider

`AIManager` does not build Perplexity from config automatically. Add it to a panel:

```php
use Laravilt\AI\Builders\AIProviderBuilder;

$panel->aiProviders(function (AIProviderBuilder $ai) {
    $ai->openai()->perplexity()->default('openai');
});
```

Or register it on the manager yourself:

```php
use Laravilt\AI\AIManager;
use Laravilt\AI\Providers\PerplexityProvider;

$ai = app(AIManager::class)->addProvider(new PerplexityProvider);

$response = $ai->provider('perplexity')->chat([
    ['role' => 'user', 'content' => 'What changed in the latest Laravel release?'],
]);

echo $response['content'];
```

`new PerplexityProvider` reads its key and model from `laravilt-ai.providers.perplexity`.
