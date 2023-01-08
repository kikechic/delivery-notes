<?php

namespace Kikechi\DeliveryNotes;

use Illuminate\Support\ServiceProvider;

class DeliveryNoteServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerResources();
        $this->defineAssetPublishing();
    }

    /**
     * Register the Invoices routes.
     *
     * @return void
     */
    protected function registerResources(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'delivery-notes');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'delivery-notes');
    }

    /**
     * Define the asset publishing configuration.
     *
     * @return void
     */
    protected function defineAssetPublishing(): void
    {
        $this->publishes([
            DELIVERY_NOTES_PATH . '/public' => public_path('vendor/delivery-notes'),
        ], 'delivery-notes.assets');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        if (!defined('DELIVERY_NOTES_PATH')) {
            define('DELIVERY_NOTES_PATH', realpath(__DIR__ . '/../'));
        }

        $this->configure();
        $this->offerPublishing();
        $this->registerServices();
        $this->registerCommands();

    }

    /**
     * Set up the configuration for Journal.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/delivery-notes.php', 'delivery-notes');
    }

    /**
     * Set up the resource publishing groups for Invoices.
     *
     * @return void
     */
    protected function offerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            // Publishing the configuration file.
            $this->publishes([
                __DIR__ . '/../config/delivery-notes.php' => config_path(path: 'delivery-notes.php'),
            ], 'delivery-notes.config');

            // Publishing the views.
            $this->publishes([
                __DIR__ . '/../resources/views' => base_path(path: 'resources/views/vendor/delivery-notes'),
            ], 'delivery-notes.views');

            // Publishing the translation files.
            $this->publishes([
                __DIR__ . '/../lang' => base_path(path: 'lang/vendor/delivery-notes'),
            ], 'delivery-notes.translations');
        }
    }

    /**
     * Register Invoices' services in the container.
     *
     * @return void
     */
    protected function registerServices(): void
    {
        $this->app->singleton('deliveryNote', function ($app) {
            return new DeliveryNote;
        });
    }

    /**
     * Register the Invoices Artisan commands.
     *
     * @return void
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\InstallDeliveryNoteCommand::class,
                Commands\UpdateDeliveryNoteCommand::class,
            ]);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['deliveryNote'];
    }
}