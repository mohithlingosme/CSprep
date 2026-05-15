<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\CaseLawModel;
use App\Services\LookupService;
use App\Services\RelationService;
use App\Services\TagService;

final class CaseLawController extends Controller
{
    public function index(): void
    {
        $this->render('case-laws/index', [
            'title' => 'Case Law Engine',
            'caseLaws' => (new CaseLawModel())->listDetailed(),
        ]);
    }

    public function create(): void
    {
        $this->render('case-laws/form', [
            'title' => 'Create Case Law Entry',
            'caseLaw' => null,
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
            'case_name' => 'Case name',
            'citation' => 'Citation',
        ]);

        if ($errors) {
            flash('message', ['text' => implode(' ', $errors), 'level' => 'danger']);
            redirect_to('/case-laws/create');
        }

        $model = new CaseLawModel();
        $id = $model->create($this->payload());

        (new TagService())->sync('case_law', $id, (string) $this->input('tag_string'));
        (new RelationService())->syncFromLines('case_law', $id, (string) $this->input('relation_lines'));

        clear_old();
        $this->redirect('/case-laws', 'Case law entry created successfully.');
    }

    public function edit(int $id): void
    {
        $caseLaw = (new CaseLawModel())->find($id);
        if (! $caseLaw) {
            $this->redirect('/case-laws', 'Case law entry not found.', 'danger');
        }

        $this->render('case-laws/form', [
            'title' => 'Edit Case Law Entry',
            'caseLaw' => $caseLaw,
            'lookup' => (new LookupService())->all(),
            'tagString' => (new TagService())->getTagString('case_law', $id),
            'relationLines' => (new RelationService())->getLines('case_law', $id),
        ]);
    }

    public function update(int $id): void
    {
        $this->requirePost();
        remember_old($_POST);

        (new CaseLawModel())->update($id, $this->payload());
        (new TagService())->sync('case_law', $id, (string) $this->input('tag_string'));
        (new RelationService())->syncFromLines('case_law', $id, (string) $this->input('relation_lines'));

        clear_old();
        $this->redirect('/case-laws', 'Case law entry updated successfully.');
    }

    public function delete(int $id): void
    {
        $this->requirePost();
        (new CaseLawModel())->delete($id);
        $this->redirect('/case-laws', 'Case law entry deleted successfully.');
    }

    private function payload(): array
    {
        return [
            'subject_id' => (int) $this->input('subject_id'),
            'topic_id' => null_if_empty($this->input('topic_id')),
            'legal_provision_id' => null_if_empty($this->input('legal_provision_id')),
            'case_name' => $this->input('case_name'),
            'citation' => $this->input('citation'),
            'court_name' => $this->input('court_name'),
            'court_level' => $this->input('court_level'),
            'case_year' => null_if_empty($this->input('case_year')),
            'facts' => $this->input('facts'),
            'issues' => $this->input('issues'),
            'held_text' => $this->input('held_text'),
            'legal_principles' => $this->input('legal_principles'),
            'exam_relevance' => (int) $this->input('exam_relevance', 3),
            'linked_sections' => $this->input('linked_sections'),
        ];
    }
}
