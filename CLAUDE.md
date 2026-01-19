# Accelade Widgets

Dashboard widget components for Laravel applications.

## Package Structure

```
packages/widgets/
├── src/
│   ├── Widget.php              # Base widget class
│   ├── WidgetFactory.php       # Factory for creating widgets
│   ├── WidgetsServiceProvider.php
│   ├── Components/
│   │   ├── StatsWidget.php     # Stats overview widget
│   │   ├── Stat.php            # Individual stat card
│   │   ├── ChartWidget.php     # Chart.js wrapper widget
│   │   ├── TableWidget.php     # Table widget
│   │   └── Column.php          # Table column definition
│   ├── Facades/
│   │   └── Widgets.php
│   └── Http/Controllers/
│       └── DocsController.php
├── resources/
│   ├── js/
│   │   ├── index.ts            # Main entry point
│   │   └── components/
│   │       ├── ChartManager.ts
│   │       └── PollingManager.ts
│   └── views/
│       └── components/
│           ├── widget.blade.php
│           ├── stats-widget.blade.php
│           ├── stat.blade.php
│           ├── chart-widget.blade.php
│           ├── table-widget.blade.php
│           ├── grid.blade.php
│           └── mini-chart.blade.php
├── config/widgets.php
├── routes/web.php
└── tests/
```

## Key Classes

### Widget (Base Class)
- `make()` - Create widget instance
- `id(string)` - Set widget ID
- `columnSpan(int|string)` - Grid column span
- `columnSpanFull()` - Span full width
- `sort(int)` - Sort order
- `lazy(bool, ?string)` - Enable lazy loading
- `pollingInterval(?string)` - Auto-refresh interval
- `visible(bool)` / `hidden(bool)` - Visibility control
- `canView()` - Authorization check (override in subclass)

### StatsWidget
- `columns(int)` - Number of columns
- `stats(array)` - Array of Stat instances

### Stat
- `make(label, value)` - Create stat
- `description(?string)` - Description text
- `descriptionIcon(?string, ?color)` - Description icon
- `icon(?string, ?color)` - Main icon
- `color(?string)` - Card color theme
- `chart(array, ?color)` - Mini sparkline chart
- `url(?string, bool)` - Make clickable

### ChartWidget
- `heading(string)` / `description(?string)`
- `line()` / `bar()` / `pie()` / `doughnut()` / `radar()` / `polarArea()` / `scatter()` / `bubble()` - Chart types
- `data(array)` - Chart.js data config
- `options(array)` - Chart.js options
- `height(int)` - Chart height
- `filters(array, ?default)` - Filter buttons

### TableWidget
- `heading(string)` / `description(?string)`
- `columns(array)` - Array of Column instances
- `records(Collection|array)` - Data records
- `striped(bool)` / `hoverable(bool)` / `bordered(bool)` / `compact(bool)`
- `emptyState(?heading, ?description, ?icon)`
- `recordUrl(?Closure)` - Make rows clickable
- `paginated(bool, int)` - Enable pagination

### Column
- `make(name)` - Create column
- `label(?string)` - Column header
- `sortable(bool)` / `searchable(bool)`
- `alignLeft()` / `alignCenter()` / `alignRight()`
- `formatStateUsing(?Closure)` - Format cell value
- `icon(?string, position)` - Column icon
- `color(string|Closure)` - Cell color
- `hidden(bool)` / `width(?string)` / `wrap(bool)`

## Running Tests

```bash
cd packages/widgets
./vendor/bin/pest
```
