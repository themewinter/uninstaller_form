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
If you do not have, composer installed in your plugin, please install using 

```bash
composer init
```

2. **Update Dependencies**

```bash
composer update
composer dump-autoload
```


## Configuration

1. **In your plugin's main file, add this initialization code. Make sure this code will be executed after all of your scripts enqued successfully**

```php
    if (file_exists(plugin_dir_path( __FILE__ ) . '/vendor/autoload.php')) {
        require_once plugin_dir_path( __FILE__ ) . '/vendor/autoload.php';
    }

    UninstallerForm::init(
        'WP Cafe',         // Plugin name
        'wp-cafe',         // Plugin Slug
        __FILE__,          
        'wpcafe',          // Text Domain Name
        'plugins-admin-script-handler'  // plugins-admin-script-handler
    );
```

## Feedback API Integration From NPM Package

**Install the Feedback API NPM Package**:  base_url/plugin_slug/v1/feedback

**Example**: http://localhost/project/wp-json/wp-cafe/v1/feedback

**Here**: 

base_url = http://localhost/project/wp-json

plugin_slug = wp-cafe

**API DOCUMENTATION**: https://documenter.getpostman.com/view/3522317/2sB2cbaeCQ
