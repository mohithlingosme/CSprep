<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\CaseLawController;
use App\Controllers\ChapterController;
use App\Controllers\ComplianceController;
use App\Controllers\DashboardController;
use App\Controllers\ExportController;
use App\Controllers\ImportController;
use App\Controllers\KnowledgeController;
use App\Controllers\LegalProvisionController;
use App\Controllers\SourceDocumentController;
use App\Controllers\StudyItemController;
use App\Controllers\SubjectController;
use App\Controllers\TopicController;
use App\Core\App;
use App\Core\Database;

session_start();

spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';
    if (! str_starts_with($class, $prefix)) {
        return;
    }

    $relativePath = str_replace('\\', '/', substr($class, strlen($prefix)));
    $file = __DIR__ . '/' . $relativePath . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

require __DIR__ . '/Support/helpers.php';

$config = require __DIR__ . '/Config/config.php';
Database::init($config['db']);

$app = new App($config);

$app->get('/', [DashboardController::class, 'index']);
$app->get('/dashboard', [DashboardController::class, 'index']);

$app->get('/login', [AuthController::class, 'login'], false);
$app->post('/login', [AuthController::class, 'authenticate'], false);
$app->post('/logout', [AuthController::class, 'logout']);

$app->get('/subjects', [SubjectController::class, 'index']);
$app->get('/subjects/create', [SubjectController::class, 'create']);
$app->post('/subjects/store', [SubjectController::class, 'store']);
$app->get('/subjects/edit/{id}', [SubjectController::class, 'edit']);
$app->post('/subjects/update/{id}', [SubjectController::class, 'update']);
$app->post('/subjects/delete/{id}', [SubjectController::class, 'delete']);

$app->get('/chapters', [ChapterController::class, 'index']);
$app->get('/chapters/create', [ChapterController::class, 'create']);
$app->post('/chapters/store', [ChapterController::class, 'store']);
$app->get('/chapters/edit/{id}', [ChapterController::class, 'edit']);
$app->post('/chapters/update/{id}', [ChapterController::class, 'update']);
$app->post('/chapters/delete/{id}', [ChapterController::class, 'delete']);

$app->get('/topics', [TopicController::class, 'index']);
$app->get('/topics/create', [TopicController::class, 'create']);
$app->post('/topics/store', [TopicController::class, 'store']);
$app->get('/topics/edit/{id}', [TopicController::class, 'edit']);
$app->post('/topics/update/{id}', [TopicController::class, 'update']);
$app->post('/topics/delete/{id}', [TopicController::class, 'delete']);

$app->get('/legal-provisions', [LegalProvisionController::class, 'index']);
$app->get('/legal-provisions/create', [LegalProvisionController::class, 'create']);
$app->post('/legal-provisions/store', [LegalProvisionController::class, 'store']);
$app->get('/legal-provisions/edit/{id}', [LegalProvisionController::class, 'edit']);
$app->post('/legal-provisions/update/{id}', [LegalProvisionController::class, 'update']);
$app->post('/legal-provisions/delete/{id}', [LegalProvisionController::class, 'delete']);

$app->get('/knowledge', [KnowledgeController::class, 'index']);
$app->get('/knowledge/create', [KnowledgeController::class, 'create']);
$app->post('/knowledge/store', [KnowledgeController::class, 'store']);
$app->get('/knowledge/edit/{id}', [KnowledgeController::class, 'edit']);
$app->post('/knowledge/update/{id}', [KnowledgeController::class, 'update']);
$app->post('/knowledge/delete/{id}', [KnowledgeController::class, 'delete']);

$app->get('/case-laws', [CaseLawController::class, 'index']);
$app->get('/case-laws/create', [CaseLawController::class, 'create']);
$app->post('/case-laws/store', [CaseLawController::class, 'store']);
$app->get('/case-laws/edit/{id}', [CaseLawController::class, 'edit']);
$app->post('/case-laws/update/{id}', [CaseLawController::class, 'update']);
$app->post('/case-laws/delete/{id}', [CaseLawController::class, 'delete']);

$app->get('/study-items', [StudyItemController::class, 'index']);
$app->get('/study-items/create', [StudyItemController::class, 'create']);
$app->post('/study-items/store', [StudyItemController::class, 'store']);
$app->get('/study-items/edit/{id}', [StudyItemController::class, 'edit']);
$app->post('/study-items/update/{id}', [StudyItemController::class, 'update']);
$app->post('/study-items/delete/{id}', [StudyItemController::class, 'delete']);

$app->get('/compliance', [ComplianceController::class, 'index']);
$app->get('/compliance/create', [ComplianceController::class, 'create']);
$app->post('/compliance/store', [ComplianceController::class, 'store']);
$app->get('/compliance/edit/{id}', [ComplianceController::class, 'edit']);
$app->post('/compliance/update/{id}', [ComplianceController::class, 'update']);
$app->post('/compliance/delete/{id}', [ComplianceController::class, 'delete']);

$app->get('/source-documents', [SourceDocumentController::class, 'index']);
$app->get('/source-documents/create', [SourceDocumentController::class, 'create']);
$app->post('/source-documents/store', [SourceDocumentController::class, 'store']);
$app->get('/source-documents/edit/{id}', [SourceDocumentController::class, 'edit']);
$app->post('/source-documents/update/{id}', [SourceDocumentController::class, 'update']);
$app->post('/source-documents/delete/{id}', [SourceDocumentController::class, 'delete']);

$app->get('/imports', [ImportController::class, 'index']);
$app->post('/imports/upload', [ImportController::class, 'upload']);

// Bulk Chapters & Topics ingestion from structured textarea input.
use App\Controllers\BulkChaptersTopicsController;
$app->get('/imports/bulk-chapters-topics', [BulkChaptersTopicsController::class, 'index']);
$app->post('/imports/bulk-chapters-topics', [BulkChaptersTopicsController::class, 'handle']);


$app->get('/exports', [ExportController::class, 'index']);
$app->get('/exports/download', [ExportController::class, 'download']);

return $app;
