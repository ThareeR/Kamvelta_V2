<?php 
define('NO_NAVBAR', true);
include '../../templates/header.php'; ?>
<div class="container mt-5">
    <h2>Admin Registration</h2>
    <?php if (isset($_GET['error']) && $_GET['error'] == 'registration_failed'): ?>
        <div class="alert alert-danger">Registration failed. Please try again.</div>
    <?php endif; ?>
    <form action="../../handlers/registrationHandler.php" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <!-- <div class="form-group">
            <label for="role" class="form-label">Role</label>
            <select class="form-controler" id="role" name="role">
                <option value="customer">Customer</option>
                <option value="admin">Admin</option>
            </select>
        </div> -->
        <input type="hidden" name="role" value="admin">
        <button type="submit" class="btn btn-primary">Register Admin</button>
    </form>
</div>
<?php include '../../templates/footer.php'; ?>