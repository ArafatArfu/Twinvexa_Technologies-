<div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
    <form action="#">
        <div class="form-group">
            <label for="singin-email">Username or email address *</label>
            <input type="text" class="form-control" id="singin-email" name="singin-email" required>
        </div>

        <div class="form-group">
            <label for="singin-password">Password *</label>
            <input type="password" class="form-control" id="singin-password" name="singin-password" required>
        </div>

        <div class="form-footer">
            <button type="submit" class="btn btn-outline-primary-2">
                <span>LOG IN</span>
                <i class="icon-long-arrow-right"></i>
            </button>

            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="signin-remember">
                <label class="custom-control-label" for="signin-remember">Remember Me</label>
            </div>

            <a href="#" class="forgot-link">Forgot Your Password?</a>
        </div>
    </form>
    @include('partials.mobile-menu.social-login')
</div>