<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\ComplianceObligationModel;
use App\Services\LookupService;

final class ComplianceController extends Controller
{
    public function index(): void
    {
        $this->render('compliance/index', [
            'title' => 'Compliance System',
            'items' => (new ComplianceObligationModel())->listDetailed(),
        ]);
    }

    public function create(): void
    {
        $this->render('compliance/form', [
            'title' => 'Create Compliance Obligation',
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
            'title' => 'Title',
        ]);

        if ($errors) {
            flash('message', ['text' => implode(' ', $errors), 'level' => 'danger']);
            redirect_to('/compliance/create');
        }

        (new ComplianceObligationModel())->create($this->payload());
        clear_old();

        $this->redirect('/compliance', 'Compliance obligation created successfully.');
    }

    public function edit(int $id): void
    {
        $item = (new ComplianceObligationModel())->find($id);
        if (! $item) {
            $this->redirect('/compliance', 'Compliance obligation not found.', 'danger');
        }

        $this->render('compliance/form', [
            'title' => 'Edit Compliance Obligation',
            'item' => $item,
            'lookup' => (new LookupService())->all(),
        ]);
    }

    public function update(int $id): void
    {
        $this->requirePost();
        remember_old($_POST);

        (new ComplianceObligationModel())->update($id, $this->payload());
        clear_old();

        $this->redirect('/compliance', 'Compliance obligation updated successfully.');
    }

    public function delete(int $id): void
    {
        $this->requirePost();
        (new ComplianceObligationModel())->delete($id);
        $this->redirect('/compliance', 'Compliance obligation deleted successfully.');
    }

    private function payload(): array
    {
        return [
            'subject_id' => (int) $this->input('subject_id'),
            'topic_id' => null_if_empty($this->input('topic_id')),
            'provision_id' => null_if_empty($this->input('provision_id')),
            'title' => $this->input('title'),
            'entity_type' => $this->input('entity_type'),
            'frequency' => $this->input('frequency'),
            'due_date' => null_if_empty($this->input('due_date')),
            'form_name' => $this->input('form_name'),
            'regulator' => $this->input('regulator'),
            'priority' => $this->input('priority', 'Medium'),
            'status' => $this->input('status', 'Planned'),
            'description' => $this->input('description'),
            'checklist' => $this->input('checklist'),
            'penalty_risk' => $this->input('penalty_risk'),
            'owner_name' => $this->input('owner_name'),
        ];
    }
}
