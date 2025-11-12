# Vue Starter Kit Blueprint

This directory contains the blueprint for the Laravel Vue starter kit that Laravilt uses as its foundation.

## Structure

```
vue-starter-kit/
├── js/
│   ├── app.ts.stub           # Main application entry point
│   ├── ssr.ts.stub            # SSR entry point
│   ├── components/            # Reusable Vue components
│   ├── composables/           # Vue composables
│   │   ├── useAppearance.ts.stub
│   │   └── useInitials.ts.stub
│   ├── layouts/               # Layout components
│   ├── lib/                   # Utility functions
│   │   └── utils.ts.stub
│   ├── pages/                 # Inertia pages
│   └── types/                 # TypeScript type definitions
│       └── index.d.ts.stub
├── css/
│   └── app.css.stub           # Main CSS file with Tailwind
└── config/
    ├── vite.config.ts.stub    # Vite configuration
    └── tsconfig.json.stub     # TypeScript configuration
```

## What's Included

### Core Files
- **app.ts**: Inertia.js app initialization with Vue 3
- **ssr.ts**: Server-side rendering setup
- **app.css**: Tailwind CSS v4 with custom theme configuration

### Composables
- **useAppearance**: Theme management (light/dark/system) with SSR support
- **useInitials**: User initials generation utility

### Utilities
- **utils.ts**: Common utility functions (cn, etc.)

### Type Definitions
- **index.d.ts**: Global TypeScript interfaces for the application

### Configuration
- **vite.config.ts**: Complete Vite setup with Laravel plugin, Vue, Wayfinder, and Tailwind
- **tsconfig.json**: TypeScript compiler configuration

## Tech Stack

- **Vue 3** - Composition API with `<script setup>`
- **TypeScript 5.6** - Type-safe development
- **Inertia.js v2** - Server-side routing with SPA experience
- **Tailwind CSS v4** - CSS-first configuration with `@theme`
- **Vite 7** - Fast build tool
- **Laravel Wayfinder** - Type-safe route generation

## Usage

The `InstallCommand` uses these files to set up a fresh Laravel installation with Vue + Inertia.

### Installation Flow

1. Copy stub files to appropriate locations in the Laravel project
2. Replace package-specific imports with local imports
3. Install required npm dependencies
4. Configure Vite and TypeScript

## Notes

- All files use `.stub` extension to prevent them from being processed by build tools
- Import paths should be rewritten during installation:
  - `@laravilt/support/*` → `@/*`
  - `@laravilt/panel/*` → `@/Components/laravilt/*`
- SSR support is built-in and enabled by default
- Theme system uses both cookies (SSR) and localStorage (client)
