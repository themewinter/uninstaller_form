# Email notification SDK

A powerful flow-based notification manager for WordPress. Define and execute customizable workflows based on user-defined actions using nodes like triggers, conditions, delays, and email notifications.

---

## 🚀 Features

- Trigger flows via WordPress actions
- Define flow configurations using a visual editor (nodes and edges)
- Supports condition-based branching
- Schedule delays with resume capability
- Send emails through configurable email nodes
- Save and resume flow checkpoints
- Easily extendable

---

# 🛠 Installation

## 1. Require this package via Composer

Add the following configuration to your `composer.json`:

```json
{
    "require": {
        "themewinter/email-notification-sdk": "dev-main"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/themewinter/email-notification-sdk"
        }
    ]
}
```

If Composer is not already initialized in your plugin, please run:

```bash
composer init
```

---

## 2. Update Dependencies

```bash
composer update
composer dump-autoload
```

---

## 3. If you're prompted for a GitHub token during the Composer update process, follow these steps to generate one:

- Go to GitHub: https://github.com
- Log in to your account.
- Navigate to **Settings**:
    - Click your profile picture (top right) → **Settings**
- Access **Developer Settings**:
    - Scroll down in the left sidebar → Click **Developer settings**
- Go to **Personal Access Tokens** → **Tokens (classic)**
- Click **Generate new token** → **Generate new token (classic)**
- Set token details:
    - **Note**: Give your token a name (e.g., "Git CLI Access")
    - **Expiration**: Choose an expiry time (e.g., 30 days or "No expiration")
    - **Scopes**: Select the permissions you need, for example:
        - `repo` (full control of private repositories)
        - `workflow` (for GitHub Actions)
        - `read:org` (if needed for organization access)
        - `user` (for profile info)
- Click **Generate Token**
- **Copy the token immediately** — it won't be shown again!

---

# 🔧 Configuration

## 1. In your plugin's main file, add this initialization code

> Make sure this code runs after all of your scripts are enqueued successfully.

```php
if (file_exists(plugin_dir_path(__FILE__) . '/vendor/autoload.php')) {
    require_once plugin_dir_path(__FILE__) . '/vendor/autoload.php';
}

if (class_exists(\ENS\Core\Sdk::class)) {
    \ENS\Core\Sdk::get_instance()
        ->setup([
            'plugin_name'          => 'Poptics', //plugin name
            'plugin_slug'          => 'poptics', //plugin slug
            'general_prefix'       => 'pt', //general prefix - short + no (_ / -)
            'text_domain'          => 'poptics',//textdomein
            'admin_script_handler' => 'poptics-script',//main admin script handler name
            'sub_menu_details'     => [ //submenu details
                'menu_position'    => '10', // menu position
                'menu_permission'  => 'manage_options', //permissions
                'menu_filter_hook' => 'poptics_menu', // filter hook to assign menu
                'menu_title'       => __('Flow Manager', 'poptics'), //menu title
                'menu_slug'        => 'poptics-flow-manager', // menu slug
            ],
        ])
        ->init();

    add_filter('ens_available_actions', function ($actions) {
        $actions = [
            [
                "trigger_label" => "Event Created",
                "trigger_value" => "event_created",
                "trigger_data"  => [
                    ["label" => "Event Name", "value" => "event_name", "type" => "string"],
                    ["label" => "Event Date", "value" => "event_date", "type" => "date"],
                    ["label" => "User Email", "value" => "user_email", "type" => "string"],
                ],
                "delay_dependencies" => [
                    ["label" => "Event Date", "value" => "event_date"],
                ],
                "email_receivers" => [
                    ["label" => "User Email", "value" => "user_email"],
                ],
            ],
            [
                "trigger_label" => "Event Rescheduled",
                "trigger_value" => "event_rescheduled",
                "trigger_data"  => [
                    ["label" => "Event Name", "value" => "event_name", "type" => "string"],
                    ["label" => "Event Date", "value" => "event_date", "type" => "date"],
                    ["label" => "User Email", "value" => "user_email", "type" => "string"],
                ],
                "delay_dependencies" => [
                    ["label" => "Event Date", "value" => "event_date"],
                ],
                "email_receivers" => [
                    ["label" => "User Email", "value" => "user_email"],
                ],
            ],
        ];

        return $actions;
    });
}
```

---

# 📤 Triggering an Event

When the event occurs, call the following code in the corresponding function:

```php
do_action('global_notification_hook', 'event_created', [
    'user_email' => 'badhon001@example.com',
    'event_name' => 'World Cup Cricket',
    'event_date' => '17023658981' // Timestamp of the event date
]);
```
