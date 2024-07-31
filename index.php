<?php
session_start();
include_once '/config.php';

header('Location: views/home.php');

?>


<?php
// session_start();
// include_once '/config.php';

// require_once 'controllers/BanquetHallReservationController.php';
// require_once 'models/BanquetHallReservation.php';
// require_once 'config/database.php';

// $db = new Database();
// $controller = new BanquetHallReservationController($db);

// $action = isset($_GET['action']) ? $_GET['action'] : '';

// if (empty($action)) {
//     // Show the homepage by default
//     include __DIR__.'/views/home.php';
// } else {
//     switch ($action) {
//         case 'showAvailability':
//             $controller->showAvailability();
//             break;
//         case 'reserve':
//             $controller->reserve();
//             break;
//         default:
//             // Show the initial date form
//             include 'views/reservation/banquetHallDate.php';
//             break;
//     }
// }
?>



