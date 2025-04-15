<?php
namespace UninstallerForm\Support;

class Localizer {
    protected $name, $slug, $plugin_file, $script_handle;

    public function __construct($name, $slug, $plugin_file, $script_handle) {
        $this->name = $name;
        $this->slug = $slug;
        $this->plugin_file = $plugin_file;
        $this->script_handle = $script_handle;
    }

    public function handle() {
        wp_localize_script($this->script_handle, 'UninstallerData', [
            'restUrl'    => rest_url('uninstaller-form/v1/feedback'),
            'nonce'      => wp_create_nonce('wp_rest'),
            'pluginName' => $this->name,
            'pluginSlug' => $this->slug,
        ]);
    }
}
