<x-widgets::layouts.docs section="demo" title="Demo">
    <div class="space-y-8">
        <!-- Page Header -->
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Widgets Demo</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                A collection of dashboard widgets built with Accelade components.
            </p>
        </div>

        <!-- Stats Widget -->
        <section>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Stats Overview</h2>
            <x-widgets::stats-widget :widget="$statsWidget" />
        </section>

        <!-- Chart Widget -->
        <section>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Revenue Chart</h2>
            <x-widgets::chart-widget :widget="$chartWidget" />
        </section>

        <!-- Table Widget -->
        <section>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Recent Orders</h2>
            <x-widgets::table-widget :widget="$tableWidget" />
        </section>

        <!-- Grid Layout Example -->
        <section>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Grid Layout</h2>
            <x-widgets::grid :columns="12" :gap="6">
                <div class="col-span-8">
                    <x-widgets::chart-widget :widget="$chartWidget" />
                </div>
                <div class="col-span-4 space-y-4">
                    @foreach($statsWidget->getStats() as $stat)
                        <x-widgets::stat :stat="$stat" />
                    @endforeach
                </div>
            </x-widgets::grid>
        </section>
    </div>
</x-widgets::layouts.docs>
