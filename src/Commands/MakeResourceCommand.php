<?php

declare(strict_types=1);

namespace Laravilt\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class MakeResourceCommand extends Command
{
    protected $signature = 'laravilt:resource {name? : The name of the resource class}
                            {--model= : The model class name}
                            {--table= : The database table name}
                            {--generate : Generate model, migration, and factory}
                            {--pages= : Comma-separated list of pages (list,create,edit,view)}
                            {--view= : List view type (table, grid, or both)}
                            {--force : Overwrite existing files}';

    protected $description = 'Create a new Laravilt resource with pages, form, table, and infolist';

    protected array $tableColumns = [];

    public function handle(): int
    {
        // Get all database tables using database-agnostic method
        $tableNames = Schema::getTables();
        $tableNames = array_map(fn ($table) => $table['name'], $tableNames);

        // Filter out system tables
        $tableNames = array_filter($tableNames, function ($table) {
            return ! in_array($table, ['migrations', 'password_reset_tokens', 'sessions', 'cache', 'cache_locks', 'jobs', 'job_batches', 'failed_jobs']);
        });

        // Find tables that already have resources
        $tablesWithResources = [];
        $resourcesPath = app_path('Laravilt/Resources');
        if (File::exists($resourcesPath)) {
            $resourceDirs = File::directories($resourcesPath);
            foreach ($resourceDirs as $dir) {
                $dirName = basename($dir);
                // Convert resource folder name to table name
                $tableName = Str::plural(Str::snake($dirName));
                $tablesWithResources[] = $tableName;
            }
        }

        // Get tables without resources
        $tablesWithoutResources = array_diff($tableNames, $tablesWithResources);

        // Ask for table name - use dropdown if tables exist, otherwise text input
        if (! empty($tablesWithoutResources) && ! $this->option('table')) {
            $tableOptions = array_combine($tablesWithoutResources, $tablesWithoutResources);
            $tableOptions['__custom__'] = '-- Enter custom table name --';

            $tableName = select(
                label: 'Select a table to generate resource for',
                options: $tableOptions,
                scroll: 10
            );

            if ($tableName === '__custom__') {
                $tableName = text(
                    label: 'Database table name',
                    placeholder: 'e.g., users, products, customers',
                    required: true
                );
            }
        } else {
            $tableName = $this->option('table') ?? text(
                label: 'Database table name (optional - leave empty to specify resource name)',
                placeholder: 'e.g., users, products, customers',
                required: false
            );
        }

        // If table name provided, derive everything from it
        if ($tableName) {
            $tableExists = Schema::hasTable($tableName);
            $modelName = Str::studly(Str::singular($tableName));
            $resourceName = $modelName.'Resource';
            $folderName = $modelName;
        } else {
            // No table name, ask for resource name
            $name = $this->argument('name') ?? text(
                label: 'Resource name (e.g., Customer, Post, Product)',
                placeholder: 'Will create CustomerResource',
                required: true
            );

            $resourceName = str_ends_with($name, 'Resource') ? $name : $name.'Resource';
            $folderName = str_replace('Resource', '', $resourceName);
            $modelName = $this->option('model') ?? $folderName;
            $tableName = Str::plural(Str::snake($modelName));
            $tableExists = Schema::hasTable($tableName);
        }

        // Allow override if name argument was provided via CLI
        if ($this->argument('name') && $this->option('table')) {
            $name = $this->argument('name');
            $resourceName = str_ends_with($name, 'Resource') ? $name : $name.'Resource';
            $folderName = str_replace('Resource', '', $resourceName);
            $modelName = $this->option('model') ?? $folderName;
        }

        $modelPath = app_path("Models/{$modelName}.php");
        $modelExists = File::exists($modelPath);

        // Introspect table first if it exists (needed for model generation)
        if ($tableExists) {
            $this->components->info("Found existing table: {$tableName}");
            $this->introspectTable($tableName);
        }

        // Check if model exists and offer to generate if not
        if (! $modelExists) {
            if (confirm(
                label: "Model {$modelName} does not exist. Would you like to generate it?",
                default: true
            )) {
                // Check if we need to introspect the table for model generation
                if ($tableName && ! $tableExists) {
                    // Table name provided but doesn't exist yet
                    // Migration will be created, so we can't introspect yet
                    $this->components->info("Table doesn't exist yet. Model will be created with basic structure.");
                    $this->components->info('After running migrations, you can regenerate the resource to get full field definitions.');
                }

                $this->generateModel($modelName, $tableName, $tableExists);
                $this->components->info("Model {$modelName} created successfully.");
            } else {
                $this->components->warn("Continuing without generating model. Resource will reference {$modelName} class.");
            }
        }

        // Ask which pages to generate
        $pages = $this->option('pages')
            ? explode(',', $this->option('pages'))
            : multiselect(
                label: 'Which pages would you like to generate?',
                options: [
                    'list' => 'List (table/grid view)',
                    'create' => 'Create',
                    'edit' => 'Edit',
                    'view' => 'View',
                ],
                default: ['list', 'create', 'edit', 'view']
            );

        // Ask for list type
        $listType = $this->option('view') ?? select(
            label: 'List page type?',
            options: [
                'table' => 'Table (traditional rows)',
                'grid' => 'Grid (cards layout)',
                'both' => 'Both (table + grid with view switcher)',
            ],
            default: 'table'
        );

        // Ask for API support
        $generateApi = confirm(
            label: 'Generate API endpoints?',
            default: false
        );

        // Ask for Flutter support
        $generateFlutter = confirm(
            label: 'Generate Flutter widgets?',
            default: false
        );

        // Generate Resource
        $this->generateResource($resourceName, $folderName, $modelName, $pages, $tableName, $listType, $generateApi, $generateFlutter);

        // Generate Pages
        foreach ($pages as $page) {
            $this->generatePage($resourceName, $folderName, $modelName, $page, $listType);
        }

        // Generate Form
        $this->generateForm($resourceName, $folderName, $modelName);

        // Generate Table and/or Grid
        if ($listType === 'both') {
            $this->generateTable($resourceName, $folderName, $modelName);
            $this->generateGrid($resourceName, $folderName, $modelName);
        } elseif ($listType === 'table') {
            $this->generateTable($resourceName, $folderName, $modelName);
        } else {
            $this->generateGrid($resourceName, $folderName, $modelName);
        }

        // Generate InfoList
        $this->generateInfoList($resourceName, $folderName, $modelName);

        // Generate Api class if requested
        if ($generateApi) {
            $this->generateApi($resourceName, $folderName, $modelName);
        }

        // Generate Flutter class if requested
        if ($generateFlutter) {
            $this->generateFlutter($resourceName, $folderName, $modelName);
        }

        $this->newLine();
        $this->components->info("Resource [{$resourceName}] created successfully! 🎉");
        $this->newLine();

        $files = [
            "app/Laravilt/Resources/{$folderName}/{$resourceName}.php",
            "app/Laravilt/Resources/{$folderName}/Pages/*",
            "app/Laravilt/Resources/{$folderName}/Form/{$modelName}Form.php",
        ];

        // Add table/grid files based on list type
        if ($listType === 'both') {
            $files[] = "app/Laravilt/Resources/{$folderName}/Table/{$modelName}Table.php";
            $files[] = "app/Laravilt/Resources/{$folderName}/Grid/{$modelName}Grid.php";
        } elseif ($listType === 'table') {
            $files[] = "app/Laravilt/Resources/{$folderName}/Table/{$modelName}Table.php";
        } else {
            $files[] = "app/Laravilt/Resources/{$folderName}/Grid/{$modelName}Grid.php";
        }

        $files[] = "app/Laravilt/Resources/{$folderName}/InfoList/{$modelName}InfoList.php";

        if ($generateApi) {
            $files[] = "app/Laravilt/Resources/{$folderName}/Api/{$modelName}Api.php";
        }

        if ($generateFlutter) {
            $files[] = "app/Laravilt/Resources/{$folderName}/Flutter/{$modelName}Flutter.php";
        }

        $this->components->info('Created files:');
        $this->components->bulletList($files);

        return self::SUCCESS;
    }

    protected function introspectTable(string $tableName): void
    {
        $columns = Schema::getColumns($tableName);

        foreach ($columns as $column) {
            $this->tableColumns[$column['name']] = [
                'type' => $column['type_name'],
                'nullable' => $column['nullable'],
                'default' => $column['default'],
            ];
        }

        $this->components->info('Detected '.count($this->tableColumns).' columns');
    }

    protected function generateResource(string $resourceName, string $folderName, string $modelName, array $pages, ?string $tableName, string $listType, bool $hasApi = false, bool $hasFlutter = false): void
    {
        // Resource goes INSIDE the folder: app/Laravilt/Resources/Product/ProductResource.php
        $resourcePath = app_path("Laravilt/Resources/{$folderName}/{$resourceName}.php");

        if (File::exists($resourcePath) && ! $this->option('force')) {
            $this->components->warn("Resource {$resourceName} already exists. Use --force to overwrite.");

            return;
        }

        $pagesArray = $this->generatePagesArray($folderName, $pages);
        $tableProperty = $tableName ? "\n    protected static ?string \$table = '{$tableName}';" : '';
        $apiProperty = $hasApi ? "\n    protected static bool \$hasApi = true;" : '';
        $flutterProperty = $hasFlutter ? "\n    protected static bool \$hasFlutter = true;" : '';

        $apiImport = $hasApi ? "\nuse App\\Laravilt\\Resources\\{$folderName}\\Api\\{$modelName}Api;\nuse Laravilt\\Api\\Api;" : '';
        $flutterImport = $hasFlutter ? "\nuse App\\Laravilt\\Resources\\{$folderName}\\Flutter\\{$modelName}Flutter;\nuse Laravilt\\Flutter\\Flutter;" : '';

        $apiMethod = $hasApi ? "\n\n    public static function api(Api \$api): Api\n    {\n        return {$modelName}Api::configure(\$api);\n    }" : '';
        $flutterMethod = $hasFlutter ? "\n\n    public static function flutter(Flutter \$flutter): Flutter\n    {\n        return {$modelName}Flutter::configure(\$flutter);\n    }" : '';

        // Get intelligent icon selection
        $iconName = $this->getIconForResourceName($modelName);

        // Conditional imports and methods based on list type
        if ($listType === 'both') {
            $listImport = "use App\\Laravilt\\Resources\\{$folderName}\\Table\\{$modelName}Table;\nuse App\\Laravilt\\Resources\\{$folderName}\\Grid\\{$modelName}Grid;";
            $listUseStatement = "\nuse Laravilt\\Grids\\Grid;\nuse Laravilt\\Tables\\Table;";
            $listMethod = "\n\n    public static function table(Table \$table): Table\n    {\n        return {$modelName}Table::configure(\$table);\n    }\n\n    public static function grid(Grid \$grid): Grid\n    {\n        return {$modelName}Grid::configure(\$grid);\n    }";
        } elseif ($listType === 'table') {
            $listImport = "use App\\Laravilt\\Resources\\{$folderName}\\Table\\{$modelName}Table;";
            $listUseStatement = "\nuse Laravilt\\Tables\\Table;";
            $listMethod = "\n\n    public static function table(Table \$table): Table\n    {\n        return {$modelName}Table::configure(\$table);\n    }";
        } else {
            $listImport = "use App\\Laravilt\\Resources\\{$folderName}\\Grid\\{$modelName}Grid;";
            $listUseStatement = "\nuse Laravilt\\Grids\\Grid;";
            $listMethod = "\n\n    public static function grid(Grid \$grid): Grid\n    {\n        return {$modelName}Grid::configure(\$grid);\n    }";
        }

        $stub = <<<PHP
<?php

namespace App\Laravilt\Resources\\{$folderName};

use App\Laravilt\Resources\\{$folderName}\\Form\\{$modelName}Form;
use App\Laravilt\Resources\\{$folderName}\\InfoList\\{$modelName}InfoList;
use App\Laravilt\Resources\\{$folderName}\\Pages;
{$listImport}{$apiImport}{$flutterImport}
use App\Models\\{$modelName};
use Laravilt\Panel\Resources\Resource;
use Laravilt\Schemas\Schema;{$listUseStatement}

class {$resourceName} extends Resource
{
    protected static string \$model = {$modelName}::class;{$tableProperty}{$apiProperty}{$flutterProperty}

    protected static ?string \$navigationIcon = '{$iconName}';

    public static function form(Schema \$schema): Schema
    {
        return {$modelName}Form::configure(\$schema);
    }{$listMethod}

    public static function infolist(Schema \$schema): Schema
    {
        return {$modelName}InfoList::configure(\$schema);
    }

    public static function getPages(): array
    {
        return [
{$pagesArray}
        ];
    }

    public static function getRelations(): array
    {
        return [
            // Add relation managers here
        ];
    }{$apiMethod}{$flutterMethod}
}

PHP;

        File::ensureDirectoryExists(dirname($resourcePath));
        File::put($resourcePath, $stub);

        $this->components->task("Created Resource: {$resourceName}");
    }

    protected function generatePagesArray(string $folderName, array $pages): string
    {
        $lines = [];
        $pageMap = [
            'list' => ['class' => 'List', 'route' => '/'],
            'create' => ['class' => 'Create', 'route' => '/create'],
            'edit' => ['class' => 'Edit', 'route' => '/{record}/edit'],
            'view' => ['class' => 'View', 'route' => '/{record}'],
        ];

        foreach ($pages as $page) {
            if (! isset($pageMap[$page])) {
                continue;
            }

            $class = $pageMap[$page]['class'];
            $route = $pageMap[$page]['route'];

            $lines[] = "            '{$page}' => Pages\\{$class}{$folderName}::route('{$route}'),";
        }

        return implode("\n", $lines);
    }

    protected function generatePage(string $resourceName, string $folderName, string $modelName, string $pageType, string $listType): void
    {
        $pageMap = [
            'list' => ['class' => "List{$folderName}", 'extends' => 'ListRecords', 'imports' => 'use Laravilt\Actions\CreateAction;', 'actions' => 'CreateAction::make()'],
            'create' => ['class' => "Create{$folderName}", 'extends' => 'CreateRecord', 'imports' => '', 'actions' => ''],
            'edit' => ['class' => "Edit{$folderName}", 'extends' => 'EditRecord', 'imports' => 'use Laravilt\Actions\DeleteAction;'."\n".'use Laravilt\Actions\ViewAction;', 'actions' => "ViewAction::make(),\n                DeleteAction::make()"],
            'view' => ['class' => "View{$folderName}", 'extends' => 'ViewRecord', 'imports' => 'use Laravilt\Actions\DeleteAction;'."\n".'use Laravilt\Actions\EditAction;', 'actions' => "EditAction::make(),\n                DeleteAction::make()"],
        ];

        if (! isset($pageMap[$pageType])) {
            return;
        }

        $config = $pageMap[$pageType];
        $className = $config['class'];
        $extends = $config['extends'];
        $imports = $config['imports'];
        $actions = $config['actions'];

        $pagePath = app_path("Laravilt/Resources/{$folderName}/Pages/{$className}.php");

        if (File::exists($pagePath) && ! $this->option('force')) {
            return;
        }

        $actionsMethod = '';
        if ($actions) {
            $actionsMethod = <<<PHP

    public function getHeaderActions(): array
    {
        return [
            {$actions},
        ];
    }
PHP;
        }

        $stub = <<<PHP
<?php

namespace App\Laravilt\Resources\\{$folderName}\Pages;

use App\Laravilt\Resources\\{$folderName}\\{$resourceName};
{$imports}
use Laravilt\Panel\Pages\\{$extends};

class {$className} extends {$extends}
{
    protected static string \$resource = {$resourceName}::class;
{$actionsMethod}
}

PHP;

        File::ensureDirectoryExists(dirname($pagePath));
        File::put($pagePath, $stub);

        $this->components->task("Created Page: {$className}");
    }

    protected function generateForm(string $resourceName, string $folderName, string $modelName): void
    {
        $formPath = app_path("Laravilt/Resources/{$folderName}/Form/{$modelName}Form.php");

        if (File::exists($formPath) && ! $this->option('force')) {
            return;
        }

        $fields = $this->generateFormFields();

        $stub = <<<PHP
<?php

namespace App\Laravilt\Resources\\{$folderName}\\Form;

use Laravilt\Forms\Components\DatePicker;
use Laravilt\Forms\Components\FileUpload;
use Laravilt\Forms\Components\Select;
use Laravilt\Forms\Components\Textarea;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Forms\Components\Toggle;
use Laravilt\Schemas\Components\Section;
use Laravilt\Schemas\Schema;

class {$modelName}Form
{
    public static function configure(Schema \$form): Schema
    {
        return \$form
            ->schema([
                Section::make('{$modelName} Information')
                    ->schema([
{$fields}
                    ]),
            ]);
    }
}

PHP;

        File::ensureDirectoryExists(dirname($formPath));
        File::put($formPath, $stub);

        $this->components->task("Created Form: {$modelName}Form");
    }

    protected function generateFormFields(): string
    {
        if (empty($this->tableColumns)) {
            return <<<'PHP'
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        // Add more form fields here
PHP;
        }

        $fields = [];
        foreach ($this->tableColumns as $columnName => $columnInfo) {
            // Skip system columns
            if (in_array($columnName, ['id', 'created_at', 'updated_at', 'deleted_at'])) {
                continue;
            }

            $required = ! $columnInfo['nullable'] ? '->required()' : '';

            // Check if this is a file/image field
            if (str_contains($columnName, 'image') || str_contains($columnName, 'photo') || str_contains($columnName, 'avatar') || str_contains($columnName, 'picture')) {
                $field = "FileUpload::make('{$columnName}')\n                            ->image()\n                            ->imagePreview()\n                            ->disk('public')\n                            ->directory('images'){$required},";
            } elseif (str_contains($columnName, 'file') || str_contains($columnName, 'document') || str_contains($columnName, 'attachment')) {
                $field = "FileUpload::make('{$columnName}')\n                            ->disk('public')\n                            ->directory('files'){$required},";
            } elseif (str_contains($columnName, 'pdf')) {
                $field = "FileUpload::make('{$columnName}')\n                            ->acceptedFileTypes(['application/pdf'])\n                            ->disk('public')\n                            ->directory('pdfs'){$required},";
            } elseif (str_contains($columnName, 'video')) {
                $field = "FileUpload::make('{$columnName}')\n                            ->acceptedFileTypes(['video/*'])\n                            ->disk('public')\n                            ->directory('videos'){$required},";
            }
            // Check if this is a foreign key
            elseif (str_ends_with($columnName, '_id')) {
                $relationName = Str::camel(str_replace('_id', '', $columnName));
                $relatedModel = Str::studly($relationName);
                $field = "Select::make('{$columnName}')\n                            ->relationship('{$relationName}', 'name')\n                            ->searchable()\n                            ->preload(){$required},";
            }
            // Check for common field names that need special input types
            elseif ($columnName === 'password' || str_contains($columnName, 'password')) {
                $field = "TextInput::make('{$columnName}')\n                            ->password(){$required}\n                            ->dehydrateStateUsing(fn (string \$state): string => bcrypt(\$state))\n                            ->dehydrated(fn (?string \$state): bool => filled(\$state))\n                            ->maxLength(255),";
            } elseif (str_contains($columnName, 'email')) {
                $field = "TextInput::make('{$columnName}')\n                            ->email(){$required}\n                            ->maxLength(255),";
            } elseif (str_contains($columnName, 'phone') || str_contains($columnName, 'tel')) {
                $field = "TextInput::make('{$columnName}')\n                            ->tel(){$required}\n                            ->maxLength(255),";
            } elseif (str_contains($columnName, 'url') || str_contains($columnName, 'website') || str_contains($columnName, 'link')) {
                $field = "TextInput::make('{$columnName}')\n                            ->url(){$required}\n                            ->maxLength(255),";
            }
            // Check column type
            elseif (in_array($columnInfo['type'], ['text', 'longtext'])) {
                // Use Textarea for long text fields
                $field = "Textarea::make('{$columnName}')\n                            ->rows(3){$required},";
            } elseif (in_array($columnInfo['type'], ['boolean', 'tinyint'])) {
                $field = "Toggle::make('{$columnName}'){$required},";
            } elseif ($columnInfo['type'] === 'date') {
                $field = "DatePicker::make('{$columnName}'){$required},";
            } elseif (in_array($columnInfo['type'], ['datetime', 'timestamp'])) {
                $field = "DatePicker::make('{$columnName}')\n                            ->time(){$required},";
            } elseif ($columnInfo['type'] === 'enum') {
                $field = "Select::make('{$columnName}')\n                            ->options([/* add enum options */]){$required},";
            } elseif (in_array($columnInfo['type'], ['integer', 'bigint', 'smallint'])) {
                // Use integer input for whole number fields
                $field = "TextInput::make('{$columnName}')\n                            ->integer(){$required},";
            } elseif (in_array($columnInfo['type'], ['decimal', 'float', 'double', 'numeric'])) {
                // Use number input with step for decimal fields
                $field = "TextInput::make('{$columnName}')\n                            ->number()->step(0.01){$required},";
            } else {
                // Default to text input
                $field = "TextInput::make('{$columnName}'){$required}\n                            ->maxLength(255),";
            }

            $fields[] = "                        {$field}";
        }

        return implode("\n\n", $fields)."\n";
    }

    protected function generateTable(string $resourceName, string $folderName, string $modelName): void
    {
        $tablePath = app_path("Laravilt/Resources/{$folderName}/Table/{$modelName}Table.php");

        if (File::exists($tablePath) && ! $this->option('force')) {
            return;
        }

        $columns = $this->generateTableColumns();

        $stub = <<<PHP
<?php

namespace App\Laravilt\Resources\\{$folderName}\\Table;

use Laravilt\Actions\BulkActionGroup;
use Laravilt\Actions\DeleteAction;
use Laravilt\Actions\DeleteBulkAction;
use Laravilt\Actions\EditAction;
use Laravilt\Actions\ViewAction;
use Laravilt\Tables\Columns\TextColumn;
use Laravilt\Tables\Table;

class {$modelName}Table
{
    public static function configure(Table \$table): Table
    {
        return \$table
            ->columns([
{$columns}
            ])
            ->filters([
                // Add filters here
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}

PHP;

        File::ensureDirectoryExists(dirname($tablePath));
        File::put($tablePath, $stub);

        $this->components->task("Created Table: {$modelName}Table");
    }

    protected function generateTableColumns(): string
    {
        if (empty($this->tableColumns)) {
            return <<<'PHP'
                TextColumn::make('id')
                    ->sortable(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
PHP;
        }

        $columns = [];
        foreach ($this->tableColumns as $columnName => $columnInfo) {
            $sortable = '->sortable()';
            $toggleable = in_array($columnName, ['created_at', 'updated_at', 'deleted_at'])
                ? '->toggleable(isToggledHiddenByDefault: true)'
                : '';

            $column = match ($columnInfo['type']) {
                'boolean', 'tinyint' => "TextColumn::make('{$columnName}')\n                    ->badge(){$sortable}{$toggleable},",
                'date', 'datetime', 'timestamp' => "TextColumn::make('{$columnName}')\n                    ->dateTime(){$sortable}{$toggleable},",
                default => in_array($columnName, ['name', 'title', 'email'])
                    ? "TextColumn::make('{$columnName}')\n                    ->searchable(){$sortable}{$toggleable},"
                    : "TextColumn::make('{$columnName}'){$sortable}{$toggleable},",
            };

            $columns[] = "                {$column}";
        }

        return implode("\n\n", $columns)."\n";
    }

    protected function generateGrid(string $resourceName, string $folderName, string $modelName): void
    {
        $gridPath = app_path("Laravilt/Resources/{$folderName}/Grid/{$modelName}Grid.php");

        if (File::exists($gridPath) && ! $this->option('force')) {
            return;
        }

        $columns = $this->generateGridColumns();

        $stub = <<<PHP
<?php

namespace App\Laravilt\Resources\\{$folderName}\\Grid;

use Laravilt\Actions\BulkActionGroup;
use Laravilt\Actions\DeleteAction;
use Laravilt\Actions\DeleteBulkAction;
use Laravilt\Actions\EditAction;
use Laravilt\Actions\ViewAction;
use Laravilt\Grids\Card;
use Laravilt\Grids\Columns\ImageGridColumn;
use Laravilt\Grids\Columns\TextGridColumn;
use Laravilt\Grids\Grid;

class {$modelName}Grid
{
    public static function configure(Grid \$grid): Grid
    {
        return \$grid
            ->columns([
{$columns}
            ])
            ->card(
                Card::make()
                    ->header(fn (\$record) => \$record->name ?? \$record->title ?? '#{$modelName} '.\$record->id)
                    ->footer(fn (\$record) => \$record->email ?? \$record->description ?? null)
            )
            ->filters([
                // Add filters here
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->infiniteScroll()
            ->perPage(12)
            ->searchable();
    }
}

PHP;

        File::ensureDirectoryExists(dirname($gridPath));
        File::put($gridPath, $stub);

        $this->components->task("Created Grid: {$modelName}Grid");
    }

    protected function generateGridColumns(): string
    {
        if (empty($this->tableColumns)) {
            return <<<'PHP'
                TextGridColumn::make('id'),

                TextGridColumn::make('name')
                    ->searchable(),

                // Add more grid columns here
PHP;
        }

        $columns = [];
        foreach ($this->tableColumns as $columnName => $columnInfo) {
            // Skip certain system columns for grid display
            if (in_array($columnName, ['created_at', 'updated_at', 'deleted_at', 'password', 'remember_token'])) {
                continue;
            }

            $searchable = in_array($columnName, ['name', 'title', 'email']) ? '->searchable()' : '';

            $column = match ($columnInfo['type']) {
                default => in_array($columnName, ['avatar', 'image', 'photo'])
                    ? "ImageGridColumn::make('{$columnName}'){$searchable},"
                    : "TextGridColumn::make('{$columnName}'){$searchable},",
            };

            $columns[] = "                {$column}";
        }

        return implode("\n\n", $columns)."\n";
    }

    protected function generateInfoList(string $resourceName, string $folderName, string $modelName): void
    {
        $infolistPath = app_path("Laravilt/Resources/{$folderName}/InfoList/{$modelName}InfoList.php");

        if (File::exists($infolistPath) && ! $this->option('force')) {
            return;
        }

        $entries = $this->generateInfoListEntries();

        $stub = <<<PHP
<?php

namespace App\Laravilt\Resources\\{$folderName}\\InfoList;

use Laravilt\Infolists\Entries\BadgeEntry;
use Laravilt\Infolists\Entries\TextEntry;
use Laravilt\Schemas\Components\Section;
use Laravilt\Schemas\Schema;

class {$modelName}InfoList
{
    public static function configure(Schema \$infolist): Schema
    {
        return \$infolist
            ->schema([
                Section::make('{$modelName} Details')
                    ->schema([
{$entries}
                    ]),
            ]);
    }
}

PHP;

        File::ensureDirectoryExists(dirname($infolistPath));
        File::put($infolistPath, $stub);

        $this->components->task("Created InfoList: {$modelName}InfoList");
    }

    protected function generateInfoListEntries(): string
    {
        if (empty($this->tableColumns)) {
            return <<<'PHP'
                        TextEntry::make('name'),

                        TextEntry::make('created_at')
                            ->dateTime(),

                        TextEntry::make('updated_at')
                            ->dateTime(),

                        // Add more entries here
PHP;
        }

        $entries = [];
        foreach ($this->tableColumns as $columnName => $columnInfo) {
            // Skip id and password fields
            if ($columnName === 'id' || $columnName === 'password' || str_contains($columnName, 'password')) {
                continue;
            }

            $entry = match ($columnInfo['type']) {
                'date', 'datetime', 'timestamp' => "TextEntry::make('{$columnName}')\n                            ->dateTime(),",
                'boolean', 'tinyint' => "BadgeEntry::make('{$columnName}'),",
                default => "TextEntry::make('{$columnName}'),",
            };

            $entries[] = "                        {$entry}";
        }

        return implode("\n\n", $entries)."\n";
    }

    protected function generateApi(string $resourceName, string $folderName, string $modelName): void
    {
        $apiPath = app_path("Laravilt/Resources/{$folderName}/Api/{$modelName}Api.php");

        if (File::exists($apiPath) && ! $this->option('force')) {
            return;
        }

        $fields = $this->generateApiFields();

        $stub = <<<PHP
<?php

namespace App\Laravilt\Resources\\{$folderName}\\Api;

use Laravilt\Api\Api;
use Laravilt\Api\Components\ApiField;

class {$modelName}Api
{
    /**
     * Configure API schema for this resource.
     *
     * Works exactly like Form::configure() - returns an Api instance with components.
     */
    public static function configure(Api \$api): Api
    {
        return \$api
            ->schema([
{$fields}
            ]);
    }
}

PHP;

        File::ensureDirectoryExists(dirname($apiPath));
        File::put($apiPath, $stub);

        $this->components->task("Created Api: {$modelName}Api");
    }

    protected function generateApiFields(): string
    {
        if (empty($this->tableColumns)) {
            return <<<'PHP'
                ApiField::make('id')->type('integer'),
                ApiField::make('name')->type('string'),
                ApiField::make('created_at')->type('datetime')->format('c'),
                ApiField::make('updated_at')->type('datetime')->format('c'),
PHP;
        }

        $fields = [];
        foreach ($this->tableColumns as $columnName => $columnInfo) {
            $nullable = $columnInfo['nullable'] ? '->nullable()' : '';

            $type = match ($columnInfo['type']) {
                'bigint', 'integer', 'smallint', 'tinyint' => 'integer',
                'boolean' => 'boolean',
                'date' => 'date',
                'datetime', 'timestamp' => 'datetime',
                'decimal', 'float', 'double', 'numeric' => 'number',
                default => 'string',
            };

            $format = '';
            if (in_array($columnInfo['type'], ['datetime', 'timestamp'])) {
                $format = "->format('c')";
            }

            $field = "ApiField::make('{$columnName}')->type('{$type}'){$format}{$nullable},";
            $fields[] = "                {$field}";
        }

        return implode("\n", $fields)."\n";
    }

    /**
     * Generate a full model with fillable, table, relations, and PHPDocs.
     */
    protected function generateModel(string $modelName, ?string $tableName, bool $tableExists): void
    {
        // First create migration and factory if table doesn't exist
        if (! $tableExists) {
            $this->call('make:migration', [
                'name' => 'create_'.Str::plural(Str::snake($modelName)).'_table',
            ]);
        }

        $this->call('make:factory', [
            'name' => "{$modelName}Factory",
        ]);

        $modelPath = app_path("Models/{$modelName}.php");
        $table = $tableName ?? Str::plural(Str::snake($modelName));

        // Get fillable fields from table columns if available
        $fillableArray = $this->generateFillableArray($table);
        $castsArray = $this->generateCastsArray();
        $relationMethods = $this->generateRelationMethods($modelName, $table);

        // Check if we need SoftDeletes
        $hasSoftDeletes = isset($this->tableColumns['deleted_at']);
        $softDeletesUse = $hasSoftDeletes ? "\nuse Illuminate\Database\Eloquent\SoftDeletes;" : '';
        $softDeletesTrait = $hasSoftDeletes ? ', SoftDeletes' : '';

        // Check if we have BelongsTo relations
        $hasBelongsTo = false;
        foreach ($this->tableColumns as $columnName => $columnInfo) {
            if (str_ends_with($columnName, '_id')) {
                $hasBelongsTo = true;
                break;
            }
        }
        $belongsToImport = $hasBelongsTo ? "\nuse Illuminate\Database\Eloquent\Relations\BelongsTo;" : '';

        $stub = <<<PHP
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;{$softDeletesUse}{$belongsToImport}

/**
 * {$modelName} Model
 *
 * @property int \$id
{$this->generatePropertyDocs()}
 * @property \Illuminate\Support\Carbon \$created_at
 * @property \Illuminate\Support\Carbon \$updated_at
 */
class {$modelName} extends Model
{
    use HasFactory{$softDeletesTrait};

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected \$table = '{$table}';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected \$fillable = [
{$fillableArray}
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected \$casts = [
{$castsArray}
    ];
{$relationMethods}
}

PHP;

        File::ensureDirectoryExists(app_path('Models'));
        File::put($modelPath, $stub);
    }

    /**
     * Generate fillable array from table columns.
     */
    protected function generateFillableArray(string $table): string
    {
        if (empty($this->tableColumns)) {
            return "        // Add your fillable fields here\n";
        }

        $fillable = [];
        foreach ($this->tableColumns as $columnName => $columnInfo) {
            // Skip system fields
            if (in_array($columnName, ['id', 'created_at', 'updated_at', 'deleted_at'])) {
                continue;
            }

            $fillable[] = "        '{$columnName}',";
        }

        return implode("\n", $fillable);
    }

    /**
     * Generate casts array from table columns.
     */
    protected function generateCastsArray(): string
    {
        if (empty($this->tableColumns)) {
            return "        // Add your casts here\n";
        }

        $casts = [];
        foreach ($this->tableColumns as $columnName => $columnInfo) {
            $cast = match ($columnInfo['type']) {
                'boolean', 'tinyint' => "'boolean'",
                'integer', 'bigint', 'smallint' => "'integer'",
                'decimal', 'float', 'double' => "'decimal:2'",
                'date' => "'date'",
                'datetime', 'timestamp' => "'datetime'",
                'json', 'jsonb' => "'array'",
                default => null,
            };

            if ($cast) {
                $casts[] = "        '{$columnName}' => {$cast},";
            }
        }

        return empty($casts) ? "        // Add your casts here\n" : implode("\n", $casts);
    }

    /**
     * Generate PHPDoc property documentation.
     */
    protected function generatePropertyDocs(): string
    {
        if (empty($this->tableColumns)) {
            return '';
        }

        $docs = [];
        foreach ($this->tableColumns as $columnName => $columnInfo) {
            // Skip system fields already documented
            if (in_array($columnName, ['id', 'created_at', 'updated_at'])) {
                continue;
            }

            $phpType = match ($columnInfo['type']) {
                'boolean', 'tinyint' => 'bool',
                'integer', 'bigint', 'smallint' => 'int',
                'decimal', 'float', 'double' => 'float',
                'date', 'datetime', 'timestamp' => '\Illuminate\Support\Carbon',
                'json', 'jsonb' => 'array',
                default => 'string',
            };

            $nullable = $columnInfo['nullable'] ? '|null' : '';
            $docs[] = " * @property {$phpType}{$nullable} \${$columnName}";
        }

        return implode("\n", $docs);
    }

    /**
     * Generate relation method placeholders.
     */
    /**
     * Generate relationship methods by detecting foreign keys.
     */
    protected function generateRelationMethods(string $modelName, string $table): string
    {
        if (empty($this->tableColumns)) {
            return $this->generateRelationPlaceholders($modelName);
        }

        $relations = [];

        // Detect belongsTo relationships from foreign key columns
        foreach ($this->tableColumns as $columnName => $columnInfo) {
            // Check if column name follows foreign key convention (ends with _id)
            if (str_ends_with($columnName, '_id')) {
                $relationName = Str::camel(str_replace('_id', '', $columnName));
                $relatedModel = Str::studly($relationName);

                $relations[] = <<<PHP

    /**
     * Get the {$relationName} that owns this {$modelName}.
     */
    public function {$relationName}(): BelongsTo
    {
        return \$this->belongsTo({$relatedModel}::class);
    }
PHP;
            }
        }

        if (empty($relations)) {
            return $this->generateRelationPlaceholders($modelName);
        }

        return implode("\n", $relations);
    }

    protected function generateRelationPlaceholders(string $modelName): string
    {
        return <<<'PHP'


    // Relationships

    /**
     * Example: Define a belongs to relationship
     *
     * public function user(): BelongsTo
     * {
     *     return $this->belongsTo(User::class);
     * }
     */

    /**
     * Example: Define a has many relationship
     *
     * public function posts(): HasMany
     * {
     *     return $this->hasMany(Post::class);
     * }
     */
PHP;
    }

    /**
     * Get appropriate Lucide icon based on resource name.
     */
    protected function getIconForResourceName(string $resourceName): string
    {
        $name = strtolower($resourceName);

        // Users & People
        if (str_contains($name, 'user')) {
            return 'Users';
        }
        if (str_contains($name, 'customer')) {
            return 'Users';
        }
        if (str_contains($name, 'employee') || str_contains($name, 'staff')) {
            return 'IdCard';
        }
        if (str_contains($name, 'team') || str_contains($name, 'group')) {
            return 'Users';
        }

        // Commerce
        if (str_contains($name, 'product')) {
            return 'ShoppingCart';
        }
        if (str_contains($name, 'order')) {
            return 'ShoppingBag';
        }
        if (str_contains($name, 'payment') || str_contains($name, 'transaction')) {
            return 'CreditCard';
        }
        if (str_contains($name, 'invoice') || str_contains($name, 'receipt')) {
            return 'Receipt';
        }
        if (str_contains($name, 'cart')) {
            return 'ShoppingCart';
        }
        if (str_contains($name, 'category')) {
            return 'Tag';
        }

        // Content
        if (str_contains($name, 'post') || str_contains($name, 'article') || str_contains($name, 'blog')) {
            return 'FileText';
        }
        if (str_contains($name, 'page')) {
            return 'File';
        }
        if (str_contains($name, 'comment')) {
            return 'MessageSquare';
        }
        if (str_contains($name, 'media') || str_contains($name, 'image') || str_contains($name, 'photo')) {
            return 'Image';
        }

        // Organization
        if (str_contains($name, 'company') || str_contains($name, 'organization')) {
            return 'Building2';
        }
        if (str_contains($name, 'department')) {
            return 'Briefcase';
        }
        if (str_contains($name, 'project')) {
            return 'Folder';
        }
        if (str_contains($name, 'task')) {
            return 'Clipboard';
        }

        // Communication
        if (str_contains($name, 'message') || str_contains($name, 'chat')) {
            return 'MessageSquare';
        }
        if (str_contains($name, 'mail') || str_contains($name, 'email')) {
            return 'Mail';
        }
        if (str_contains($name, 'notification')) {
            return 'Bell';
        }

        // Calendar & Time
        if (str_contains($name, 'event') || str_contains($name, 'appointment')) {
            return 'Calendar';
        }
        if (str_contains($name, 'schedule')) {
            return 'Clock';
        }

        // Settings & Config
        if (str_contains($name, 'setting') || str_contains($name, 'config')) {
            return 'Settings';
        }
        if (str_contains($name, 'permission') || str_contains($name, 'role')) {
            return 'Lock';
        }

        // Analytics & Reports
        if (str_contains($name, 'report') || str_contains($name, 'analytic')) {
            return 'BarChart';
        }
        if (str_contains($name, 'dashboard')) {
            return 'LayoutDashboard';
        }
        if (str_contains($name, 'stat')) {
            return 'TrendingUp';
        }

        // Location
        if (str_contains($name, 'address') || str_contains($name, 'location')) {
            return 'MapPin';
        }

        // Default icon
        return 'LayoutGrid';
    }

    /**
     * Generate Flutter class with schema components (like Form/Table).
     */
    protected function generateFlutter(string $resourceName, string $folderName, string $modelName): void
    {
        $flutterPath = app_path("Laravilt/Resources/{$folderName}/Flutter/{$modelName}Flutter.php");

        $fields = $this->generateFlutterComponents();

        $stub = <<<PHP
<?php

namespace App\Laravilt\Resources\\{$folderName}\\Flutter;

use Laravilt\Flutter\Flutter;
use Laravilt\Flutter\Components\FlutterField;

class {$modelName}Flutter
{
    /**
     * Configure Flutter schema for this resource.
     *
     * Works exactly like Form::configure() - returns a Flutter instance with components.
     * Note: Flutter typically uses camelCase for field names.
     *
     * @param  \Laravilt\Flutter\Flutter  \$flutter
     * @return \Laravilt\Flutter\Flutter
     */
    public static function configure(Flutter \$flutter): Flutter
    {
        return \$flutter
            ->schema([
{$fields}
            ]);
    }
}

PHP;

        File::ensureDirectoryExists(dirname($flutterPath));
        File::put($flutterPath, $stub);

        $this->components->task("Created Flutter: {$modelName}Flutter");
    }

    /**
     * Generate API components from table columns.
     */
    protected function generateApiComponents(): string
    {
        if (empty($this->tableColumns)) {
            return "                ApiField::make('id')->type('integer'),\n                // Add your API fields here\n";
        }

        $fields = ["                ApiField::make('id')->type('integer'),"];

        foreach ($this->tableColumns as $columnName => $columnInfo) {
            if (in_array($columnName, ['created_at', 'updated_at'])) {
                $fields[] = "                ApiField::make('{$columnName}')->type('datetime')->format('c'),";

                continue;
            }

            if ($columnName === 'id') {
                continue;
            }

            $type = match ($columnInfo['type']) {
                'boolean', 'tinyint' => 'boolean',
                'integer', 'bigint', 'smallint' => 'integer',
                'decimal', 'float', 'double' => 'number',
                'date', 'datetime', 'timestamp' => 'datetime',
                'json', 'jsonb' => 'object',
                default => 'string',
            };

            $nullable = $columnInfo['nullable'] ? '->nullable()' : '';
            $fields[] = "                ApiField::make('{$columnName}')->type('{$type}'){$nullable},";
        }

        return implode("\n", $fields);
    }

    /**
     * Generate Flutter components from table columns.
     */
    protected function generateFlutterComponents(): string
    {
        if (empty($this->tableColumns)) {
            return "                FlutterField::make('id')->type('int'),\n                // Add your Flutter fields here\n";
        }

        $fields = ["                FlutterField::make('id')->type('int'),"];

        foreach ($this->tableColumns as $columnName => $columnInfo) {
            if (in_array($columnName, ['created_at', 'updated_at'])) {
                $fields[] = "                FlutterField::make('{$columnName}')->type('DateTime'),";

                continue;
            }

            if ($columnName === 'id') {
                continue;
            }

            $type = match ($columnInfo['type']) {
                'boolean', 'tinyint' => 'bool',
                'integer', 'bigint', 'smallint' => 'int',
                'decimal', 'float', 'double' => 'double',
                'date', 'datetime', 'timestamp' => 'DateTime',
                'json', 'jsonb' => 'Map<String, dynamic>',
                default => 'String',
            };

            $nullable = $columnInfo['nullable'] ? '->nullable()' : '';
            $fields[] = "                FlutterField::make('{$columnName}')->type('{$type}'){$nullable},";
        }

        return implode("\n", $fields);
    }
}
