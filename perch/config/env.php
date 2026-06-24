<?php
/**
 * Minimal .env loader (no external dependencies).
 *
 * Reads KEY=VALUE pairs from the project-root .env file and exposes them via
 * getenv() / $_ENV / $_SERVER. Values already present in the real environment
 * are left untouched, so server-level env vars always take precedence.
 *
 * Included near the top of perch/config/config.php, which Perch loads on every
 * request, so the values are available everywhere (admin, runtime, page
 * templates and the Stripe webhook).
 */

if (!function_exists('happyhuts_load_env')) {
    function happyhuts_load_env($path)
    {
        if (!is_readable($path)) {
            return false;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);

            // Skip blank lines and comments
            if ($line === '' || $line[0] === '#') {
                continue;
            }

            // Split on the first "=" only
            $pos = strpos($line, '=');
            if ($pos === false) {
                continue;
            }

            $name  = trim(substr($line, 0, $pos));
            $value = trim(substr($line, $pos + 1));

            if ($name === '') {
                continue;
            }

            // Strip a single pair of surrounding quotes, if present
            $len = strlen($value);
            if ($len >= 2) {
                $first = $value[0];
                $last  = $value[$len - 1];
                if (($first === '"' && $last === '"') || ($first === "'" && $last === "'")) {
                    $value = substr($value, 1, -1);
                }
            }

            // Don't clobber a value already set in the real environment
            if (getenv($name) !== false) {
                continue;
            }

            putenv($name . '=' . $value);
            $_ENV[$name]    = $value;
            $_SERVER[$name] = $value;
        }

        return true;
    }
}

// Project root is two levels up from /perch/config
happyhuts_load_env(dirname(dirname(__DIR__)) . '/.env');
