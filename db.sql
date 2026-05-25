-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2026 at 09:02 PM
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
-- Database: `csprep_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `business_frameworks`
--

CREATE TABLE `business_frameworks` (
  `id` bigint(20) NOT NULL,
  `subject_domain` varchar(100) NOT NULL,
  `concept_framework_name` varchar(255) NOT NULL,
  `originator_theorist` varchar(255) DEFAULT NULL,
  `relevance_status` varchar(100) DEFAULT NULL,
  `definition` text NOT NULL,
  `core_business_problem_solved` text DEFAULT NULL,
  `key_assumptions` text DEFAULT NULL,
  `theoretical_foundation` text DEFAULT NULL,
  `core_components` text DEFAULT NULL,
  `matrix_cycle_mechanics` text DEFAULT NULL,
  `input_variables` text DEFAULT NULL,
  `expected_outputs` text DEFAULT NULL,
  `best_suited_for` text DEFAULT NULL,
  `industry_suitability` text DEFAULT NULL,
  `economic_cycle_relevance` text DEFAULT NULL,
  `target_text_stakeholders` text DEFAULT NULL,
  `step_by_step_implementation_plan` text DEFAULT NULL,
  `resource_requirements` text DEFAULT NULL,
  `change_management` text DEFAULT NULL,
  `common_bottlenecks` text DEFAULT NULL,
  `key_performance_indicators` text DEFAULT NULL,
  `cac_vs_ltv_impact` text DEFAULT NULL,
  `impact_on_margins` text DEFAULT NULL,
  `roi_measurement` text DEFAULT NULL,
  `contractual_requirements` text DEFAULT NULL,
  `data_privacy_compliance` text DEFAULT NULL,
  `intellectual_property_risks` text DEFAULT NULL,
  `board_director_liabilities` text DEFAULT NULL,
  `software_saas_tools_needed` text DEFAULT NULL,
  `database_schema_implications` text DEFAULT NULL,
  `automation_potential` text DEFAULT NULL,
  `integration_with_existing_systems` text DEFAULT NULL,
  `benchmark_case_study` text DEFAULT NULL,
  `failure_case_study` text DEFAULT NULL,
  `competitor_usage` text DEFAULT NULL,
  `industry_standard_metrics` text DEFAULT NULL,
  `blind_spots_in_theory` text DEFAULT NULL,
  `situations_where_model_fails_completely` text DEFAULT NULL,
  `modern_alternatives_or_upgrades` text DEFAULT NULL,
  `academic_critiques` text DEFAULT NULL,
  `pitching_the_concept` text DEFAULT NULL,
  `jargon_vs_reality` text DEFAULT NULL,
  `pivot_triggers` text DEFAULT NULL,
  `cross_functional_conflicts` text DEFAULT NULL,
  `high_yield_exam_patterns` text DEFAULT NULL,
  `essay_case_study_structures` text DEFAULT NULL,
  `practice_scenarios` text DEFAULT NULL,
  `mnemonics_flowcharts` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cafm_repository`
--

CREATE TABLE `cafm_repository` (
  `id` bigint(20) NOT NULL,
  `module` enum('Corporate Accounting','Financial Management') NOT NULL,
  `chapter_name` varchar(255) NOT NULL,
  `applicable_standard` varchar(150) DEFAULT NULL,
  `concept_definition` text NOT NULL,
  `statutory_requirements` text DEFAULT NULL,
  `theoretical_assumptions` text DEFAULT NULL,
  `journal_entries` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`journal_entries`)),
  `schedule_iii_presentation` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`schedule_iii_presentation`)),
  `ledger_account_format` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`ledger_account_format`)),
  `core_formulas` text DEFAULT NULL,
  `decision_making_criteria` text DEFAULT NULL,
  `variables_and_components` text DEFAULT NULL,
  `standard_calculation_table` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`standard_calculation_table`)),
  `hidden_adjustments` text DEFAULT NULL,
  `reconciliation_logic` text DEFAULT NULL,
  `past_paper_frequency` enum('High','Medium','Low') DEFAULT NULL,
  `common_student_errors` text DEFAULT NULL,
  `mnemonics_and_shortcuts` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `global_tags`
--

CREATE TABLE `global_tags` (
  `id` bigint(20) NOT NULL,
  `tag_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_tags`
--

CREATE TABLE `item_tags` (
  `tag_id` bigint(20) NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `table_source` enum('law_provisions','business_frameworks','cafm_repository','statistics_concepts') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `law_provisions`
--

CREATE TABLE `law_provisions` (
  `id` bigint(20) NOT NULL,
  `statute_name` varchar(255) NOT NULL,
  `chapter` varchar(150) DEFAULT NULL,
  `section_number` varchar(50) NOT NULL,
  `year` int(11) NOT NULL,
  `jurisdiction` varchar(100) DEFAULT 'India',
  `status` enum('Active','Repealed','Amended','Pending Enforcement') DEFAULT 'Active',
  `statutory_text` text NOT NULL,
  `explanation` text DEFAULT NULL,
  `illustrations` text DEFAULT NULL,
  `provisos` text DEFAULT NULL,
  `exceptions` text DEFAULT NULL,
  `explanation_clauses` text DEFAULT NULL,
  `objective_of_provision` text DEFAULT NULL,
  `legislative_intent` text DEFAULT NULL,
  `historical_background` text DEFAULT NULL,
  `mischief_sought_to_be_prevented` text DEFAULT NULL,
  `constitutional_validity` text DEFAULT NULL,
  `applicable_persons` text DEFAULT NULL,
  `authorities_involved` text DEFAULT NULL,
  `territorial_scope` text DEFAULT NULL,
  `temporal_scope` text DEFAULT NULL,
  `preconditions` text DEFAULT NULL,
  `threshold_conditions` text DEFAULT NULL,
  `rights_created` text DEFAULT NULL,
  `duties_imposed` text DEFAULT NULL,
  `liabilities` text DEFAULT NULL,
  `penalties` text DEFAULT NULL,
  `defenses` text DEFAULT NULL,
  `immunities` text DEFAULT NULL,
  `procedure_triggered` text DEFAULT NULL,
  `required_forms` text DEFAULT NULL,
  `authorities_to_approach` text DEFAULT NULL,
  `limitation_period` text DEFAULT NULL,
  `appeals_process` text DEFAULT NULL,
  `compliance_requirements` text DEFAULT NULL,
  `landmark_cases` text DEFAULT NULL,
  `ratio_decidendi` text DEFAULT NULL,
  `obiter_dicta` text DEFAULT NULL,
  `conflicting_judgments` text DEFAULT NULL,
  `judicial_trends` text DEFAULT NULL,
  `constitutional_challenges` text DEFAULT NULL,
  `related_sections` text DEFAULT NULL,
  `related_rules` text DEFAULT NULL,
  `related_regulations` text DEFAULT NULL,
  `related_international_laws` text DEFAULT NULL,
  `allied_acts` text DEFAULT NULL,
  `real_world_application` text DEFAULT NULL,
  `industry_usage` text DEFAULT NULL,
  `compliance_burden` text DEFAULT NULL,
  `common_litigation_areas` text DEFAULT NULL,
  `drafting_risks` text DEFAULT NULL,
  `practical_examples` text DEFAULT NULL,
  `interpretational_conflicts` text DEFAULT NULL,
  `grey_areas` text DEFAULT NULL,
  `enforcement_problems` text DEFAULT NULL,
  `misuse_potential` text DEFAULT NULL,
  `litigation_hotspots` text DEFAULT NULL,
  `simplified_notes` text DEFAULT NULL,
  `flowcharts_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`flowcharts_json`)),
  `mnemonics` text DEFAULT NULL,
  `practice_questions` text DEFAULT NULL,
  `case_based_problems` text DEFAULT NULL,
  `exam_notes` text DEFAULT NULL,
  `amendments` text DEFAULT NULL,
  `notifications` text DEFAULT NULL,
  `circulars` text DEFAULT NULL,
  `government_guidelines` text DEFAULT NULL,
  `pending_bills` text DEFAULT NULL,
  `law_commission_reports` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `practice_questions`
--

CREATE TABLE `practice_questions` (
  `id` bigint(20) NOT NULL,
  `related_concept_id` bigint(20) NOT NULL,
  `subject_domain` enum('Law','Business','Statistics','CMA') NOT NULL,
  `question_text` text NOT NULL,
  `difficulty_level` enum('Basic','Intermediate','Exam-Level','Past Paper') DEFAULT 'Exam-Level',
  `past_paper_reference` varchar(100) DEFAULT NULL,
  `total_marks` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `solution_steps`
--

CREATE TABLE `solution_steps` (
  `id` bigint(20) NOT NULL,
  `question_id` bigint(20) NOT NULL,
  `step_number` int(11) NOT NULL,
  `step_title` varchar(255) NOT NULL,
  `step_logic` text NOT NULL,
  `marks_awarded` decimal(3,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `statistics_concepts`
--

CREATE TABLE `statistics_concepts` (
  `id` bigint(20) NOT NULL,
  `syllabus_unit` varchar(100) NOT NULL,
  `concept_name` varchar(255) NOT NULL,
  `statistical_category` varchar(100) DEFAULT NULL,
  `definition` text NOT NULL,
  `primary_functions` text DEFAULT NULL,
  `scope_and_significance` text DEFAULT NULL,
  `limitations` text DEFAULT NULL,
  `core_formula` text DEFAULT NULL,
  `variables_explanation` text DEFAULT NULL,
  `computational_methods` text DEFAULT NULL,
  `required_data_type` text DEFAULT NULL,
  `parametric_assumptions` text DEFAULT NULL,
  `reversibility_tests` text DEFAULT NULL,
  `hypothesis_setup` text DEFAULT NULL,
  `procedure_steps` text DEFAULT NULL,
  `level_of_significance` text DEFAULT NULL,
  `one_vs_two_tailed_logic` text DEFAULT NULL,
  `interpreting_results` text DEFAULT NULL,
  `types_of_errors` text DEFAULT NULL,
  `skewness_impact` text DEFAULT NULL,
  `recommended_graphs` text DEFAULT NULL,
  `graphical_significance` text DEFAULT NULL,
  `diagrammatic_difference` text DEFAULT NULL,
  `correlation_vs_regression` text DEFAULT NULL,
  `regression_equations` text DEFAULT NULL,
  `time_series_components` text DEFAULT NULL,
  `consumer_price_index_usage` text DEFAULT NULL,
  `business_forecasting` text DEFAULT NULL,
  `saas_analytics_implementation` text DEFAULT NULL,
  `common_misinterpretations` text DEFAULT NULL,
  `statistical_bias` text DEFAULT NULL,
  `python_pandas_logic` text DEFAULT NULL,
  `sql_aggregation_logic` text DEFAULT NULL,
  `high_yield_exam_patterns` text DEFAULT NULL,
  `practice_problems` text DEFAULT NULL,
  `mnemonics` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `business_frameworks`
--
ALTER TABLE `business_frameworks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_biz_domain` (`subject_domain`),
  ADD KEY `idx_biz_framework` (`concept_framework_name`);
ALTER TABLE `business_frameworks` ADD FULLTEXT KEY `idx_biz_search` (`definition`,`core_business_problem_solved`);

--
-- Indexes for table `cafm_repository`
--
ALTER TABLE `cafm_repository`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cafm_module` (`module`),
  ADD KEY `idx_cafm_chapter` (`chapter_name`);

--
-- Indexes for table `global_tags`
--
ALTER TABLE `global_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag_name` (`tag_name`);

--
-- Indexes for table `item_tags`
--
ALTER TABLE `item_tags`
  ADD PRIMARY KEY (`tag_id`,`item_id`,`table_source`);

--
-- Indexes for table `law_provisions`
--
ALTER TABLE `law_provisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_law_statute` (`statute_name`),
  ADD KEY `idx_law_section` (`section_number`),
  ADD KEY `idx_law_status` (`status`);
ALTER TABLE `law_provisions` ADD FULLTEXT KEY `idx_law_search` (`statutory_text`,`explanation`,`penalties`);

--
-- Indexes for table `practice_questions`
--
ALTER TABLE `practice_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_related_concept` (`related_concept_id`,`subject_domain`);

--
-- Indexes for table `solution_steps`
--
ALTER TABLE `solution_steps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_step_per_q` (`question_id`,`step_number`);

--
-- Indexes for table `statistics_concepts`
--
ALTER TABLE `statistics_concepts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_stats_unit` (`syllabus_unit`),
  ADD KEY `idx_stats_category` (`statistical_category`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `business_frameworks`
--
ALTER TABLE `business_frameworks`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cafm_repository`
--
ALTER TABLE `cafm_repository`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `global_tags`
--
ALTER TABLE `global_tags`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `law_provisions`
--
ALTER TABLE `law_provisions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `practice_questions`
--
ALTER TABLE `practice_questions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `solution_steps`
--
ALTER TABLE `solution_steps`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `statistics_concepts`
--
ALTER TABLE `statistics_concepts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `item_tags`
--
ALTER TABLE `item_tags`
  ADD CONSTRAINT `item_tags_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `global_tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `solution_steps`
--
ALTER TABLE `solution_steps`
  ADD CONSTRAINT `solution_steps_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `practice_questions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
