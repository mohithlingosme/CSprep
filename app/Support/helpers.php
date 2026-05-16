<?php

declare(strict_types=1);

use App\Core\App;

function config(string $key, mixed $default = null): mixed
{
    return App::instance()->config($key, $default);
}

function base_url(): string
{
    return rtrim((string) config('base_url', ''), '/');
}

function url(string $path = ''): string
{
    $path = trim($path);
    if ($path === '' || $path === '/') {
        return base_url();
    }

    return base_url() . '/' . ltrim($path, '/');
}

function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}

function e(string|null $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect_to(string $path): never
{
    header('Location: ' . url($path));
    exit;
}

function session_get(string $key, mixed $default = null): mixed
{
    return $_SESSION[$key] ?? $default;
}

function session_put(string $key, mixed $value): void
{
    $_SESSION[$key] = $value;
}

function flash(string $key, mixed $value = null): mixed
{
    if (func_num_args() === 2) {
        $_SESSION['_flash'][$key] = $value;
        return null;
    }

    $message = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);

    return $message;
}

function old(string $key, mixed $default = ''): mixed
{
    return $_SESSION['_old'][$key] ?? $default;
}

function remember_old(array $input): void
{
    $_SESSION['_old'] = $input;
}

function clear_old(): void
{
    unset($_SESSION['_old']);
}

function request_path(): string
{
    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $basePath = parse_url(base_url(), PHP_URL_PATH) ?: '';

    if ($basePath !== '' && str_starts_with($uri, $basePath)) {
        $uri = substr($uri, strlen($basePath)) ?: '/';
    }

    return '/' . trim($uri, '/');
}

function is_active_route(string $path): bool
{
    return request_path() === '/' . trim($path, '/');
}

function request_method(): string
{
    return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
}

function csrf_token(): string
{
    if (! isset($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['_csrf'];
}

function csrf_field(): string
{
    // name `_token` is required by verify_csrf()
    return '<input type="hidden" name="_token" value="' . e(csrf_token()) . '">';
}


function verify_csrf(): void
{
    $token = $_POST['_token'] ?? '';
    if (! hash_equals((string) session_get('_csrf', ''), (string) $token)) {
        http_response_code(419);
        exit('CSRF token mismatch.');
    }
}

function format_date(string|null $value, string $format = 'd M Y'): string
{
    if (! $value) {
        return '-';
    }

    $timestamp = strtotime($value);
    return $timestamp ? date($format, $timestamp) : $value;
}

function format_number(float|int|string|null $value, int $decimals = 0): string
{
    return number_format((float) $value, $decimals);
}

function selected(mixed $actual, mixed $expected): string
{
    return (string) $actual === (string) $expected ? 'selected' : '';
}

function checked(mixed $actual, mixed $expected): string
{
    return (string) $actual === (string) $expected ? 'checked' : '';
}

function current_user(): ?array
{
    return session_get('user');
}

function is_guest(): bool
{
    return current_user() === null;
}

function badge_class(string $status): string
{
    return match (strtolower($status)) {
        'published', 'done', 'completed', 'active', 'compliant' => 'success',
        'review', 'pending', 'draft', 'medium' => 'warning',
        'critical', 'high', 'overdue', 'inactive' => 'danger',
        default => 'secondary',
    };
}

function slugify(string $value): string
{
    $value = preg_replace('/[^a-zA-Z0-9]+/', '-', strtolower(trim($value))) ?? '';
    return trim($value, '-');
}

function null_if_empty(mixed $value): mixed
{
    if (is_string($value)) {
        $value = trim($value);
    }

    return $value === '' ? null : $value;
}
