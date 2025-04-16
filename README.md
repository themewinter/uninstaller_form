# Uninstaller Feedback Form

A reusable WordPress package that collects plugin deactivation feedback via a React-based form, stores it via REST API, and optionally logs feedback to a Google Sheet.

---

## 📦 Features

- React-based feedback form shown on plugin deactivation
- Sends feedback via REST API
- Automatically deactivates the plugin after feedback submission
- Optionally logs feedback to Google Sheets
- Easy to integrate into any WordPress plugin

---

## 🛠 Installation

1. **Require this package via Composer**

Add the following configuration to your `composer.json`:

```json
{
    "require": {
        "themewinter/uninstaller_form": "dev-main"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/themewinter/uninstaller_form"
        }
    ]
}
```

2. **Update Dependencies**

```json
composer update
composer dump-autoload


## Configuration

1. **In your plugin's main file, add this initialization code within the init action hook**

add_action('init', function() {
    UninstallerForm::init(
        'WP Cafe',         // Plugin name
        'wp-cafe',         // Plugin Slug
        __FILE__,          
        'wpcafe',          // Text Domain Name
        'plugins-admin-script-handler'  // plugins-admin-script-handler
    );
});

## Feedback API Integration From NPM Package

API base_url/plugin_slug/v1/feedback

Example: http://localhost/project/wp-json/wp-cafe/v1/feedback

Here: 

base_url = http://localhost/project/wp-json

plugin_slug = wp-cafe