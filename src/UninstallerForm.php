<?php

namespace UninstallerForm;

class UninstallerForm {
    public static function init($plugin_name, $plugin_slug, $plugin_file, $script_handler) {
        (new HookRegistrar($plugin_name, $plugin_slug, $plugin_file,$script_handler))->register();
    }
}
