<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ChapterModel;
use App\Models\ImportLogModel;
use App\Models\SubjectModel;
use App\Models\TopicModel;
use RuntimeException;
use Throwable;

final class BulkSyllabusService
{

    public function preview(int $subjectId, string $input): array
    {
        if ($subjectId <= 0) {
            return [
                'subject_id' => $subjectId,
                'chapters' => [],
                'chapters_count' => 0,
                'topics_count' => 0,
            ];
        }

        $input = trim($input);
        if ($input === '') {
            return [
                'subject_id' => $subjectId,
                'chapters' => [],
                'chapters_count' => 0,
                'topics_count' => 0,
            ];
        }

        $parsed = $this->parse($input);

        $preview = [];
        $topicsCount = 0;
        foreach ($parsed as $chapter) {
            $topicsCount += count($chapter['topics']);
            $preview[] = [
                'chapter_title' => $chapter['title'],
                'topics' => array_map(static fn (string $t) => ['title' => $t], $chapter['topics']),
            ];
        }

        return [
            'subject_id' => $subjectId,
            'chapters' => $preview,
            'chapters_count' => count($preview),
            'topics_count' => $topicsCount,
        ];
    }






    public function import(int $subjectId, string $input, int $createdBy = 1): array
    {



        if ($subjectId <= 0) {
            throw new RuntimeException('Invalid subject selection.');
        }

        $subject = (new SubjectModel())->find($subjectId);
        if (! $subject) {
            throw new RuntimeException('Subject not found.');
        }

        $parsed = $this->parse($input);

        $insertedChapters = 0;
        $insertedTopics = 0;
        $skippedChapters = 0;
        $skippedTopics = 0;

        $existingChapters = $this->existingChaptersByTitle($subjectId);

        $chapterModel = new ChapterModel();
        $topicModel = new TopicModel();

        // Preload existing topics per chapter to avoid N+1.
        $existingTopicsByChapter = [];
        foreach (array_values($existingChapters) as $existingChapterId) {
            $existingTopicsByChapter[(int) $existingChapterId] = $this->existingTopicsByTitle((int) $existingChapterId);
        }

        foreach ($parsed as $chapterBlock) {
            $chapterTitleKey = $this->normalizeTitle($chapterBlock['title']);
            $chapterId = $existingChapters[$chapterTitleKey] ?? null;

            if (! $chapterId) {
                $chapterId = $chapterModel->create([
                    'subject_id' => $subjectId,
                    'code' => null,
                    'title' => $chapterBlock['title'],
                    'weightage' => null,
                    'study_order' => 0,
                    'dependency_notes' => null,
                    'summary' => null,
                ]);

                $existingChapters[$chapterTitleKey] = (int) $chapterId;
                $existingTopicsByChapter[(int) $chapterId] = $this->existingTopicsByTitle((int) $chapterId);
                $insertedChapters++;
            } else {
                $skippedChapters++;
            }

            foreach ($chapterBlock['topics'] as $topicTitleRaw) {
                $topicTitleKey = $this->normalizeTitle($topicTitleRaw);

                $existingTopics = $existingTopicsByChapter[(int) $chapterId] ?? [];
                $topicId = $existingTopics[$topicTitleKey] ?? null;

                if (! $topicId) {
                    $topicModel->create([
                        'chapter_id' => (int) $chapterId,
                        'parent_id' => null,
                        'title' => $topicTitleRaw,
                        'slug' => slugify($topicTitleRaw),
                        'learning_objectives' => null,
                        'difficulty' => 'Intermediate',
                        'revision_interval_days' => 7,
                        'mastery_score' => 0,
                        'exam_relevance' => 3,
                        'next_revision_at' => null,
                        'dependency_map' => null,
                    ]);

                    // Update cache so duplicates inside same run are skipped.
                    $existingTopicsByChapter[(int) $chapterId][$topicTitleKey] = 1;
                    $insertedTopics++;
                } else {
                    $skippedTopics++;
                }
            }
        }

        (new ImportLogModel())->create([
            'module_name' => 'bulk_chapters_topics',
            'file_name' => 'textarea-input',
            'records_imported' => $insertedChapters + $insertedTopics,
            'status' => 'Completed',
            'notes' => sprintf(
                'Bulk ingestion: chapters=%d (skipped=%d), topics=%d (skipped=%d).',
                $insertedChapters,
                $skippedChapters,
                $insertedTopics,
                $skippedTopics
            ),
        ]);


        return [
            'inserted' => [
                'chapters' => $insertedChapters,
                'topics' => $insertedTopics,
            ],
            'skipped' => [
                'chapters' => $skippedChapters,
                'topics' => $skippedTopics,
            ],
            'parsed' => [
                'chapters' => count($parsed),
            ],
        ];
    }

    private function parse(string $input): array
    {
        $lines = preg_split('/\r\n|\n|\r/', $input);
        if (! is_array($lines)) {
            return [];
        }

        $result = [];
        $currentChapter = null;

        foreach ($lines as $rawLine) {
            $line = trim((string) $rawLine);
            if ($line === '') {
                continue;
            }

            if (preg_match('/^Chapter:\s*(.+)$/i', $line, $m)) {
                $title = trim($m[1]);
                if ($title === '') {
                    continue;
                }

                // Start a new chapter block.
                $currentChapter = [
                    'title' => $title,
                    'topics' => [],
                ];
                $result[] = $currentChapter;

                // Keep writing into the last chapter without reference re-binding complexity.
                $currentChapterIndex = array_key_last($result);
                $currentChapter = &$result[$currentChapterIndex];
                continue;
            }

            // Topic lines: require '-' OR allow plain topic lines inside a chapter.
            if ($currentChapter !== null) {
                if (str_starts_with($line, '-')) {
                    $topicTitle = trim(ltrim(substr($line, 1)));
                } else {
                    $topicTitle = trim($line);
                }

                if ($topicTitle !== '') {
                    $currentChapter['topics'][] = $topicTitle;
                }
            }
        }

        // Deduplicate topic titles inside each chapter.
        foreach ($result as &$chapter) {
            $seen = [];
            $unique = [];
            foreach ($chapter['topics'] as $t) {
                $key = $this->normalizeTitle($t);
                if (isset($seen[$key])) {
                    continue;
                }
                $seen[$key] = true;
                $unique[] = $t;
            }
            $chapter['topics'] = $unique;
        }

        return $result;
    }

    private function existingChaptersByTitle(int $subjectId): array
    {
        $db = \App\Core\Database::instance();
        $rows = $db->select(
            'SELECT id, title
             FROM chapters
             WHERE subject_id = :subject_id',
            ['subject_id' => $subjectId]
        );

        $map = [];
        foreach ($rows as $row) {
            $map[$this->normalizeTitle((string) $row['title'])] = (int) $row['id'];
        }

        return $map;
    }

    private function existingTopicsByTitle(int $chapterId): array
    {
        $db = \App\Core\Database::instance();
        $rows = $db->select(
            'SELECT id, title
             FROM topics
             WHERE chapter_id = :chapter_id',
            ['chapter_id' => $chapterId]
        );

        $map = [];
        foreach ($rows as $row) {
            $map[$this->normalizeTitle((string) $row['title'])] = (int) $row['id'];
        }

        return $map;
    }

    private function normalizeTitle(string $title): string
    {
        $t = mb_strtolower(trim($title));
        $t = preg_replace('/\s+/', ' ', (string) $t);
        return $t;
    }
}

