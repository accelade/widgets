/**
 * Polling Manager - Handles widget auto-refresh
 */

interface PollingWidget {
    element: HTMLElement;
    interval: number;
    timer: ReturnType<typeof setInterval> | null;
}

export class PollingManager {
    private widgets: Map<string, PollingWidget> = new Map();
    private paused = false;

    /**
     * Initialize the polling manager.
     */
    init(): void {
        this.initializePollingWidgets();
        this.observeNewWidgets();
        this.handleVisibilityChange();
    }

    /**
     * Parse interval string to milliseconds.
     */
    private parseInterval(interval: string): number {
        const match = interval.match(/^(\d+)(s|m|h)?$/);
        if (!match) {
            return 0;
        }

        const value = parseInt(match[1], 10);
        const unit = match[2] || 's';

        switch (unit) {
            case 'h':
                return value * 60 * 60 * 1000;
            case 'm':
                return value * 60 * 1000;
            case 's':
            default:
                return value * 1000;
        }
    }

    /**
     * Initialize all polling widgets on the page.
     */
    private initializePollingWidgets(): void {
        document.querySelectorAll<HTMLElement>('[data-widget-poll]').forEach((element) => {
            this.registerWidget(element);
        });
    }

    /**
     * Register a widget for polling.
     */
    private registerWidget(element: HTMLElement): void {
        const intervalStr = element.dataset.widgetPoll;
        const widgetId = element.id || `widget-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;

        if (!intervalStr || this.widgets.has(widgetId)) {
            return;
        }

        const interval = this.parseInterval(intervalStr);
        if (interval <= 0) {
            return;
        }

        const widget: PollingWidget = {
            element,
            interval,
            timer: null,
        };

        this.widgets.set(widgetId, widget);
        this.startPolling(widgetId);
    }

    /**
     * Start polling for a widget.
     */
    private startPolling(widgetId: string): void {
        const widget = this.widgets.get(widgetId);
        if (!widget || widget.timer) {
            return;
        }

        widget.timer = setInterval(() => {
            if (!this.paused) {
                this.refreshWidget(widget);
            }
        }, widget.interval);
    }

    /**
     * Stop polling for a widget.
     */
    private stopPolling(widgetId: string): void {
        const widget = this.widgets.get(widgetId);
        if (widget?.timer) {
            clearInterval(widget.timer);
            widget.timer = null;
        }
    }

    /**
     * Refresh a widget.
     */
    private refreshWidget(widget: PollingWidget): void {
        // Dispatch refresh event for the widget
        const event = new CustomEvent('widgets:refresh', {
            bubbles: true,
            detail: { element: widget.element },
        });
        widget.element.dispatchEvent(event);

        // If using Accelade rehydrate, trigger that instead
        const rehydrateId = widget.element.dataset.rehydrateId;
        if (rehydrateId && typeof window !== 'undefined' && (window as any).Accelade?.rehydrate) {
            (window as any).Accelade.rehydrate.refresh(rehydrateId);
        }
    }

    /**
     * Observe for new polling widgets added to DOM.
     */
    private observeNewWidgets(): void {
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.addedNodes.forEach((node) => {
                    if (node instanceof HTMLElement) {
                        if (node.dataset.widgetPoll) {
                            this.registerWidget(node);
                        }
                        node.querySelectorAll<HTMLElement>('[data-widget-poll]').forEach((element) => {
                            this.registerWidget(element);
                        });
                    }
                });

                mutation.removedNodes.forEach((node) => {
                    if (node instanceof HTMLElement && node.id) {
                        this.stopPolling(node.id);
                        this.widgets.delete(node.id);
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
     * Handle page visibility changes.
     */
    private handleVisibilityChange(): void {
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.pause();
            } else {
                this.resume();
            }
        });
    }

    /**
     * Pause all polling.
     */
    pause(): void {
        this.paused = true;
    }

    /**
     * Resume all polling.
     */
    resume(): void {
        this.paused = false;
    }

    /**
     * Destroy all polling.
     */
    destroy(): void {
        this.widgets.forEach((_widget, id) => {
            this.stopPolling(id);
        });
        this.widgets.clear();
    }
}
