<?php 
include '../../templates/header.php'; 
include '../../controllers/BanquetHallController.php'; 
include '../../config/database.php';

$database = new Database(); 
$db = $database->getConnection(); 
$hallController = new BanquetHallController($db); 

// if (isset($_GET['hall_id'])) {
//     $hall_id = $_GET['hall_id'];
//     $halls = $hallController->getOne($hall_id);
// } else {
//     // handle the case where hall_id is not provided
//     echo "Error: hall_id is not provided";
//     exit;
// }

$hall_id = $_GET['hall_id'];
$hall = $hallController->getOne($hall_id);

// Added to check if $hall might be false.
if (!$hall) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Error: Banquet hall details are not found.</div></div>";
    include '../../templates/footer.php';
    exit();
}

?>

<html>
<head>
    <title>Check Availability</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Reserve <?php echo htmlspecialchars($hall->hall_name, ENT_QUOTES, 'UTF-8'); ?></h2>
    <h3>Check Availability</h3>
    <form id="availabilityForm">
        <label for="event_date">Event Date:</label>
        <input type="date" id="event_date" name="event_date" required>
        <button type="submit">Check Availability</button>
    </form>

    <div id="availabilityResult"></div>

    <script>
        $(document).ready(function() {
            $('#availabilityForm').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    url: '../../controllers/BanquetHallReservationController.php',
                    type: 'POST',
                    data: {
                        action: 'showAvailability',
                        event_date: $('#event_date').val(),
                        hall_id: <?php echo $hall_id; ?>
                    },
                    success: function(response) {
                        console.log(response); // added for debugging
                        $('#availabilityResult').html(response);
                    },
                    error: function(xhr, status, error) {
                        $('#availabilityResult').html("<div class='alert alert-danger'>Error occurred: " + error + "</div>");
                    }
                });
            });
        });
    </script>
</body>
</html>



<!-- <form method="POST" action="/banquetHallReservation/showAvailability">
    <label for="event_date">Enter Event Date:</label>
    <input type="date" id="event_date" name="event_date" required>
    <button type="submit">Check Availability</button>
</form> -->
