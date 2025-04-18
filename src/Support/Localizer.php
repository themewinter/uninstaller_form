<?php
namespace UninstallerForm\Support;

/**
 * Localizer class for the uninstaller form.
 *
 * @since 1.0.0
 *
 * @package UNINSTALLER_FORM
 */
class Localizer {
    protected $name, $slug, $plugin_file, $script_handle;

    /**
     * Localizer Constructor.
     *
     * @param string $name The name of the plugin.
     * @param string $slug The slug of the plugin.
     * @param string $plugin_file The path to the plugin file.
     * @param string $script_handle The handle of the script to enqueue.
     *
     * @since 1.0.0
     */
    public function __construct($name, $slug, $plugin_file, $script_handle) {
        $this->name          = $name;
        $this->slug          = $slug;
        $this->plugin_file   = $plugin_file;
        $this->script_handle = $script_handle;
    }

    /**
     * Handle localization for the uninstaller form.
     *
     * @since 1.0.0
     */
    public function handle() {
        wp_localize_script($this->script_handle, $this->slug.'_feedback', [
            'nonce'      => wp_create_nonce('wp_feedback')
        ]);
    }
}