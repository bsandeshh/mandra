<?php
/**
 * Lightweight .env loader for PHP-only projects (no composer dependency).
 * Loads key=value pairs into getenv()/$_ENV without echoing secrets.
 */
function load_env($envFilePath = null) {
    $root = __DIR__;
    $path = $envFilePath ?: $root . DIRECTORY_SEPARATOR . '.env';
    if (!file_exists($path) || !is_readable($path)) {
        return; // silently skip if not present
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $trimmed = trim($line);
        if ($trimmed === '' || str_starts_with($trimmed, '#')) {
            continue;
        }
        $parts = explode('=', $trimmed, 2);
        if (count($parts) !== 2) {
            continue;
        }
        $key = trim($parts[0]);
        $value = trim($parts[1]);
        // Remove optional surrounding quotes
        if ((str_starts_with($value, '"') && str_ends_with($value, '"')) || (str_starts_with($value, "'") && str_ends_with($value, "'"))) {
            $value = substr($value, 1, -1);
        }
        // Set env only if not already set in server environment
        if (getenv($key) === false) {
            putenv($key . '=' . $value);
            $_ENV[$key] = $value;
        }
    }
}

// Polyfill for PHP < 8.0 str_starts_with/str_ends_with
if (!function_exists('str_starts_with')) {
    function str_starts_with($haystack, $needle) {
        return $needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}
if (!function_exists('str_ends_with')) {
    function str_ends_with($haystack, $needle) {
        if ($needle === '') return true;
        return substr($haystack, -strlen($needle)) === $needle;
    }
}
?>


