<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\LegalProvisionModel;
use App\Services\LookupService;

final class LegalProvisionController extends Controller
{
    public function index(): void
    {
        $this->render('legal-provisions/index', [
            'title' => 'Legal Content Engine',
            'provisions' => (new LegalProvisionModel())->listDetailed(),
        ]);
    }

    public function create(): void
    {
        $this->render('legal-provisions/form', [
            'title' => 'Create Legal Provision',
            'provision' => null,
            'lookup' => (new LookupService())->all(),
        ]);
    }

    public function store(): void
    {
        $this->requirePost();
        remember_old($_POST);

        $errors = $this->requireFields([
            'subject_id' => 'Subject',
            'reference_code' => 'Reference code',
            'title' => 'Title',
        ]);

        if ($errors) {
            flash('message', ['text' => implode(' ', $errors), 'level' => 'danger']);
            redirect_to('/legal-provisions/create');
        }

        (new LegalProvisionModel())->create($this->payload());
        clear_old();

        $this->redirect('/legal-provisions', 'Legal provision created successfully.');
    }

    public function edit(int $id): void
    {
        $provision = (new LegalProvisionModel())->find($id);
        if (! $provision) {
            $this->redirect('/legal-provisions', 'Legal provision not found.', 'danger');
        }

        $this->render('legal-provisions/form', [
            'title' => 'Edit Legal Provision',
            'provision' => $provision,
            'lookup' => (new LookupService())->all(),
        ]);
    }

    public function update(int $id): void
    {
        $this->requirePost();
        remember_old($_POST);

        (new LegalProvisionModel())->update($id, $this->payload());
        clear_old();

        $this->redirect('/legal-provisions', 'Legal provision updated successfully.');
    }

    public function delete(int $id): void
    {
        $this->requirePost();
        (new LegalProvisionModel())->delete($id);
        $this->redirect('/legal-provisions', 'Legal provision deleted successfully.');
    }

    private function payload(): array
    {
        return [
            'subject_id' => (int) $this->input('subject_id'),
            'topic_id' => null_if_empty($this->input('topic_id')),
            'framework_type' => $this->input('framework_type', 'Section'),
            'reference_code' => $this->input('reference_code'),
            'title' => $this->input('title'),
            'act_name' => $this->input('act_name'),
            'bare_text' => $this->input('bare_text'),
            'simplified_text' => $this->input('simplified_text'),
            'compliance_checklist' => $this->input('compliance_checklist'),
            'drafting_notes' => $this->input('drafting_notes'),
            'penalties' => $this->input('penalties'),
            'forms_involved' => $this->input('forms_involved'),
            'effective_date' => null_if_empty($this->input('effective_date')),
            'amendment_notes' => $this->input('amendment_notes'),
            'ai_labels' => $this->input('ai_labels'),
            'status' => $this->input('status', 'Published'),
        ];
    }
}
