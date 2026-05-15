<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\KnowledgeEntryModel;
use App\Services\LookupService;
use App\Services\RelationService;
use App\Services\TagService;

final class KnowledgeController extends Controller
{
    public function index(): void
    {
        $this->render('knowledge/index', [
            'title' => 'Knowledge Injection Hub',
            'entries' => (new KnowledgeEntryModel())->listDetailed(),
        ]);
    }

    public function create(): void
    {
        $this->render('knowledge/form', [
            'title' => 'Create Knowledge Entry',
            'entry' => null,
            'lookup' => (new LookupService())->all(),
            'tagString' => '',
            'relationLines' => '',
        ]);
    }

    public function store(): void
    {
        $this->requirePost();
        remember_old($_POST);

        $errors = $this->requireFields([
            'subject_id' => 'Subject',
            'chapter_id' => 'Chapter',
            'topic_id' => 'Topic',
            'title' => 'Title',
            'entry_type' => 'Entry type',
        ]);

        if ($errors) {
            flash('message', ['text' => implode(' ', $errors), 'level' => 'danger']);
            redirect_to('/knowledge/create');
        }

        $model = new KnowledgeEntryModel();
        $id = $model->create($this->payload(true));

        (new TagService())->sync('knowledge_entry', $id, (string) $this->input('tag_string'));
        (new RelationService())->syncFromLines('knowledge_entry', $id, (string) $this->input('relation_lines'));

        clear_old();
        $this->redirect('/knowledge', 'Knowledge entry created successfully.');
    }

    public function edit(int $id): void
    {
        $entry = (new KnowledgeEntryModel())->find($id);
        if (! $entry) {
            $this->redirect('/knowledge', 'Knowledge entry not found.', 'danger');
        }

        $tags = new TagService();
        $relations = new RelationService();

        $this->render('knowledge/form', [
            'title' => 'Edit Knowledge Entry',
            'entry' => $entry,
            'lookup' => (new LookupService())->all(),
            'tagString' => $tags->getTagString('knowledge_entry', $id),
            'relationLines' => $relations->getLines('knowledge_entry', $id),
        ]);
    }

    public function update(int $id): void
    {
        $this->requirePost();
        remember_old($_POST);

        $model = new KnowledgeEntryModel();
        $model->update($id, $this->payload());

        (new TagService())->sync('knowledge_entry', $id, (string) $this->input('tag_string'));
        (new RelationService())->syncFromLines('knowledge_entry', $id, (string) $this->input('relation_lines'));

        clear_old();
        $this->redirect('/knowledge', 'Knowledge entry updated successfully.');
    }

    public function delete(int $id): void
    {
        $this->requirePost();
        (new KnowledgeEntryModel())->delete($id);
        $this->redirect('/knowledge', 'Knowledge entry deleted successfully.');
    }

    private function payload(bool $forCreate = false): array
    {
        $payload = [
            'subject_id' => (int) $this->input('subject_id'),
            'chapter_id' => (int) $this->input('chapter_id'),
            'topic_id' => (int) $this->input('topic_id'),
            'legal_provision_id' => null_if_empty($this->input('legal_provision_id')),
            'source_document_id' => null_if_empty($this->input('source_document_id')),
            'entry_type' => $this->input('entry_type', 'Note'),
            'title' => $this->input('title'),
            'summary' => $this->input('summary'),
            'content_html' => $this->input('content_html'),
            'key_takeaways' => $this->input('key_takeaways'),
            'exam_relevance' => (int) $this->input('exam_relevance', 3),
            'difficulty' => $this->input('difficulty', 'Intermediate'),
            'ai_ready' => (int) $this->input('ai_ready', 0),
            'ai_label' => $this->input('ai_label'),
            'revision_tags' => $this->input('revision_tags'),
            'compliance_map' => $this->input('compliance_map'),
            'citation_reference' => $this->input('citation_reference'),
            'status' => $this->input('status', 'Draft'),
        ];

        if ($forCreate) {
            $payload['version_no'] = 1;
            $payload['created_by'] = (int) (current_user()['id'] ?? 1);
        }

        return $payload;
    }
}
