@props([
    'section' => 'getting-started',
    'title' => 'Widgets',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} - Accelade Widgets</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|jetbrains-mono:400,500" rel="stylesheet" />

    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
            }
        </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --docs-bg: #ffffff;
            --docs-bg-alt: #f8fafc;
            --docs-text: #0f172a;
            --docs-text-muted: #64748b;
            --docs-border: #e2e8f0;
            --docs-accent: #ea7023;
        }
        .dark {
            --docs-bg: #0f172a;
            --docs-bg-alt: #1e293b;
            --docs-text: #f1f5f9;
            --docs-text-muted: #94a3b8;
            --docs-border: #334155;
            --docs-accent: #fb923c;
        }
        body {
            background: var(--docs-bg);
            color: var(--docs-text);
            font-family: 'Inter', sans-serif;
        }
    </style>

    @stack('styles')
</head>
<body class="min-h-screen antialiased">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="sticky top-0 z-30 bg-white dark:bg-slate-900 border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="h-16 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('widgets.demo') }}" class="flex items-center gap-2 font-bold text-lg">
                            <span class="text-2xl">📊</span>
                            <span>Accelade Widgets</span>
                        </a>
                    </div>

                    <nav class="flex items-center gap-4">
                        <a href="{{ route('widgets.demo') }}"
                           class="px-3 py-2 text-sm font-medium rounded-lg {{ $section === 'demo' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white' }}">
                            Demo
                        </a>
                        <a href="{{ route('widgets.docs', 'getting-started') }}"
                           class="px-3 py-2 text-sm font-medium rounded-lg {{ $section !== 'demo' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white' }}">
                            Docs
                        </a>
                        <button onclick="toggleTheme()" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                            <span class="dark:hidden">🌙</span>
                            <span class="hidden dark:block">☀️</span>
                        </button>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="border-t border-gray-200 dark:border-gray-700 py-8 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500 dark:text-gray-400">
                Built with Accelade Widgets & Laravel
            </div>
        </footer>
    </div>

    <script>
        // Theme initialization
        (function() {
            var stored = localStorage.getItem('widgets-theme');
            var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            document.documentElement.classList.toggle('dark', stored === 'dark' || (!stored && prefersDark));
        })();

        function toggleTheme() {
            var isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('widgets-theme', isDark ? 'dark' : 'light');
        }

        // Initialize Chart.js instances
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.chart-container').forEach(function(container) {
                var canvas = container.querySelector('canvas');
                var config = JSON.parse(container.dataset.chartConfig || '{}');

                if (canvas && config.type) {
                    new Chart(canvas, config);
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
