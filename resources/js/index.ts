/**
 * Accelade Widgets - Dashboard widgets for Laravel
 */

import { ChartManager } from './components/ChartManager';
import { PollingManager } from './components/PollingManager';

export interface WidgetsConfig {
    chartDefaults?: Record<string, unknown>;
    pollingEnabled?: boolean;
}

class AcceladeWidgets {
    private chartManager: ChartManager;
    private pollingManager: PollingManager;
    private initialized = false;

    constructor() {
        this.chartManager = new ChartManager();
        this.pollingManager = new PollingManager();
    }

    /**
     * Initialize the widgets system.
     */
    init(config: WidgetsConfig = {}): void {
        if (this.initialized) {
            return;
        }

        this.chartManager.init(config.chartDefaults);

        if (config.pollingEnabled !== false) {
            this.pollingManager.init();
        }

        this.initialized = true;
    }

    /**
     * Get the chart manager.
     */
    get charts(): ChartManager {
        return this.chartManager;
    }

    /**
     * Get the polling manager.
     */
    get polling(): PollingManager {
        return this.pollingManager;
    }

    /**
     * Refresh all widgets.
     */
    refresh(): void {
        this.chartManager.refreshAll();
    }

    /**
     * Destroy all widgets and cleanup.
     */
    destroy(): void {
        this.chartManager.destroy();
        this.pollingManager.destroy();
        this.initialized = false;
    }
}

// Create singleton instance
const widgets = new AcceladeWidgets();

// Auto-initialize on DOM ready
if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => widgets.init());
    } else {
        widgets.init();
    }
}

export { AcceladeWidgets, ChartManager, PollingManager };
export default widgets;
