<?php

return [
    'law' => [
        'label' => 'Law Provisions',
        'table' => 'law_provisions',
        'domain' => 'Law',
        'title_field' => 'section_number',
        'subtitle_fields' => ['statute_name', 'chapter'],
        'summary_field' => 'statutory_text',
    ],
    'business' => [
        'label' => 'Biz Frameworks',
        'table' => 'business_frameworks',
        'domain' => 'Business',
        'title_field' => 'concept_framework_name',
        'subtitle_fields' => ['subject_domain', 'originator_theorist'],
        'summary_field' => 'definition',
    ],
    'cafm' => [
        'label' => 'CAFM Repository',
        'table' => 'cafm_repository',
        'domain' => 'CMA',
        'title_field' => 'chapter_name',
        'subtitle_fields' => ['module', 'applicable_standard'],
        'summary_field' => 'concept_definition',
    ],
    'stats' => [
        'label' => 'Statistics',
        'table' => 'statistics_concepts',
        'domain' => 'Statistics',
        'title_field' => 'concept_name',
        'subtitle_fields' => ['syllabus_unit', 'statistical_category'],
        'summary_field' => 'definition',
    ],
];
