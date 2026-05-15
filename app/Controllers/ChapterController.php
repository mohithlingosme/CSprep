<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\ChapterModel;
use App\Models\SubjectModel;

final class ChapterController extends Controller
{
    public function index(): void
    {
        $this->render('chapters/index', [
            'title' => 'Chapter Management',
            'chapters' => (new ChapterModel())->listDetailed(),
        ]);
    }

    public function create(): void
    {
        $this->render('chapters/form', [
            'title' => 'Create Chapter',
            'chapter' => null,
            'subjects' => (new SubjectModel())->options(),
        ]);
    }

    public function store(): void
    {
        $this->requirePost();
        remember_old($_POST);

        $errors = $this->requireFields([
            'subject_id' => 'Subject',
            'title' => 'Chapter title',
        ]);

        if ($errors) {
            flash('message', ['text' => implode(' ', $errors), 'level' => 'danger']);
            redirect_to('/chapters/create');
        }

        (new ChapterModel())->create($this->payload());
        clear_old();

        $this->redirect('/chapters', 'Chapter created successfully.');
    }

    public function edit(int $id): void
    {
        $chapter = (new ChapterModel())->find($id);
        if (! $chapter) {
            $this->redirect('/chapters', 'Chapter not found.', 'danger');
        }

        $this->render('chapters/form', [
            'title' => 'Edit Chapter',
            'chapter' => $chapter,
            'subjects' => (new SubjectModel())->options(),
        ]);
    }

    public function update(int $id): void
    {
        $this->requirePost();
        remember_old($_POST);

        (new ChapterModel())->update($id, $this->payload());
        clear_old();

        $this->redirect('/chapters', 'Chapter updated successfully.');
    }

    public function delete(int $id): void
    {
        $this->requirePost();
        (new ChapterModel())->delete($id);
        $this->redirect('/chapters', 'Chapter deleted successfully.');
    }

    private function payload(): array
    {
        return [
            'subject_id' => (int) $this->input('subject_id'),
            'code' => $this->input('code'),
            'title' => $this->input('title'),
            'weightage' => $this->input('weightage'),
            'study_order' => (int) $this->input('study_order', 0),
            'dependency_notes' => $this->input('dependency_notes'),
            'summary' => $this->input('summary'),
        ];
    }
}
