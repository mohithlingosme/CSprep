<div class="row justify-content-center py-5">
    <div class="col-lg-5">
        <div class="app-card auth-card">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <span class="eyebrow">Founder Access</span>
                    <h1 class="h3 mb-2">Corporate Law Knowledge ERP</h1>
                    <p class="text-muted mb-0">Sign in to manage your legal corpus, revision engine, and AI-ready datasets.</p>
                </div>
                <span class="status-pill status-pill-dark">Secure</span>
            </div>

            <form method="post" action="<?= e(url('/login')) ?>" class="row g-3">
                <?= csrf_field() ?>
                <div class="col-12">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-control" id="email" name="email" type="email" value="<?= e(old('email')) ?>" required>
                </div>
                <div class="col-12">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-control" id="password" name="password" type="password" required>
                </div>
                <div class="col-12 d-grid">
                    <button class="btn btn-primary btn-lg" type="submit">Enter Founder Console</button>
                </div>
            </form>

            <div class="auth-footer">
                <small class="text-muted">Default seed login is documented in README.md and should be changed after first setup.</small>
            </div>
        </div>
    </div>
</div>
