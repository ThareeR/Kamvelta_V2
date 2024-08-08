<?php include '../../templates/header.php'; ?>
<div class="container mt-5">
    <h2>Reset Password</h2>
    <form action="../../handlers/resetPasswordHandler.php" method="post">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
</div>
<?php include '../../templates/footer.php'; ?>
