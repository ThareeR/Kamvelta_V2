<?php
session_start();
include_once '../../config/database.php';
include '../../templates/header.php';
include '../../controllers/GuestController.php';

    $database = new Database();
    $db = $database->getConnection();
    $guestController = new GuestController($db);
    $guestId = isset($_GET['id']) ? $_GET['id'] : null;
    
    if ($guestId) {
        $guest = $guestController->show($guestId);
    }
?>

<div class="container mt-5">
    <h2>Edit Customer</h2>
        <form action="../../handlers/guestHandler.php" method="post">
            <input type="hidden" name="id" value="<?php echo $guestId; ?>">
            <div class="form-group">
                <label for="nic">NIC:</label>
                <input type="text" name="nic" id="nic" class="form-control" required 
                value="<?php echo $guest['nic']; ?>">
            </div>
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name" value="<?php echo $guest['first_name']; ?>" class="form-control" required >
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name" class="form-control" 
                required value="<?php echo $guest['last_name']; ?>">
            </div>
            <div class="form-group">
                <label for="contact_number">Contact Number:</label>
                <input type="text" name="contact_number" id="contact_number" 
                class="form-control" required value="<?php echo 
                $guest['contact_number']; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required 
                value="<?php echo $guest['email']; ?>">
            </div>
            <div class="form-group">
                <label for="home_address">Home Address:</label>
                <textarea name="home_address" id="home_address" class="form-control" 
                required><?php echo $guest['home_address']; ?></textarea>
            </div>
        <button type="submit" class="btn btn-primary">Update Customer</button>
    </form>
</div>
<?php include '../../templates/footer.php'; ?>