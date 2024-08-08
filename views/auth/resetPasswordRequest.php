<?php include '../../templates/header.php'; ?>
<div class="container mt-5">
    <h2>Reset Password</h2>
    <form action="../../handlers/resetPasswordRequestHandler.php" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Send Reset Link</button>
    </form>
</div>
<?php include '../../templates/footer.php'; ?>
