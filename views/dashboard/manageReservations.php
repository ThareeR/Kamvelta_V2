<?php
session_start();

include '../../config/database.php';
include '../../templates/header.php';
include '../../controllers/ReservationController.php';
include '../../controllers/GuestController.php';

    $database = new Database();
    $db = $database->getConnection();
    $reservationController = new ReservationController($db);
    $reservations = $reservationController->getAll();
    $guestController = new GuestController($db);
?>
<div class="container mt-5">
    <h2>Manage Reservations</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Reservation ID</th>
                <th>Guest Name</th>
                <th>Check-in Date</th>
                <th>Check-out Date</th>
                <th>Status</th>
                <th>Actions</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $reservation): ?>
            <tr>
                <td><?php echo $reservation['reservation_id']; ?></td>
                <td>
                <?php 
                    $guest = $guestController->show($reservation['guest_id']);
                    echo $guest['first_name'] . ' ' . $guest['last_name']; 
                ?>
                </td>
                <td><?php echo $reservation['check_in_date']; ?></td>
                <td><?php echo $reservation['check_out_date']; ?></td>
                <td><?php echo $reservation['reservation_status']; ?></td>
                <td>
                    <a href="viewReservation.php?id=<?php echo $reservation['reservation_id']; 
                    ?>" class="btn btn-sm btn-primary">View</a>
                    <a href="editReservation.php?id=<?php echo $reservation['reservation_id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                    <a href="../../handlers/reservationHandler.php?id=<?php echo $reservation['reservation_id']; ?>&action=delete" class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include '../../templates/footer.php'; ?>