# Laravilt Framework - Project Overview

## Vision

A complete full-stack framework that generates admin panels, frontend applications, and mobile apps from a single PHP Resource definition, with built-in AI agent and MCP server support.

## Core Principles

1. **PHP Controls Everything**: Define once in PHP, generate for all platforms (Vue web, Flutter mobile, APIs)
2. **Component System**: Everything is a component - Form fields, Table columns, Grid cards, InfoList entries
3. **Platform Parity**: Same features and behavior across Vue (web), Flutter (mobile), and REST APIs
4. **Class-Based Architecture**: Resources use separate classes for Form/Table/Grid/InfoList (with inline option for simple cases)
5. **AI-First**: Easy creation of AI agents and MCP servers integrated with your Resources
6. **Modular & Open Source**: Package-based architecture, all packages published to Packagist/pub.dev

## What Laravilt Replaces

- **Filament + Livewire** → Laravilt + Inertia + Vue (for web admin)
- **Manual Flutter Development** → Auto-generated Flutter HMVC modules
- **Manual API Development** → Auto-generated REST APIs with Sanctum auth
- **Manual AI Integration** → Built-in AI agent and MCP server builders

## Target Users

- Laravel developers building admin panels
- Teams building full-stack applications (web + mobile)
- Developers migrating from Filament/Livewire
- Agencies building multiple client projects
- Developers building AI-integrated applications

## Tech Stack

### Backend
- Laravel 12
- Inertia.js v2
- Laravel Sanctum (API authentication)
- Laravel Fortify (web authentication)
- Laravel Wayfinder (type-safe routes)
- Laravel Reverb (optional real-time)
- Laravel Horizon (optional queue monitoring)
- Laravel Scout (optional search)
- Laravel Octane (optional performance)

### Frontend (Web)
- Vue 3 (Composition API)
- TypeScript
- Tailwind CSS v4
- Reka UI (headless components)
- Vite

### Mobile
- Flutter
- Riverpod (state management)
- Freezed (immutable models)
- Dio (HTTP client)

### AI & MCP
- OpenAI, Anthropic, Local LLMs
- Model Context Protocol (MCP) servers
- Built-in tool generation from Resources

### Testing
- Pest v4 (PHP)
- PHPStan Level 8 (static analysis)
- Laravel Pint (code style)
- Vitest (Vue)
- Flutter Test (Dart)

## Architecture Highlights

### Monorepo Structure
```
packages/laravilt/
├── support/           # Foundation utilities
├── core/              # Component base system
├── ui/                # Base UI components
├── forms/             # Form builder (PHP + Vue + Flutter)
├── tables/            # Table builder (PHP + Vue + Flutter)
├── grids/             # Grid/card builder (PHP + Vue + Flutter)
├── infolists/         # InfoList builder (PHP + Vue + Flutter)
├── actions/           # Actions (PHP + Vue + Flutter)
├── notifications/     # Notifications (PHP + Vue + Flutter)
├── widgets/           # Widgets (PHP + Vue + Flutter)
├── query-builder/     # Advanced filtering
├── ai/                # AI agent builder
├── mcp/               # MCP server builder
└── panel/             # Main orchestrator
```

### Component System Flow
```
PHP Component Definition
    ↓
Generates Props/Schema
    ↓
├─→ Vue Component (receives props, renders)
├─→ Flutter Widget (receives props, renders)
└─→ API Response (returns schema + data)
```

### Resource Architecture
```php
// Single Resource definition
class UserResource extends Resource
{
    // Separate class files (recommended)
    protected static string $formClass = Forms\UserForm::class;
    protected static string $tableClass = Tables\UserTable::class;
    protected static string $gridClass = Grids\UserGrid::class;

    // OR inline for simple cases
    public static function form(Form $form): Form { ... }
}
```

### Generated Output
From one Resource, generates:
- Vue admin panel pages (list, create, edit, view)
- Flutter HMVC module (same pages)
- REST API endpoints (CRUD + filters)
- AI Agent with tools
- MCP Server tools/resources

## Key Features

### Display Modes
- **Table**: Traditional data tables with sorting, filtering, pagination
- **Grid**: Card-based layouts with infinite scroll
- **InfoList**: Read-only detail views
- **Both**: Toggle between Table and Grid

### Advanced Features
- Infinite scroll support
- Real-time updates (via Reverb)
- Multi-tenancy ready
- Role-based access control
- Global search (via Scout)
- File uploads with media library
- Rich text editors
- Repeater fields
- Form builder fields
- Custom components

### AI Integration
- Generate AI agents that can manage Resources
- Expose Resources as MCP tools automatically
- Custom prompts and tools
- Support for OpenAI, Anthropic, Local LLMs

## Project Structure

```
laravilt/
├── app/
│   ├── Laravilt/
│   │   ├── Resources/          # Your Resources
│   │   │   └── UserResource/
│   │   │       ├── Forms/      # Form classes
│   │   │       ├── Tables/     # Table classes
│   │   │       ├── Grids/      # Grid classes
│   │   │       └── InfoLists/  # InfoList classes
│   │   ├── Pages/              # Custom pages
│   │   ├── Widgets/            # Custom widgets
│   │   ├── Agents/             # AI agents
│   │   ├── MCP/                # MCP servers
│   │   └── Components/         # Custom components
│   └── Http/
│       └── Controllers/
│           └── Api/            # Auto-generated API controllers
├── packages/laravilt/          # Framework packages
├── flutter_app/                # Generated Flutter app
│   └── packages/features/      # HMVC feature modules
├── resources/
│   └── js/
│       └── Pages/              # Vue pages
├── routes/
│   ├── web.php                 # Vue panel routes
│   └── api.php                 # Auto-generated API routes
├── docs/                       # This documentation
└── tests/
    ├── php/                    # PHP tests
    ├── vue/                    # Vue tests
    └── flutter/                # Flutter tests
```

## Development Phases

### Phase 1: Foundation (Weeks 1-3)
- Monorepo setup
- Package generator command
- `laravilt/support` - Foundation utilities
- `laravilt/core` - Component base system
- `laravilt/ui` - Base UI components
- Testing infrastructure

### Phase 2: Core Features (Weeks 4-9)
- `laravilt/forms` - Form builder
- `laravilt/tables` - Table builder
- `laravilt/grids` - Grid/card builder
- `laravilt/actions` - Actions
- `laravilt/notifications` - Notifications

### Phase 3: Advanced Features (Weeks 10-11)
- `laravilt/widgets` - Dashboard widgets
- `laravilt/infolists` - Detail views
- `laravilt/query-builder` - Advanced filtering

### Phase 4: Panel & Generation (Weeks 12-13)
- `laravilt/panel` - Main orchestrator
- Resource generation commands
- Vue + Flutter + API generation
- Class-based Resource architecture

### Phase 5: AI Integration (Weeks 14-15)
- `laravilt/ai` - AI agent builder
- `laravilt/mcp` - MCP server builder
- Auto-registration of Resources as tools

### Phase 6: Polish & Publishing (Weeks 16-18)
- Complete documentation
- Example applications
- Video tutorials
- Migration guides
- Publish to Packagist & pub.dev

## Success Criteria

### Technical
- [ ] All 13 packages published
- [ ] Test coverage > 80% (PHP), > 70% (Vue/Flutter)
- [ ] PHPStan Level 8 passing
- [ ] All packages have complete documentation
- [ ] Example applications working

### User Experience
- [ ] Generate complete Resource in < 5 minutes
- [ ] Single command creates Vue + Flutter + API
- [ ] Create AI agent in < 5 minutes
- [ ] MCP server running in Claude Desktop
- [ ] Filament migration tool works accurately

### Performance
- [ ] Table with 10K rows loads in < 2s
- [ ] Grid infinite scroll smooth at 60fps
- [ ] API response time < 200ms
- [ ] Flutter app startup < 3s

## Getting Started

Once documentation is complete, see:
1. `01-ARCHITECTURE/` - Understand the framework architecture
2. `02-CORE-CONCEPTS/` - Learn core concepts
3. `03-COMPONENT-SYSTEM/` - Understand component system
4. `04-IMPLEMENTATION-GUIDES/` - Follow sprint-by-sprint implementation guides

## Contributing

This is an open-source project. Contributions are welcome!

- GitHub: https://github.com/laravilt/laravilt
- Sponsor: https://github.com/sponsors/fadymondy
- Documentation: https://laravilt.com/docs
- Discord: https://discord.gg/laravilt

## License

MIT License - see LICENSE.md for details.

## Acknowledgments

Inspired by:
- Filament PHP (admin panel design patterns)
- Livewire (component approach)
- Inertia.js (SPA without API complexity)
- Flutter (mobile-first thinking)

---

**Status**: Documentation Phase (Week 0)
**Next**: Create Architecture documentation
