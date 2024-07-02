<?php
/*
Plugin Name: Flipbook Login
Description: A plugin to manage .htpasswd file entries for password restricted flipbook.
Version: 1.0
Author: Rafael Robinson
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class HtpasswdEditor {
    const HTPASSWD_FILE = __DIR__ . '/.htpasswd';

    public function __construct() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_ajax_htpasswd_editor', [$this, 'handle_ajax']);
    }

    public function add_admin_menu() {
        add_menu_page(
            'Flipbook Users',
            'Flipbook Users',
            'manage_options',
            'htpasswd-editor',
            [$this, 'admin_page'],
            'dashicons-admin-users'
        );
    }

    public function enqueue_scripts($hook) {
        if ($hook != 'toplevel_page_htpasswd-editor') {
            return;
        }
        wp_enqueue_script('flipbook-login-js', plugins_url('flipbook-login.js', __FILE__), ['jquery'], null, true);
        wp_localize_script('flipbook-login-js', 'HtpasswdEditor', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('htpasswd_editor_nonce')
        ]);
        wp_enqueue_style('flipbook-login-css', plugins_url('flipbook-login.css', __FILE__));
    }

    public function admin_page() {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        ?>
        <div class="wrap">
            <h1>Flipbook Logins</h1>
            <form id="addUserForm">
                <input type="email" id="username" placeholder="Email (Username)" required>
                <input type="password" id="password" placeholder="Password" required>
                <button type="submit">Add User</button>
            </form>
            <form id="editUserForm">
                <input type="email" id="edit_username" placeholder="Email (Username)" required>
                <input type="password" id="edit_password" placeholder="New Password" required>
                <button type="submit">Update Password</button>
            </form>
            <div id="userList"></div>
        </div>
        <?php
    }

    public function handle_ajax() {
        check_ajax_referer('htpasswd_editor_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'You do not have sufficient permissions to perform this action']);
            return;
        }

        $action = $_POST['action_type'];

        switch ($action) {
            case 'add':
                $this->add_user($_POST['username'], $_POST['password']);
                break;
            case 'edit':
                $this->edit_user($_POST['username'], $_POST['password']);
                break;
            case 'list':
                $this->list_users();
                break;
            case 'delete':
                $this->delete_user($_POST['username']);
                break;
            default:
                wp_send_json_error(['message' => 'Invalid action']);
        }
    }

    private function add_user($username, $password) {
        if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
            wp_send_json_error(['message' => 'Invalid email address']);
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $entry = "$username:$hashedPassword\n";
        file_put_contents(self::HTPASSWD_FILE, $entry, FILE_APPEND | LOCK_EX);
        wp_send_json_success(['message' => 'User added successfully']);
    }

    private function edit_user($username, $password) {
        if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
            wp_send_json_error(['message' => 'Invalid email address']);
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $lines = file(self::HTPASSWD_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $newLines = [];
        $userExists = false;
        foreach ($lines as $line) {
            if (str_starts_with($line, "$username:")) {
                $newLines[] = "$username:$hashedPassword";
                $userExists = true;
            } else {
                $newLines[] = $line;
            }
        }
        if (!$userExists) {
            $newLines[] = "$username:$hashedPassword";
        }
        file_put_contents(self::HTPASSWD_FILE, implode("\n", $newLines) . "\n");
        wp_send_json_success(['message' => 'User edited successfully']);
    }

    private function list_users() {
        $users = [];
        $lines = file(self::HTPASSWD_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $parts = explode(':', $line);
            if (count($parts) > 1) {
                $users[] = $parts[0];
            }
        }
        wp_send_json_success(['users' => $users]);
    }

    private function delete_user($username) {
        $lines = file(self::HTPASSWD_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $newLines = [];
        foreach ($lines as $line) {
            if (!str_starts_with($line, "$username:")) {
                $newLines[] = $line;
            }
        }
        file_put_contents(self::HTPASSWD_FILE, implode("\n", $newLines) . "\n");
        wp_send_json_success(['message' => 'User deleted successfully']);
    }
}

new HtpasswdEditor();