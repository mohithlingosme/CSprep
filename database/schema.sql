-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2026 at 06:10 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `corporate_law_erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `case_laws`
--

CREATE TABLE `case_laws` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject_id` int(10) UNSIGNED NOT NULL,
  `topic_id` int(10) UNSIGNED DEFAULT NULL,
  `legal_provision_id` int(10) UNSIGNED DEFAULT NULL,
  `case_name` varchar(255) NOT NULL,
  `citation` varchar(255) NOT NULL,
  `court_name` varchar(190) DEFAULT NULL,
  `court_level` varchar(80) DEFAULT NULL,
  `case_year` year(4) DEFAULT NULL,
  `facts` longtext DEFAULT NULL,
  `issues` longtext DEFAULT NULL,
  `held_text` longtext DEFAULT NULL,
  `legal_principles` longtext DEFAULT NULL,
  `exam_relevance` tinyint(4) NOT NULL DEFAULT 3,
  `linked_sections` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE `chapters` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `title` varchar(190) NOT NULL,
  `weightage` varchar(50) DEFAULT NULL,
  `study_order` int(11) NOT NULL DEFAULT 0,
  `dependency_notes` text DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chapters`
--

INSERT INTO `chapters` (`id`, `subject_id`, `code`, `title`, `weightage`, `study_order`, `dependency_notes`, `summary`, `created_at`, `updated_at`) VALUES
(1, 1, '1', 'Source of law', '', 0, '', '', '2026-05-01 17:37:18', '2026-05-01 17:37:18');

-- --------------------------------------------------------

--
-- Table structure for table `compliance_obligations`
--

CREATE TABLE `compliance_obligations` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject_id` int(10) UNSIGNED NOT NULL,
  `topic_id` int(10) UNSIGNED DEFAULT NULL,
  `provision_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `entity_type` varchar(120) DEFAULT NULL,
  `frequency` varchar(80) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `form_name` varchar(120) DEFAULT NULL,
  `regulator` varchar(120) DEFAULT NULL,
  `priority` varchar(40) NOT NULL DEFAULT 'Medium',
  `status` varchar(40) NOT NULL DEFAULT 'Planned',
  `description` longtext DEFAULT NULL,
  `checklist` longtext DEFAULT NULL,
  `penalty_risk` longtext DEFAULT NULL,
  `owner_name` varchar(120) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `content_versions`
--

CREATE TABLE `content_versions` (
  `id` int(10) UNSIGNED NOT NULL,
  `entity_type` varchar(80) NOT NULL,
  `entity_id` int(10) UNSIGNED NOT NULL,
  `version_no` int(11) NOT NULL,
  `snapshot_json` longtext NOT NULL,
  `changed_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entity_tags`
--

CREATE TABLE `entity_tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL,
  `entity_type` varchar(80) NOT NULL,
  `entity_id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `imports`
--

CREATE TABLE `imports` (
  `id` int(10) UNSIGNED NOT NULL,
  `module_name` varchar(120) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `records_imported` int(11) NOT NULL DEFAULT 0,
  `status` varchar(40) NOT NULL DEFAULT 'Completed',
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `knowledge_entries`
--

CREATE TABLE `knowledge_entries` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject_id` int(10) UNSIGNED NOT NULL,
  `chapter_id` int(10) UNSIGNED NOT NULL,
  `topic_id` int(10) UNSIGNED NOT NULL,
  `legal_provision_id` int(10) UNSIGNED DEFAULT NULL,
  `source_document_id` int(10) UNSIGNED DEFAULT NULL,
  `entry_type` varchar(80) NOT NULL DEFAULT 'Note',
  `title` varchar(255) NOT NULL,
  `summary` text DEFAULT NULL,
  `content_html` longtext DEFAULT NULL,
  `key_takeaways` longtext DEFAULT NULL,
  `exam_relevance` tinyint(4) NOT NULL DEFAULT 3,
  `difficulty` varchar(40) NOT NULL DEFAULT 'Intermediate',
  `ai_ready` tinyint(1) NOT NULL DEFAULT 0,
  `ai_label` varchar(190) DEFAULT NULL,
  `revision_tags` varchar(255) DEFAULT NULL,
  `compliance_map` longtext DEFAULT NULL,
  `citation_reference` varchar(255) DEFAULT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'Draft',
  `version_no` int(11) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `knowledge_entries`
--

INSERT INTO `knowledge_entries` (`id`, `subject_id`, `chapter_id`, `topic_id`, `legal_provision_id`, `source_document_id`, `entry_type`, `title`, `summary`, `content_html`, `key_takeaways`, `exam_relevance`, `difficulty`, `ai_ready`, `ai_label`, `revision_tags`, `compliance_map`, `citation_reference`, `status`, `version_no`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, NULL, NULL, 'Note', 'Meaning, significance, relevance of law', '', 'law refers to the whole process or legal system which is aplied by the government personnel and bodies in society so as to establish and maintain peaceful and orderly relation between people&nbsp;<br>under consitution of india&nbsp;<br>law includes any of ordiance, order, bye-law, rule, regulation, notification, custom or usage having in force in the territory of india the force of law&nbsp;<br><b>law in force - </b>Means the law made or passed by legislature (basically an codifed law / Act) which is not repealed and which is operation in a particular area or whole of india&nbsp;<br><h3><b>Significance of law&nbsp;</b></h3><ul style=\"\"><li style=\"\">law is combination of Statute, judicial decision, customs and convention, by understanding the source of law we can gain insight regarding that characteristics of law&nbsp;</li><li style=\"\">Law is evolving in nature&nbsp;</li><li style=\"\">the shift from abstract justice (focusing on equal treatment before law regardless of circumstances) to social justice (focusing on the equitable distribution of resources and oppirtunies especaily historically marginalized groups)<br></li></ul><h3>relevance of law</h3><div><ul><li>maintainging social order and safety&nbsp;</li><li>protection of right and freedoms&nbsp;</li><li>conflict resolution&nbsp;</li><li>establishing accountability&nbsp;</li><li>facilitating social changes&nbsp;</li><li>economic stability and development</li></ul></div><div><br></div>', '', 3, 'Intermediate', 0, '', '', '', '', 'Draft', 1, 1, '2026-05-01 18:08:07', '2026-05-01 18:08:07');

-- --------------------------------------------------------

--
-- Table structure for table `knowledge_relations`
--

CREATE TABLE `knowledge_relations` (
  `id` int(10) UNSIGNED NOT NULL,
  `source_type` varchar(80) NOT NULL,
  `source_id` int(10) UNSIGNED NOT NULL,
  `relation_type` varchar(80) NOT NULL,
  `target_type` varchar(80) NOT NULL,
  `target_id` int(10) UNSIGNED NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legal_provisions`
--

CREATE TABLE `legal_provisions` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject_id` int(10) UNSIGNED NOT NULL,
  `topic_id` int(10) UNSIGNED DEFAULT NULL,
  `framework_type` varchar(80) NOT NULL DEFAULT 'Section',
  `reference_code` varchar(120) NOT NULL,
  `title` varchar(255) NOT NULL,
  `act_name` varchar(190) DEFAULT NULL,
  `bare_text` longtext DEFAULT NULL,
  `simplified_text` longtext DEFAULT NULL,
  `compliance_checklist` longtext DEFAULT NULL,
  `drafting_notes` longtext DEFAULT NULL,
  `penalties` longtext DEFAULT NULL,
  `forms_involved` text DEFAULT NULL,
  `effective_date` date DEFAULT NULL,
  `amendment_notes` longtext DEFAULT NULL,
  `ai_labels` varchar(255) DEFAULT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'Published',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `legal_provisions`
--

INSERT INTO `legal_provisions` (`id`, `subject_id`, `topic_id`, `framework_type`, `reference_code`, `title`, `act_name`, `bare_text`, `simplified_text`, `compliance_checklist`, `drafting_notes`, `penalties`, `forms_involved`, `effective_date`, `amendment_notes`, `ai_labels`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Section', 'art13', 'Article 13', 'Constitution of India', '13. Laws inconsistent with or in derogation of the fundamental rights.—(1) All laws in force in the\r\nterritory of India immediately before the commencement of this Constitution, in so far as they are\r\ninconsistent with the provisions of this Part, shall, to the extent of such inconsistency, be void.\r\n(2) The State shall not make any law which takes away or abridges the rights conferred by this Part and\r\nany law made in contravention of this clause shall, to the extent of the contravention, be void.\r\n(3) In this article, unless the context otherwise requires,—\r\n(a) ―law‖ includes any Ordinance, order, bye-law, rule, regulation, notification, custom or usage\r\nhaving in the territory of India the force of law;\r\n(b) ―laws in force‖ includes laws passed or made by a Legislature or other competent authority in the\r\nterritory of India before the commencement of this Constitution and not previously repealed,\r\nnotwithstanding that any such law or any part thereof may not be then in operation either at all or in\r\nparticular areas.', 'Article 13 of Indian constiution states all the a previous law commenced before the consitution in sofar as they are inconsisternt with the provision of this part shall to the exten of such inconcsitency, be void \r\nthe states are not allowed make laws which is the against the a right given under this section, if they make so it is void in nature \r\nlaw - means any orfianace, order, bye-law, rule, regulation, nofification, custom or usage having the territory of indian and enforced by la \r\nlaw in force is a law passed or made by legislature of other authories like the executive bodies and special individual bill and is enforced in the soverign of india', '', '', '', '', '1950-01-26', '', '', 'Published', '2026-05-01 17:57:03', '2026-05-01 17:57:03');

-- --------------------------------------------------------

--
-- Table structure for table `mock_attempts`
--

CREATE TABLE `mock_attempts` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject_id` int(10) UNSIGNED DEFAULT NULL,
  `topic_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `score` decimal(8,2) NOT NULL DEFAULT 0.00,
  `total_marks` decimal(8,2) NOT NULL DEFAULT 0.00,
  `attempted_on` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `revision_tasks`
--

CREATE TABLE `revision_tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `topic_id` int(10) UNSIGNED DEFAULT NULL,
  `knowledge_entry_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `task_date` date DEFAULT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'Planned',
  `priority` varchar(40) NOT NULL DEFAULT 'Medium',
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `source_documents`
--

CREATE TABLE `source_documents` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `document_type` varchar(80) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `mime_type` varchar(120) DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `extraction_status` varchar(40) NOT NULL DEFAULT 'Pending',
  `extracted_text` longtext DEFAULT NULL,
  `manual_notes` longtext DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `uploaded_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `study_items`
--

CREATE TABLE `study_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject_id` int(10) UNSIGNED NOT NULL,
  `topic_id` int(10) UNSIGNED DEFAULT NULL,
  `knowledge_entry_id` int(10) UNSIGNED DEFAULT NULL,
  `item_type` varchar(80) NOT NULL,
  `prompt` longtext NOT NULL,
  `option_a` text DEFAULT NULL,
  `option_b` text DEFAULT NULL,
  `option_c` text DEFAULT NULL,
  `option_d` text DEFAULT NULL,
  `correct_answer` text DEFAULT NULL,
  `explanation` longtext DEFAULT NULL,
  `marks` decimal(8,2) DEFAULT NULL,
  `difficulty` varchar(40) NOT NULL DEFAULT 'Intermediate',
  `exam_year` year(4) DEFAULT NULL,
  `revision_bucket` varchar(80) DEFAULT NULL,
  `ai_ready` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(190) NOT NULL,
  `slug` varchar(190) NOT NULL,
  `domain_type` varchar(120) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `syllabus_version` varchar(80) DEFAULT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'Active',
  `display_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `code`, `name`, `slug`, `domain_type`, `description`, `syllabus_version`, `status`, `display_order`, `created_at`, `updated_at`) VALUES
(1, '1', 'JIGL', 'jigl', 'CS Executive', '', '2026', 'Active', 0, '2026-05-01 17:35:29', '2026-05-01 17:35:29');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(10) UNSIGNED NOT NULL,
  `chapter_id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(190) NOT NULL,
  `slug` varchar(190) NOT NULL,
  `learning_objectives` text DEFAULT NULL,
  `difficulty` varchar(40) NOT NULL DEFAULT 'Intermediate',
  `revision_interval_days` int(11) NOT NULL DEFAULT 7,
  `mastery_score` decimal(5,2) NOT NULL DEFAULT 0.00,
  `exam_relevance` tinyint(4) NOT NULL DEFAULT 3,
  `next_revision_at` date DEFAULT NULL,
  `dependency_map` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `chapter_id`, `parent_id`, `title`, `slug`, `learning_objectives`, `difficulty`, `revision_interval_days`, `mastery_score`, `exam_relevance`, `next_revision_at`, `dependency_map`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Meaning of law and its signifiance', 'meaning-of-law-and-its-signifiance', '', 'Intermediate', 7, 0.00, 3, NULL, '', '2026-05-01 17:37:48', '2026-05-01 17:37:48'),
(2, 1, NULL, 'jurisprudence and legal theory', 'jurisprudence-and-legal-theory', '', 'Intermediate', 7, 0.00, 3, NULL, '', '2026-05-01 18:08:52', '2026-05-01 18:08:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(190) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` varchar(40) NOT NULL DEFAULT 'founder',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Founder Admin', 'founder@corporatelaw.local', '$2y$10$iZhzVh1YzoCvNLuCCV8vger9aaVQKyFnHA6dINKUHDUuJ7so1sm1C', 'founder', '2026-05-01 21:01:52', '2026-05-01 21:01:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `case_laws`
--
ALTER TABLE `case_laws`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cases_topic` (`topic_id`),
  ADD KEY `fk_cases_provision` (`legal_provision_id`),
  ADD KEY `idx_cases_subject` (`subject_id`),
  ADD KEY `idx_cases_year` (`case_year`);

--
-- Indexes for table `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_chapters_subject` (`subject_id`);

--
-- Indexes for table `compliance_obligations`
--
ALTER TABLE `compliance_obligations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_compliance_topic` (`topic_id`),
  ADD KEY `fk_compliance_provision` (`provision_id`),
  ADD KEY `idx_compliance_subject` (`subject_id`),
  ADD KEY `idx_compliance_due_date` (`due_date`),
  ADD KEY `idx_compliance_status` (`status`);

--
-- Indexes for table `content_versions`
--
ALTER TABLE `content_versions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_content_versions_lookup` (`entity_type`,`entity_id`,`version_no`);

--
-- Indexes for table `entity_tags`
--
ALTER TABLE `entity_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_entity_tags_tag` (`tag_id`),
  ADD KEY `idx_entity_tags_lookup` (`entity_type`,`entity_id`);

--
-- Indexes for table `imports`
--
ALTER TABLE `imports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `knowledge_entries`
--
ALTER TABLE `knowledge_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_knowledge_chapter` (`chapter_id`),
  ADD KEY `fk_knowledge_provision` (`legal_provision_id`),
  ADD KEY `fk_knowledge_document` (`source_document_id`),
  ADD KEY `fk_knowledge_creator` (`created_by`),
  ADD KEY `idx_knowledge_subject` (`subject_id`),
  ADD KEY `idx_knowledge_topic` (`topic_id`),
  ADD KEY `idx_knowledge_ai` (`ai_ready`),
  ADD KEY `idx_knowledge_status` (`status`);

--
-- Indexes for table `knowledge_relations`
--
ALTER TABLE `knowledge_relations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_knowledge_relations_source` (`source_type`,`source_id`),
  ADD KEY `idx_knowledge_relations_target` (`target_type`,`target_id`);

--
-- Indexes for table `legal_provisions`
--
ALTER TABLE `legal_provisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_provisions_topic` (`topic_id`),
  ADD KEY `idx_provisions_reference` (`reference_code`),
  ADD KEY `idx_provisions_subject` (`subject_id`),
  ADD KEY `idx_provisions_status` (`status`);

--
-- Indexes for table `mock_attempts`
--
ALTER TABLE `mock_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mock_subject` (`subject_id`),
  ADD KEY `fk_mock_topic` (`topic_id`),
  ADD KEY `idx_mock_attempted_on` (`attempted_on`);

--
-- Indexes for table `revision_tasks`
--
ALTER TABLE `revision_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_revision_topic` (`topic_id`),
  ADD KEY `fk_revision_knowledge` (`knowledge_entry_id`),
  ADD KEY `idx_revision_task_date` (`task_date`);

--
-- Indexes for table `source_documents`
--
ALTER TABLE `source_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_documents_user` (`uploaded_by`),
  ADD KEY `idx_documents_type` (`document_type`),
  ADD KEY `idx_documents_status` (`extraction_status`);

--
-- Indexes for table `study_items`
--
ALTER TABLE `study_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_study_topic` (`topic_id`),
  ADD KEY `fk_study_knowledge` (`knowledge_entry_id`),
  ADD KEY `idx_study_subject` (`subject_id`),
  ADD KEY `idx_study_type` (`item_type`),
  ADD KEY `idx_study_ai` (`ai_ready`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_subjects_slug` (`slug`),
  ADD KEY `idx_subjects_status` (`status`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_topics_chapter` (`chapter_id`),
  ADD KEY `idx_topics_parent` (`parent_id`),
  ADD KEY `idx_topics_revision` (`next_revision_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `case_laws`
--
ALTER TABLE `case_laws`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `compliance_obligations`
--
ALTER TABLE `compliance_obligations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `content_versions`
--
ALTER TABLE `content_versions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_tags`
--
ALTER TABLE `entity_tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `imports`
--
ALTER TABLE `imports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `knowledge_entries`
--
ALTER TABLE `knowledge_entries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `knowledge_relations`
--
ALTER TABLE `knowledge_relations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `legal_provisions`
--
ALTER TABLE `legal_provisions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mock_attempts`
--
ALTER TABLE `mock_attempts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `revision_tasks`
--
ALTER TABLE `revision_tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `source_documents`
--
ALTER TABLE `source_documents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `study_items`
--
ALTER TABLE `study_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `case_laws`
--
ALTER TABLE `case_laws`
  ADD CONSTRAINT `fk_cases_provision` FOREIGN KEY (`legal_provision_id`) REFERENCES `legal_provisions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_cases_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cases_topic` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `chapters`
--
ALTER TABLE `chapters`
  ADD CONSTRAINT `fk_chapters_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `compliance_obligations`
--
ALTER TABLE `compliance_obligations`
  ADD CONSTRAINT `fk_compliance_provision` FOREIGN KEY (`provision_id`) REFERENCES `legal_provisions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_compliance_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_compliance_topic` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `entity_tags`
--
ALTER TABLE `entity_tags`
  ADD CONSTRAINT `fk_entity_tags_tag` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `knowledge_entries`
--
ALTER TABLE `knowledge_entries`
  ADD CONSTRAINT `fk_knowledge_chapter` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_knowledge_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_knowledge_document` FOREIGN KEY (`source_document_id`) REFERENCES `source_documents` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_knowledge_provision` FOREIGN KEY (`legal_provision_id`) REFERENCES `legal_provisions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_knowledge_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_knowledge_topic` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `legal_provisions`
--
ALTER TABLE `legal_provisions`
  ADD CONSTRAINT `fk_provisions_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_provisions_topic` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `mock_attempts`
--
ALTER TABLE `mock_attempts`
  ADD CONSTRAINT `fk_mock_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_mock_topic` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `revision_tasks`
--
ALTER TABLE `revision_tasks`
  ADD CONSTRAINT `fk_revision_knowledge` FOREIGN KEY (`knowledge_entry_id`) REFERENCES `knowledge_entries` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_revision_topic` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `source_documents`
--
ALTER TABLE `source_documents`
  ADD CONSTRAINT `fk_documents_user` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `study_items`
--
ALTER TABLE `study_items`
  ADD CONSTRAINT `fk_study_knowledge` FOREIGN KEY (`knowledge_entry_id`) REFERENCES `knowledge_entries` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_study_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_study_topic` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `fk_topics_chapter` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_topics_parent` FOREIGN KEY (`parent_id`) REFERENCES `topics` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
