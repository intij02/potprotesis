<?php

if (! function_exists('admin_auth_user')) {
    function admin_auth_user(): ?array
    {
        $user = session()->get('admin_user');

        return is_array($user) ? $user : null;
    }
}

if (! function_exists('admin_is_logged_in')) {
    function admin_is_logged_in(): bool
    {
        return admin_auth_user() !== null;
    }
}

if (! function_exists('admin_user_role')) {
    function admin_user_role(): ?string
    {
        $user = admin_auth_user();

        if (! is_array($user) || ! isset($user['role'])) {
            return null;
        }

        return (string) $user['role'];
    }
}

if (! function_exists('admin_can_manage_users')) {
    function admin_can_manage_users(): bool
    {
        return admin_user_role() === 'admin';
    }
}

if (! function_exists('admin_can_edit_orders')) {
    function admin_can_edit_orders(): bool
    {
        return admin_user_role() === 'admin';
    }
}
