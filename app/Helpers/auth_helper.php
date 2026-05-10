<?php

if (! function_exists('normalize_admin_role')) {
    function normalize_admin_role($role): string
    {
        $normalized = strtolower(trim((string) $role));

        if (in_array($normalized, ['admin', 'administrador'], true)) {
            return 'admin';
        }

        return 'staff';
    }
}

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

        return normalize_admin_role($user['role']);
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
        return admin_is_logged_in();
    }
}

if (! function_exists('admin_can_unlock_order_edits')) {
    function admin_can_unlock_order_edits(): bool
    {
        return admin_user_role() === 'admin';
    }
}

if (! function_exists('admin_can_manage_content')) {
    function admin_can_manage_content(): bool
    {
        return admin_user_role() === 'admin';
    }
}

if (! function_exists('client_auth_user')) {
    function client_auth_user(): ?array
    {
        $user = session()->get('client_user');

        return is_array($user) ? $user : null;
    }
}

if (! function_exists('client_is_logged_in')) {
    function client_is_logged_in(): bool
    {
        return client_auth_user() !== null;
    }
}

if (! function_exists('client_is_active')) {
    function client_is_active(): bool
    {
        $user = client_auth_user();

        return is_array($user) && (bool) ($user['is_active'] ?? false);
    }
}
