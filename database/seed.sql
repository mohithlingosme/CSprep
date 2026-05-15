USE corporate_law_erp;

INSERT INTO users (name, email, password_hash, role, created_at, updated_at)
SELECT
    'Founder Admin',
    'founder@corporatelaw.local',
    '$2y$10$iZhzVh1YzoCvNLuCCV8vger9aaVQKyFnHA6dINKUHDUuJ7so1sm1C',
    'founder',
    NOW(),
    NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM users WHERE email = 'founder@corporatelaw.local'
);

INSERT INTO subjects (code, name, slug, domain_type, description, syllabus_version, status, display_order, created_at, updated_at)
SELECT
    'CL',
    'Corporate Laws',
    'corporate-laws',
    'CS Executive',
    'Core founder subject bucket for corporate law corpus building.',
    '2026',
    'Active',
    1,
    NOW(),
    NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM subjects WHERE code = 'CL'
);
