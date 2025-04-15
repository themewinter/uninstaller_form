<?php
namespace UninstallerForm\Support;

/**
 * PluginDeactivator class for the uninstaller form.
 * 
 * @since 1.0.0
 * 
 * @package UNINSTALLER_FORM
 */
class PluginDeactivator {
    protected $plugin_file;

    /**
     * PluginDeactivator Constructor.
     * 
     * @param string $plugin_file The path to the plugin file.
     * 
     * @since 1.0.0
     */ 
    public function __construct($plugin_file) {
        $this->plugin_file = $plugin_file;
    }

    /**
     * Deactivate the plugin.
     * 
     * @since 1.0.0
     */
    public function deactivate() {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        deactivate_plugins(plugin_basename($this->plugin_file));
    }
}