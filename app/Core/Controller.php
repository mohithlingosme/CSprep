<?php

declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected App $app;

    public function __construct()
    {
        $this->app = App::instance();
    }

    protected function render(string $view, array $data = []): void
    {
        $viewFile = dirname(__DIR__) . '/Views/' . $view . '.php';
        if (! file_exists($viewFile)) {
            http_response_code(500);
            exit('View not found: ' . $view);
        }

        extract($data, EXTR_SKIP);
        $title = $data['title'] ?? config('app_name');

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        require dirname(__DIR__) . '/Views/layouts/main.php';
    }

    protected function redirect(string $path, string|null $message = null, string $level = 'success'): never
    {
        if ($message !== null) {
            flash('message', ['text' => $message, 'level' => $level]);
        }

        redirect_to($path);
    }

    protected function input(string $key, mixed $default = ''): mixed
    {
        $value = $_POST[$key] ?? $_GET[$key] ?? $default;
        return is_string($value) ? trim($value) : $value;
    }

    protected function requirePost(): void
    {
        if (request_method() !== 'POST') {
            http_response_code(405);
            exit('Method not allowed.');
        }

        verify_csrf();
    }

    protected function requireFields(array $fields): array
    {
        $errors = [];

        foreach ($fields as $field => $label) {
            $value = $this->input($field);
            if ($value === '' || $value === null) {
                $errors[] = $label . ' is required.';
            }
        }

        return $errors;
    }
}
