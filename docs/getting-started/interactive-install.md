---
title: Installer Prompts
description: Every question php artisan laravilt:install asks, and the files it creates.
order: 3
---

# Installer Prompts

`php artisan laravilt:install` gathers all answers first, then runs every step without further questions.

## 1. Frontend stack

```
┌ Which frontend stack would you like to use? ─────────────┐
│ › ● Vue 3 (Inertia + shadcn-vue)                         │
│   ○ React 19 (Inertia + shadcn/ui)                       │
└──────────────────────────────────────────────────────────┘
```

The default matches your starter kit (detected from `package.json`). Pass `--stack=vue` or `--stack=react` to skip this question.

> React support requires Laravilt v1.1 or later.

## 2. Panel identifier

```
┌ What is the panel identifier? ───────────────────────────┐
│ admin                                                    │
└──────────────────────────────────────────────────────────┘
```

Used as the URL path (`/admin`) and the class name (`AdminPanelProvider`). This and the next questions are skipped with `--skip-panel`.

## 3. Panel features

```
┌ Which features would you like to enable? ────────────────┐
│ ◼ Login page                                             │
│ ◻ User registration                                      │
│ ◼ Password reset                                         │
│ ◻ Email verification                                     │
│ ◻ OTP authentication                                     │
│ ◻ Magic link login                                       │
│ ◻ Two-factor authentication (2FA)                        │
│ ◻ Passkey authentication (WebAuthn)                      │
│ ◻ Session management                                     │
│ ◼ User profile management                                │
│ ◻ Social login (OAuth)                                   │
│ ◻ Connected accounts                                     │
│ ◻ API tokens                                             │
│ ◼ Database notifications                                 │
│ ◻ Locale & timezone settings                             │
│ ◻ Global search                                          │
│ ◻ AI assistant                                           │
└──────────────────────────────────────────────────────────┘
```

Some features ask a follow-up question:

- **Two-factor:** TOTP (authenticator app) and/or email code.
- **Social login:** Google, GitHub, Facebook, Twitter/X, LinkedIn, Discord.
- **AI assistant:** the OpenAI model (GPT-4o Mini by default).

Each selected feature becomes a method on the generated panel (`->login()`, `->passkeys()`, `->twoFactor(...)` and so on). See [Auth](../auth/README.md).

## 4. Admin user

```
┌ Would you like to create an admin user after installation? ┐
│ Yes                                                        │
└────────────────────────────────────────────────────────────┘
```

If you answer yes, `laravilt:user` runs at the end and asks for name, email and password. It isn't offered in non-interactive runs.

## What gets created

```
app/
├── Laravilt/Admin/
│   ├── Pages/Dashboard.php
│   ├── Resources/
│   └── Widgets/
├── Models/User.php                      # published with Laravilt's traits
└── Providers/Laravilt/AdminPanelProvider.php
bootstrap/providers.php                  # AdminPanelProvider registered
config/                                  # Laravilt package configs
resources/js/                            # the Vue or React app shell
.env                                     # LARAVILT_FRONTEND=vue|react
```

Next: [Quick Start](quick-start.md).
