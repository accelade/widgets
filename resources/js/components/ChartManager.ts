/**
 * Chart Manager - Handles Chart.js instance management
 */

declare const Chart: any;

export interface ChartConfig {
    type: string;
    data: Record<string, unknown>;
    options?: Record<string, unknown>;
}

export class ChartManager {
    private charts: Map<string, any> = new Map();
    private defaults: Record<string, unknown> = {};

    /**
     * Initialize the chart manager.
     */
    init(defaults: Record<string, unknown> = {}): void {
        this.defaults = defaults;
        this.initializeCharts();
        this.observeNewCharts();
    }

    /**
     * Initialize all chart containers on the page.
     */
    private initializeCharts(): void {
        document.querySelectorAll<HTMLElement>('.chart-container').forEach((container) => {
            this.initializeChart(container);
        });
    }

    /**
     * Initialize a single chart container.
     */
    private initializeChart(container: HTMLElement): void {
        const canvas = container.querySelector<HTMLCanvasElement>('canvas');
        const configData = container.dataset.chartConfig;

        if (!canvas || !configData || container.dataset.chartInitialized === 'true') {
            return;
        }

        try {
            const config: ChartConfig = JSON.parse(configData);
            const chartId = container.id || `chart-${Date.now()}`;

            // Merge with defaults
            const mergedConfig = {
                ...config,
                options: {
                    ...this.defaults,
                    ...config.options,
                },
            };

            // Create Chart.js instance
            if (typeof Chart !== 'undefined') {
                const chart = new Chart(canvas, mergedConfig);
                this.charts.set(chartId, chart);
                container.dataset.chartInitialized = 'true';
            }
        } catch (error) {
            console.error('Failed to initialize chart:', error);
        }
    }

    /**
     * Observe for new chart containers added to DOM.
     */
    private observeNewCharts(): void {
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.addedNodes.forEach((node) => {
                    if (node instanceof HTMLElement) {
                        if (node.classList.contains('chart-container')) {
                            this.initializeChart(node);
                        }
                        node.querySelectorAll<HTMLElement>('.chart-container').forEach((container) => {
                            this.initializeChart(container);
                        });
                    }
                });
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true,
        });
    }

    /**
     * Get a chart instance by ID.
     */
    get(id: string): any | undefined {
        return this.charts.get(id);
    }

    /**
     * Update chart data.
     */
    update(id: string, data: Record<string, unknown>): void {
        const chart = this.charts.get(id);
        if (chart) {
            chart.data = data;
            chart.update();
        }
    }

    /**
     * Refresh all charts.
     */
    refreshAll(): void {
        this.charts.forEach((chart) => {
            chart.update();
        });
    }

    /**
     * Destroy all chart instances.
     */
    destroy(): void {
        this.charts.forEach((chart) => {
            chart.destroy();
        });
        this.charts.clear();
    }

    /**
     * Destroy a specific chart.
     */
    destroyChart(id: string): void {
        const chart = this.charts.get(id);
        if (chart) {
            chart.destroy();
            this.charts.delete(id);
        }
    }
}
