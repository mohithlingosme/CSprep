<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\SubjectModel;

final class SubjectController extends Controller
{
    public function index(): void
    {
        $this->render('subjects/index', [
            'title' => 'Subject Management',
            'subjects' => (new SubjectModel())->listDetailed(),
        ]);
    }

    public function create(): void
    {
        $this->render('subjects/form', [
            'title' => 'Create Subject',
            'subject' => null,
        ]);
    }

    public function store(): void
    {
        $this->requirePost();
        remember_old($_POST);

        $errors = $this->requireFields([
            'code' => 'Subject code',
            'name' => 'Subject name',
        ]);

        if ($errors) {
            flash('message', ['text' => implode(' ', $errors), 'level' => 'danger']);
            redirect_to('/subjects/create');
        }

        (new SubjectModel())->create($this->payload());
        clear_old();

        $this->redirect('/subjects', 'Subject created successfully.');
    }

    public function edit(int $id): void
    {
        $subject = (new SubjectModel())->find($id);
        if (! $subject) {
            $this->redirect('/subjects', 'Subject not found.', 'danger');
        }

        $this->render('subjects/form', [
            'title' => 'Edit Subject',
            'subject' => $subject,
        ]);
    }

    public function update(int $id): void
    {
        $this->requirePost();
        remember_old($_POST);

        (new SubjectModel())->update($id, $this->payload());
        clear_old();

        $this->redirect('/subjects', 'Subject updated successfully.');
    }

    public function delete(int $id): void
    {
        $this->requirePost();
        (new SubjectModel())->delete($id);
        $this->redirect('/subjects', 'Subject deleted successfully.');
    }

    private function payload(): array
    {
        return [
            'code' => $this->input('code'),
            'name' => $this->input('name'),
            'slug' => slugify((string) $this->input('name')),
            'domain_type' => $this->input('domain_type'),
            'description' => $this->input('description'),
            'syllabus_version' => $this->input('syllabus_version'),
            'status' => $this->input('status', 'Active'),
            'display_order' => (int) $this->input('display_order', 0),
        ];
    }
}
