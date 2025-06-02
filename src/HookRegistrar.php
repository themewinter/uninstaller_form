<?php
namespace UninstallerForm;

use UninstallerForm\Api\FeedbackController;
use UninstallerForm\Support\Localizer;

/**
 * HookRegistrar class for the uninstaller form.
 *
 * @since 1.0.0
 *
 * @package UNINSTALLER_FORM
 */
class HookRegistrar {
    protected $plugin_name, $plugin_slug, $plugin_file, $plugin_text_domain, $script_handler;

    /**
     * HookRegistrar Constructor.
     *
     * @param string $plugin_name The name of the plugin.
     * @param string $plugin_slug The slug of the plugin.
     * @param string $plugin_file The path to the plugin file.
     * @param string $plugin_text_domain The text domain of the plugin.
     * @param string $script_handler The handle of the script to enqueue.
     *
     * @since 1.0.0
     */
    public function __construct($plugin_name, $plugin_slug, $plugin_file, $plugin_text_domain, $script_handler) {
        $this->plugin_name        = $plugin_name;
        $this->plugin_slug        = $plugin_slug;
        $this->plugin_file        = $plugin_file;
        $this->plugin_text_domain = $plugin_text_domain;
        $this->script_handler     = $script_handler;
    }

    /**
     * Register hooks for the uninstaller form.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function register() {
        add_action('rest_api_init', function () {
            new FeedbackController($this->plugin_file,$this->plugin_text_domain, $this->plugin_name, $this->plugin_slug);
        });

        add_action('admin_enqueue_scripts', function () {
            $localizer = new Localizer($this->plugin_name, $this->plugin_text_domain, $this->plugin_file, $this->script_handler);
            $localizer->handle();
        });
    }
}