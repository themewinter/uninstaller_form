<?php
namespace UninstallerForm\Api;

use WP_REST_Request;
use UninstallerForm\Support\PluginDeactivator;

class FeedbackController {
    protected $plugin_file;

    public function __construct($plugin_file) {
        $this->plugin_file = $plugin_file;
        $this->register_routes();
    }

    protected function register_routes() {
        register_rest_route('uninstaller-form/v1', '/feedback', [
            'methods'  => 'POST',
            'callback' => [$this, 'handle_feedback'],
            'permission_callback' => '__return_true',
        ]);
    }

    public function handle_feedback(WP_REST_Request $request) {
        $data = $request->get_json_params();
        $feedback = sanitize_text_field($data['message'] ?? '');
        $plugin_slug = sanitize_text_field($data['pluginSlug'] ?? '');

        update_option('uninstall_feedback_' . $plugin_slug, $feedback);

        (new PluginDeactivator($this->plugin_file))->deactivate();

        return rest_ensure_response(['success' => true]);
    }
}
