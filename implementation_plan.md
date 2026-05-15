# Implementation Plan

[Overview]
Improve clarity, maintainability, and performance by refactoring high-leverage parts of the existing PHP MVC codebase (controllers/services/views/helpers/core) while preserving current behavior and routes.

This codebase is a lightweight custom MVC (front controller in `index.php`, router in `app/bootstrap.php`, controllers render plain PHP views, and services encapsulate import/export logic). Maintainability risks are mostly around: duplicated logic, weak validation/error handling consistency, hidden coupling (globals/helpers), and performance inefficiencies in “bulk ingestion” flows.

The immediate focus is on the bulk import feature (`BulkChaptersTopicsController` + `BulkSyllabusService` + its view) because it contains parsing logic, DB deduplication, and multiple loops that can be made more robust and faster with better normalization, transaction usage, caching, and clearer data structures. Secondary focus will be on foundational helpers and MVC core to standardize rendering, input access, and error handling.

[Types]  
No language-level “type system” changes; instead introduce structured internal DTO-like arrays with documented keys (and optionally PHP 8.1+ enums/value objects if needed), plus stricter parameter/return types in modified methods.

Internal array shapes (documented via phpdoc in-code):
- `BulkSyllabusParsedChapter`:
  - `title: string`
  - `topics: string[]` (deduped by normalized key; preserves original first-seen display text)
- `BulkSyllabusPreview`:
  - `subject_id: int`
  - `chapters: array<['chapter_title'=>string,'topics'=>array<['title'=>string]>]>`
  - `chapters_count: int`
  - `topics_count: int`

Validation rules:
- `subject_id` must be > 0
- `bulk_text` must be non-empty after trimming

[Files]
Modify targeted existing files to improve structure and performance; add one markdown plan artifact for tracking.

New files to be created:
- `implementation_plan.md`: this plan.

Existing files to be modified:
- `app/Services/BulkSyllabusService.php`
  - Refactor parsing robustness and performance.
  - Reuse parsing logic for preview/import.
  - Add transaction boundaries around bulk inserts.
  - Reduce repeated normalization and unnecessary DB roundtrips.
- `app/Controllers/BulkChaptersTopicsController.php`
  - Validate POST payload and action value.
  - Make preview/import flow deterministic and handle invalid actions.
  - Handle exceptions consistently.
- `app/Views/imports/bulk-chapters-topics.php`
  - Remove unused variables and improve messaging for empty/invalid input.
- `app/Core/Controller.php`
  - Minor maintainability improvements to rendering safety and clarity (non-breaking).
- `app/Support/helpers.php`
  - Only non-breaking tweaks if needed for clarity/robustness.

Files to delete or moved:
- None.

Configuration file updates:
- None.

[Functions]
Refactor parsing/import/preview functions and make controller/view behavior deterministic with improved validation and performance.

Detailed breakdown:

1) `BulkSyllabusService::parse(string $input): array`
- Remove reference rebinding complexity.
- Make grammar deterministic:
  - `Chapter:` starts a new chapter.
  - Topic lines are `- ...` or plain non-empty lines after a chapter.
- Dedup topics while preserving first-seen display.

2) `BulkSyllabusService::preview(int $subjectId, string $input): array`
- Validate early.
- Use `parse()` output to compute preview and counts in one pass.

3) `BulkSyllabusService::import(int $subjectId, string $input, int $createdBy = 1): array`
- Validate early.
- Add DB transaction boundary around all inserts.
- Reuse `parse()` output.
- Optimize dedup with precomputed normalized keys.
- Avoid unnecessary topic reload for newly inserted chapters.
- Log import summary via `ImportLogModel`.

4) `BulkChaptersTopicsController::handle(): void`
- Validate `action` strictly; unknown values re-render preview with error.
- Catch service exceptions and flash a user-friendly message.

5) `app/Views/imports/bulk-chapters-topics.php`
- Remove unused `$parsedInfo` fallback.
- Display a clear message when preview has 0 chapters.

[Classes]
Refactor existing classes for clarity and performance; no new public classes required.

Modified classes:
- `App\Services\BulkSyllabusService`
- `App\Controllers\BulkChaptersTopicsController`
- `App\Core\Controller` (minor non-breaking)

Removed classes:
- None.

[Dependencies]
No dependency changes required.

[Testing]
Manual verification with the UI and DB inspection.

Test scenarios:
- Preview parsing:
  - Multiple chapters + mixed topic formatting.
  - Duplicate topics differing by whitespace/case.
  - Input with no `Chapter:`.
- Import idempotency:
  - Import same input twice -> second run skips duplicates.
- Empty input:
  - Confirm chosen behavior (preview shows message; import throws or logs zeros—implemented as per functions section).

[Implementation Order]
1) Create `implementation_plan.md`.
2) Refactor `BulkSyllabusService::parse()` and update `preview()` to depend on it.
3) Refactor `BulkSyllabusService::import()` with transaction + caching/normalization optimizations.
4) Update `BulkChaptersTopicsController::handle()` validation/error flow.
5) Update the bulk import view to remove unused variables and improve empty/invalid messaging.
6) Apply minor non-breaking improvements in `app/Core/Controller.php` if identified issues require it.
7) Manual test `/imports/bulk-chapters-topics` preview/import paths and confirm DB + import logs.

