<?php

declare(strict_types=1);

namespace App\Core;

final class App
{
    private static ?self $instance = null;

    private array $config;

    private array $routes = [];

    private ?array $currentUser = null;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->currentUser = current_user();
        self::$instance = $this;
    }

    public static function instance(): self
    {
        if (! self::$instance) {
            throw new \RuntimeException('Application not initialized.');
        }

        return self::$instance;
    }

    public function config(string $key, mixed $default = null): mixed
    {
        $segments = explode('.', $key);
        $value = $this->config;

        foreach ($segments as $segment) {
            if (! is_array($value) || ! array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }

        return $value;
    }

    public function user(): ?array
    {
        return $this->currentUser;
    }

    public function get(string $path, array $handler, bool $authRequired = true): void
    {
        $this->map('GET', $path, $handler, $authRequired);
    }

    public function post(string $path, array $handler, bool $authRequired = true): void
    {
        $this->map('POST', $path, $handler, $authRequired);
    }

    private function map(string $method, string $path, array $handler, bool $authRequired): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => '/' . trim($path, '/'),
            'handler' => $handler,
            'auth' => $authRequired,
        ];
    }

    public function run(): void
    {
        $method = request_method();
        $path = request_path();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '([^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if (! preg_match($pattern, $path, $matches)) {
                continue;
            }

            array_shift($matches);

            if ($route['auth'] && is_guest()) {
                flash('message', ['text' => 'Please sign in to continue.', 'level' => 'warning']);
                redirect_to('/login');
            }

            [$class, $action] = $route['handler'];
            $controller = new $class();
            call_user_func_array([$controller, $action], $matches);
            return;
        }

        http_response_code(404);
        echo 'Page not found.';
    }
}
