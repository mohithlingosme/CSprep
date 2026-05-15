# PHASE 2 EXPANSION PLAN
## Corporate Legal + Tax + Accounting + Financial Management AI Knowledge Infrastructure

---

## INFORMATION GATHERED

### Current System Analysis:
- **Architecture**: Custom PHP MVC (no external framework)
- **Database**: MariaDB with 17 tables
- **Features**: Knowledge management, Case laws, Legal provisions, Compliance tracking, Study items, Import/Export
- **CS Executive**: Currently only JIGL subject (Paper 2 aligned)
- **UI**: Bootstrap 5-based admin panel with sidebar navigation

### Required Expansion Areas:
1. **Tax Laws Module** (Paper 7 aligned)
2. **Corporate Accounting Module** (Paper 4 aligned)
3. **Financial Management Module** (Paper 4 aligned)
4. **Student Learning System** with gamification
5. **AI Training System** with export capabilities
6. **Founder Dashboard** enhanced metrics

---

## DETAILED IMPLEMENTATION PLAN

### PHASE 2.1: DATABASE SCHEMA EXPANSION

#### New Tax Tables:
```sql
-- tax_sections (Direct Tax provisions - ITA)
-- tax_gst_modules (GST Act sections)
-- tax_customs_modules (Customs Act)
-- tax_tds_tcs_provisions (TDS/TCS sections)
-- tax_case_laws (Tax case database)
-- tax_mcqs (Tax multiple choice questions)
-- tax_practical_questions (Tax numericals)
-- tax_amendments (Finance Act updates)
-- tax_compliance_forms (Forms, due dates)
-- tax_notices (IT/GST notices)
-- tax_exemptions (exemption provisions)
-- tax_deductions (Chapter VI-A deductions)
```

#### New Accounting Tables:
```sql
-- accounting_modules (Topics)
-- accounting_standards (AS/Ind AS)
-- accounting_problems (Numerical problem bank)
-- accounting_mcqs
-- accounting_formulas (Formula repository)
-- ratio_analysis_db
-- financial_statement_templates
-- consolidation_workbooks
-- merger_accounting_records
```

#### New Finance Tables:
```sql
-- finance_modules
-- finance_formulas (NPV, IRR, WACC, etc.)
-- capital_budgeting_problems
-- financial_mcqs
-- valuation_models
-- risk_analysis_records
-- working_capital_cycles
```

#### New Learning & Gamification Tables:
```sql
-- student_profiles (XP, levels, badges)
-- study_streaks (daily tracking)
-- achievement_badges
-- topic_mastery_records
-- mock_test_sessions
-- mock_answers
-- study_sessions
-- daily_goals
-- revision_scheduler
```

#### New AI Training Tables:
```sql
-- ai_training_corpus
-- ai_prompt_response_pairs
-- rag_content_chunks
-- knowledge_graph_entities
-- export_jobs
```

### PHASE 2.2: SUBJECTS EXPANSION (CS EXECUTIVE ALIGNED)

| Subject Code | Subject Name | Syllabus Paper | Module Priority |
|--------------|--------------|-----------------|------------------|
| JIGL | Jurisprudence | Paper 2 | Phase 1 (existing) |
| CL | Company Law | Paper 2 | Phase 1 (existing) |
| EC | Economic & Commercial Laws | Paper 2 | Phase 1 (existing) |
| TA | Tax & Corporate Laws | Paper 7 | HIGH PRIORITY |
| CAFM | Corporate Acct & Financial Mgmt | Paper 4 | HIGH PRIORITY |
| GST | Goods & Services Tax | Paper 7 | HIGH PRIORITY |
| CLT | Corporate Law & TFM Combo | Paper 2+4 | COMBO |

### PHASE 2.3: ROUTING EXPANSION (bootstrap.php)

New routes to add:
- `/admin/tax-laws/*` - Tax provisions management
- `/admin/gst/*` - GST module management
- `/admin/direct-tax/*` - Direct tax management
- `/admin/accounting/*` - Accounting module management
- `/admin/financial-management/*` - Finance module management
- `/admin/formula-engine/*` - Formula builder
- `/admin/practical-problems/*` - Numerical problem bank
- `/admin/mock-tests/*` - Test management
- `/admin/revision-engine/*` - Revision scheduling
- `/admin/knowledge-exports/*` - AI export center
- `/admin/ai-training/*` - AI training configuration

### PHASE 2.4: CONTROLLERS TO CREATE

1. **TaxSectionController** - Tax provisions CRUD
2. **TaxGstController** - GST modules
3. **TaxCaseLawController** - Tax case laws
4. **TaxMcqController** - Tax MCQs
5. **TaxProblemController** - Tax numericals
6. **AccountingModuleController** - Accounting topics
7. **AccountingStandardController** - AS/Ind AS
8. **AccountingProblemController** - Accounting numericals
9. **FormulaRepositoryController** - Formula management
10. **FinanceModuleController** - Finance topics
11. **CapitalBudgetingController** - NPV/IRR problems
12. **StudentProfileController** - Student gamification
13. **MockTestController** - Test engine
14. **RevisionSchedulerController** - Smart revision
15. **AiTrainingController** - AI corpus management

### PHASE 2.5: MODELS TO CREATE

Corresponding models for each controller with proper relationships.

### PHASE 2.6: VIEWS EXPANSION

Templates to create:
- Tax dashboards with tax-specific metrics
- Accounting dashboards with ratio visualizations
- Finance dashboards with NPV/IRR calculators
- Student dashboards with gamification UI
- AI Training center with export options

### PHASE 2.7: ENHANCED DASHBOARD

Founder Dashboard sections:
- Subject coverage grid
- Tax module progress
- Accounting completion
- Finance module progress
- AI readiness percentage
- Dataset size metrics
- Export queue status
- Student progress overview

---

## DEPENDENT FILES TO EDIT

1. **database/schema.sql** - Add all new tables
2. **app/Config/config.php** - Add new config if needed
3. **app/bootstrap.php** - Register all new routes
4. **app/Services/DashboardService.php** - Add new metrics
5. **app/Views/layouts/main.php** - Add new nav items
6. **app/Support/helpers.php** - Add new helper functions

---

## IMPLEMENTATION SEQUENCE

### Step 1: Database Schema
- Run expanded schema.sql to create all new tables
- Insert seed data for CS Executive subjects

### Step 2: Core Models
- Create all new Model classes

### Step 3: Controllers
- Create all new Controller classes

### Step 4: Routes
- Register all routes in bootstrap.php

### Step 5: Views
- Create all view templates

### Step 6: Services
- Enhance DashboardService
- Create FormulaEngine service

### Step 7: UI Updates
- Update navigation
- Add gamification CSS/JS

### Step 8: Testing
- Verify all routes work
- Test data entry flows
- Test export functionality

---

## SUCCESS CRITERIA

✅ All 17+ new tables created with proper indexes
✅ 6 new subjects aligned to CS Executive (June 2026)
✅ Full CRUD for Tax, Accounting, Finance modules
✅ Student dashboard with gamification
✅ AI export system with JSONL support
✅ Formula repository working
✅ Mock test engine functional
✅ Mobile-responsive UI maintained

---

## ESTIMATED DELIVERABLES

- 40+ new PHP files
- 20+ new SQL tables
- 30+ view templates
- Complete admin panel expansion
- Student learning system
- AI training corpus builder

This plan transforms the existing system into a comprehensive Corporate Legal + Tax + Accounting + Financial Management AI Knowledge Infrastructure ERP.
