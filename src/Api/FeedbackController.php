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
    protected $plugin_text_domain;
    protected $plugin_name;
    protected $plugin_slug;

    /**
     * Store namespace
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $namespace ='v1';

    /**
     * Store rest base
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $rest_base = 'feedback';

    /**
     * FeedbackController Constructor.
     *
     * @param string $plugin_file The path to the plugin file.
     * @param string $plugin_text_domain The text domain of the plugin.
     * @param string $plugin_name The name of the plugin.
     * @param string $plugin_slug The slug of the plugin.
     *
     * @since 1.0.0
     */
    public function __construct($plugin_file, $plugin_text_domain, $plugin_name, $plugin_slug) {
        $this->plugin_file = $plugin_file;
        $this->plugin_text_domain = $plugin_text_domain;
        $this->plugin_name = $plugin_name;
        $this->plugin_slug = $plugin_slug;
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
        register_rest_route($this->namespace, $this->rest_base, [
            'methods'             => 'POST',
            'callback'            => [$this, 'handle_feedback'],
            'permission_callback' => function () {
                return current_user_can('manage_options');
            },
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
        $nonce = $request->get_header('X-WP-Nonce');
        if (!wp_verify_nonce($nonce, 'wp_rest')) {
            return rest_ensure_response([
                'status_code' => 403,
                'success'     => 0,
                'message'     => __('Invalid nonce. Unauthorized request.', $this->plugin_text_domain),
            ]);
        }
        
        $data     = $request->get_json_params();
        $feedback = !empty( $data['feedback'] ) ? sanitize_text_field( $data['feedback'] ) : 'No feedback';
        $reason = !empty( $data['reason'] ) ? sanitize_text_field( $data['reason'] ) : 'No reason';


        // Get current user info
        $current_user   = wp_get_current_user();
        $customer_name  = $current_user->exists() ? $current_user->display_name : 'Guest';
        $customer_email = $current_user->exists() ? $current_user->user_email : 'N/A';

        try {
            $credentialsPath = plugin_dir_path($this->plugin_file) . 'vendor/themewinter/uninstaller_form/config/google-credentials.json';
            $spreadsheetId   = '1sqQFL1SqR93EdzgI1xBbpJIq5QPBvunCvQ_tMOIlPZo';

            $sheetClient = new \UninstallerForm\Support\GoogleSheetClient($credentialsPath, $spreadsheetId);
            $sheetClient->appendRow([
                current_time('mysql'), // Timestamp
                $this->plugin_name,    // Plugin Slug
                $reason,               // Reason
                $feedback,             // Feedback message
                $customer_name,        // Customer name
                $customer_email,       // Customer email
            ]);
        } catch (\Exception $e) {
            return rest_ensure_response([
                'status_code' => 500,
                'success'     => 0,
                'message'     => __('Unable to store feedback.', $this->plugin_text_domain),
            ]);
        }

        return rest_ensure_response([
            'status_code' => 200,
            'success'     => 1,
            'message'     => __('Feedback saved successfully.', $this->plugin_text_domain),
        ]);
    }
}