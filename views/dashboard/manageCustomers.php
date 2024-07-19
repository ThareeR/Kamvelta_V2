<?php
    session_start();
    include_once '../../config/database.php';
    include '../../templates/header.php';
    include '../../controllers/GuestController.php';
    $database = new Database();
    $db = $database->getConnection();
    $guestController = new GuestController($db);
    $guests = $guestController->index();
?>
<div class="container mt-5">
    <h2>Manage Customers</h2>
    <table class="table">
        <thead>
            <tr>
                <th>NIC</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Home Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($guests as $guest): ?>
            <tr>
                <td><?php echo $guest['nic']; ?></td>
                <td><?php echo $guest['first_name']; ?></td>
                <td><?php echo $guest['last_name']; ?></td>
                <td><?php echo $guest['contact_number']; ?></td>
                <td><?php echo $guest['email']; ?></td>
                <td><?php echo $guest['home_address']; ?></td>
                <td>
                    <a href="editCustomer.php?id=<?php echo $guest['id']; ?>" class="btn btn-sm btn-primary btn-manage">Edit</a>
                    <a href="../../handlers/guestHandler.php?id=<?php echo $guest['id']; ?>&action=delete" class="btn btn-sm btn-danger btn-manage" onclick="return confirm('Are you sure you want to delete this customer?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="addCustomer.php" class="btn btn-primary">Add Customer</a>
</div>
<?php include '../../templates/footer.php'; ?>