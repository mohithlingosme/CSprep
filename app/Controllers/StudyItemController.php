<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\StudyItemModel;
use App\Services\LookupService;

final class StudyItemController extends Controller
{
    public function index(): void
    {
        $this->render('study-items/index', [
            'title' => 'Education Engine',
            'items' => (new StudyItemModel())->listDetailed(),
        ]);
    }

    public function create(): void
    {
        $this->render('study-items/form', [
            'title' => 'Create Study Item',
            'item' => null,
            'lookup' => (new LookupService())->all(),
        ]);
    }

    public function store(): void
    {
        $this->requirePost();
        remember_old($_POST);

        $errors = $this->requireFields([
            'subject_id' => 'Subject',
            'item_type' => 'Item type',
            'prompt' => 'Prompt',
        ]);

        if ($errors) {
            flash('message', ['text' => implode(' ', $errors), 'level' => 'danger']);
            redirect_to('/study-items/create');
        }

        (new StudyItemModel())->create($this->payload());
        clear_old();

        $this->redirect('/study-items', 'Study item created successfully.');
    }

    public function edit(int $id): void
    {
        $item = (new StudyItemModel())->find($id);
        if (! $item) {
            $this->redirect('/study-items', 'Study item not found.', 'danger');
        }

        $this->render('study-items/form', [
            'title' => 'Edit Study Item',
            'item' => $item,
            'lookup' => (new LookupService())->all(),
        ]);
    }

    public function update(int $id): void
    {
        $this->requirePost();
        remember_old($_POST);

        (new StudyItemModel())->update($id, $this->payload());
        clear_old();

        $this->redirect('/study-items', 'Study item updated successfully.');
    }

    public function delete(int $id): void
    {
        $this->requirePost();
        (new StudyItemModel())->delete($id);
        $this->redirect('/study-items', 'Study item deleted successfully.');
    }

    private function payload(): array
    {
        return [
            'subject_id' => (int) $this->input('subject_id'),
            'topic_id' => null_if_empty($this->input('topic_id')),
            'knowledge_entry_id' => null_if_empty($this->input('knowledge_entry_id')),
            'item_type' => $this->input('item_type'),
            'prompt' => $this->input('prompt'),
            'option_a' => $this->input('option_a'),
            'option_b' => $this->input('option_b'),
            'option_c' => $this->input('option_c'),
            'option_d' => $this->input('option_d'),
            'correct_answer' => $this->input('correct_answer'),
            'explanation' => $this->input('explanation'),
            'marks' => null_if_empty($this->input('marks')),
            'difficulty' => $this->input('difficulty', 'Intermediate'),
            'exam_year' => null_if_empty($this->input('exam_year')),
            'revision_bucket' => $this->input('revision_bucket'),
            'ai_ready' => (int) $this->input('ai_ready', 0),
        ];
    }
}
