<?php
namespace UninstallerForm;

use UninstallerForm\Api\FeedbackController;
use UninstallerForm\Support\Localizer;

class HookRegistrar {
    protected $plugin_name, $plugin_slug, $plugin_file;

    public function __construct($plugin_name, $plugin_slug, $plugin_file) {
        $this->plugin_name = $plugin_name;
        $this->plugin_slug = $plugin_slug;
        $this->plugin_file = $plugin_file;
    }

    public function register() {
        add_action('rest_api_init', function () {
            new FeedbackController($this->plugin_file);
        });

        add_action('wp_enqueue_scripts', function () {
            (new Localizer($this->plugin_name, $this->plugin_slug, $this->plugin_file))->handle();
        });
    }
}