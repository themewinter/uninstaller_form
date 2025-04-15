<?php

namespace UninstallerForm;

class UninstallerForm {
    public static function init($plugin_name, $plugin_slug, $plugin_file) {
        (new HookRegistrar($plugin_name, $plugin_slug, $plugin_file))->register();
    }
}
