<?php include '../../templates/header.php'; ?>
<div class="container mt-5">
    <h2>Login</h2>
    <?php if (isset($_GET['error']) && $_GET['error'] == 'login_failed'): ?>
        <div class="alert alert-danger">Login failed. Please check your username and password.</div>
    <?php endif; ?>
    <?php if (isset($_GET['success']) && $_GET['success'] == 'registered'): ?>
        <div class="alert alert-success">Registration successful. Please log in.</div>
    <?php endif; ?>
    <form action="../../handlers/loginHandler.php" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <p class="mt-3"><a href="resetPasswordRequest.php">Forgot your password?</a></p>

        <button type="submit" class="btn btn-primary">Login</button>
        <!-- <p class="mt-3">Don't have an account? <a href="../reservation/personalInfo.php">Register here</a></p> -->
        <p class="mt-3">Don't have an account? <a href="register.php">Register here</a></p>
    </form>
</div>
<?php include '../../templates/footer.php'; ?>