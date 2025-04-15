<?php
namespace UninstallerForm\Support;

class PluginDeactivator {
    protected $plugin_file;

    public function __construct($plugin_file) {
        $this->plugin_file = $plugin_file;
    }

    public function deactivate() {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        deactivate_plugins(plugin_basename($this->plugin_file));
    }
}