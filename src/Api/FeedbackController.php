<?php
namespace UninstallerForm\Api;

use UninstallerForm\Support\PluginDeactivator;
use WP_REST_Request;

/**
 * Feedback controller for the uninstaller form.
 *
 * @since 1.0.0
 *
 * @package UNINSTALLER_FORM
 */
class FeedbackController {
    protected $plugin_file;

    /**
     * FeedbackController Constructor.
     *
     * @param string $plugin_file The path to the plugin file.
     *
     * @since 1.0.0
     */
    public function __construct($plugin_file) {
        $this->plugin_file = $plugin_file;
        $this->register_routes();
    }

    /**
     * Register REST routes for the feedback controller.
     *
     * @since 1.0.0
     *
     * @return void
     */
    protected function register_routes() {
        register_rest_route('uninstaller-form/v1', '/feedback', [
            'methods'             => 'POST',
            'callback'            => [$this, 'handle_feedback'],
            'permission_callback' => '__return_true',
        ]);
    }

    /**
     * Handle feedback submission.
     *
     * @since 1.0.0
     *
     * @param WP_REST_Request $request The request object.
     * @return WP_REST_Response The response object.
     */
    public function handle_feedback(WP_REST_Request $request) {
        $data        = $request->get_json_params();
        $feedback    = sanitize_text_field($data['message'] ?? '');
        $plugin_slug = sanitize_text_field($data['pluginSlug'] ?? '');
    
        // Store in WP options (optional)
        update_option('uninstall_feedback_' . $plugin_slug, $feedback);
    
        // Store in Google Sheets
        $credentialsPath = plugin_dir_path($this->plugin_file) . 'vendor/themewinter/uninstaller_form/config/google-credentials.json';
        $spreadsheetId   = '1sqQFL1SqR93EdzgI1xBbpJIq5QPBvunCvQ_tMOIlPZo';
    
        try {
            $sheetClient = new \UninstallerForm\Support\GoogleSheetClient($credentialsPath, $spreadsheetId);
            $sheetClient->appendRow([
                current_time('mysql'),
                $plugin_slug,
                $feedback,
            ]);
        } catch (\Exception $e) {
            return new \WP_Error('sheet_error', $e->getMessage(), ['status' => 500]);
        }
    
        // Deactivate plugin
        (new PluginDeactivator($this->plugin_file))->deactivate();
    
        return rest_ensure_response([
            'status_code' => 200,
            'success'     => 1,
            'message'     => __('Feedback saved and plugin deactivated.', 'poptics-ai'),
        ]);
    }    
}