# Uninstaller Feedback Form

A reusable WordPress package that collects plugin deactivation feedback via a React-based form and stores it via REST API.

---

## 📦 Features

- React-based feedback form shown on plugin deactivation
- Sends feedback via REST API
- Automatically deactivates the plugin after feedback submission
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

3. **On composer udate process if you are asked to give token, followings are the steps you can generate token**
    - Go to GitHub: https://github.com
    - Login to your account.
    - Navigate to Settings:
    - Click your profile picture (top right) → Settings
    - Access Developer Settings:
    - Scroll down in the left sidebar → Click Developer settings
    - Personal access tokens → Tokens (classic):
    - Click Personal access tokens, then choose Tokens (classic)
    - Click "Generate new token" → "Generate new token (classic)"
    - Set token details:
        - Note: Give your token a name (e.g., "Git CLI access")
        - Expiration: Choose an expiry time (e.g., 30 days or "No expiration")
        - Scopes: Select the permissions you need, for example:
            - repo (full control of private repositories)
            - workflow (for GitHub Actions)
            - read:org (if needed for organization access)
            - user (for profile info)
    - Click Generate Token
    - Copy the token immediately — it won't be shown again!

## Configuration

1. **In your plugin's main file, add this initialization code. Make sure this code will be executed after all of your scripts enqued successfully**

```php
    if (file_exists(plugin_dir_path( __FILE__ ) . '/vendor/autoload.php')) {
        require_once plugin_dir_path( __FILE__ ) . '/vendor/autoload.php';
    }

    if ( class_exists( 'UninstallerForm\UninstallerForm' ) ) {
            $uninstaller_form = new UninstallerForm\UninstallerForm();
            $uninstaller_form->init(
                'Poptics',
                'poptics',
                __FILE__,
                'poptics',
                'poptics-script'
            );
        }
```

## Feedback API Integration From NPM Package

**Install the Feedback API NPM Package**:  base_url/plugin_slug/v1/feedback

**Example**: http://localhost/project/wp-json/wp-cafe/v1/feedback

**Here**: 

base_url = http://localhost/project/wp-json

plugin_slug = wp-cafe

**API DOCUMENTATION**: https://documenter.getpostman.com/view/3522317/2sB2cbaeCQ

## License

This package is licensed under the **GPL-2.0-or-later**.

See the [LICENSE](LICENSE) file for the full license text.
