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
