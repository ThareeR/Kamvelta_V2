<?php
    session_start();
    define('NO_NAVBAR', true);  // Added to remove displaying the navbar
    include '../../templates/header.php';
    include_once '../../config/database.php';
    include '../../controllers/GuestController.php';

    $database = new Database();
    $db = $database->getConnection();
    $guestController = new GuestController($db);
    $guests = $guestController->index();

    // Search query
    // Debugging: Check if search is set
    $searchQuery = '';
    if (isset($_GET['search'])) {
        $searchQuery = $_GET['search'];
        // Debugging: Display search query
        // echo "Search Query: " . htmlspecialchars($searchQuery) . "<br>";
        if (!empty($searchQuery)) {
            $guests = $guestController->search($searchQuery);
            // Debugging: Display number of results found
            // echo "Number of results found: " . count($guests) . "<br>";
        }
    }
?>
<div class="container mt-5">
    <h2>Manage Customers</h2>

    <a href="addCustomer.php" class="btn btn-primary">Add Customer</a>

    <!-- Search form -->
    <form action="manageCustomers.php" method="get">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search by name or NIC" name="search" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </div>
    </form>

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
            <?php if(!empty($guests)): ?>
                <?php foreach ($guests as $guest): ?>
                <tr>
                    <td><?php echo htmlspecialchars($guest['nic']); ?></td>
                    <td><?php echo htmlspecialchars($guest['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($guest['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($guest['contact_number']); ?></td>
                    <td><?php echo htmlspecialchars($guest['email']); ?></td>
                    <td><?php echo htmlspecialchars($guest['home_address']); ?></td>
                    <td>
                        <a href="editCustomer.php?id=<?php echo $guest['id']; ?>" class="btn btn-lg btn-primary btn-manage">Edit</a>
                        <a href="../../handlers/guestHandler.php?id=<?php echo $guest['id']; ?>&action=delete" class="btn btn-lg btn-danger btn-manage" onclick="return confirm('Are you sure you want to delete this customer?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No Customer Found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php //include '../../templates/footer.php'; ?>