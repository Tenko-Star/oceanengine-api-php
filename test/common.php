<?php

function env(string $name, mixed $default = null): mixed
{
    static $_env = null;

    if ($_env === null) {
        $content = file_get_contents('.env');
        $lines = explode("\n", $content);

        foreach ($lines as $line) {
            if (empty(trim($line))) {
                continue;
            }

            if (str_contains($line, '=')) {
                [$key, $value] = @explode('=', $line);
                $_env[trim($key)] = trim($value);
            }
        }
    }

    return $_env[$name] ?? $default;
}