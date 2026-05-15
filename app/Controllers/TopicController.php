<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\ChapterModel;
use App\Models\TopicModel;

final class TopicController extends Controller
{
    public function index(): void
    {
        $this->render('topics/index', [
            'title' => 'Topic Builder',
            'topics' => (new TopicModel())->listDetailed(),
        ]);
    }

    public function create(): void
    {
        $model = new TopicModel();
        $this->render('topics/form', [
            'title' => 'Create Topic',
            'topic' => null,
            'chapters' => (new ChapterModel())->options(),
            'parents' => $model->options(),
        ]);
    }

    public function store(): void
    {
        $this->requirePost();
        remember_old($_POST);

        $errors = $this->requireFields([
            'chapter_id' => 'Chapter',
            'title' => 'Topic title',
        ]);

        if ($errors) {
            flash('message', ['text' => implode(' ', $errors), 'level' => 'danger']);
            redirect_to('/topics/create');
        }

        (new TopicModel())->create($this->payload());
        clear_old();

        $this->redirect('/topics', 'Topic created successfully.');
    }

    public function edit(int $id): void
    {
        $model = new TopicModel();
        $topic = $model->find($id);
        if (! $topic) {
            $this->redirect('/topics', 'Topic not found.', 'danger');
        }

        $this->render('topics/form', [
            'title' => 'Edit Topic',
            'topic' => $topic,
            'chapters' => (new ChapterModel())->options(),
            'parents' => array_filter($model->options(), static fn (array $parent): bool => (int) $parent['id'] !== $id),
        ]);
    }

    public function update(int $id): void
    {
        $this->requirePost();
        remember_old($_POST);

        (new TopicModel())->update($id, $this->payload());
        clear_old();

        $this->redirect('/topics', 'Topic updated successfully.');
    }

    public function delete(int $id): void
    {
        $this->requirePost();
        (new TopicModel())->delete($id);
        $this->redirect('/topics', 'Topic deleted successfully.');
    }

    private function payload(): array
    {
        return [
            'chapter_id' => (int) $this->input('chapter_id'),
            'parent_id' => null_if_empty($this->input('parent_id')),
            'title' => $this->input('title'),
            'slug' => slugify((string) $this->input('title')),
            'learning_objectives' => $this->input('learning_objectives'),
            'difficulty' => $this->input('difficulty', 'Intermediate'),
            'revision_interval_days' => (int) $this->input('revision_interval_days', 7),
            'mastery_score' => $this->input('mastery_score', 0),
            'exam_relevance' => (int) $this->input('exam_relevance', 3),
            'next_revision_at' => null_if_empty($this->input('next_revision_at')),
            'dependency_map' => $this->input('dependency_map'),
        ];
    }
}
