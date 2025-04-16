<?php
namespace UninstallerForm;

/**
 * UninstallerForm class for the uninstaller form.
 *
 * @since 1.0.0
 *
 * @package UNINSTALLER_FORM
 */
class UninstallerForm {
    /**
     * UninstallerForm initiaization.
     *
     * @param string $plugin_name The name of the plugin.
     * @param string $plugin_slug The slug of the plugin.
     * @param string $plugin_file The path to the plugin file.
     * @param string $plugin_text_domain The text domain of the plugin.
     * @param string $script_handler The handle of the script to enqueue.
     *
     * @since 1.0.0
     */
    public static function init($plugin_name, $plugin_slug, $plugin_file,$plugin_text_domain, $script_handler) {
        $hook_registrar = new HookRegistrar($plugin_name, $plugin_slug, $plugin_file,$plugin_text_domain, $script_handler);
        $hook_registrar->register();
    }
}
