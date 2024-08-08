<?php
define('NO_NAVBAR', true);
include_once '../../templates/header.php';
include_once '../../config/database.php';
include_once '../../controllers/BanquetHallController.php';

$database = new Database();
$db = $database->getConnection();
$controller = new BanquetHallController($db);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        $data = [
            'hall_name' => $_POST['hall_name'],
            'capacity' => $_POST['capacity'],
            'charge_per_hour' => $_POST['charge_per_hour']
        ];
        $controller->create($data);
    } elseif (isset($_POST['update'])) {
        $id = $_POST['hall_id'];
        $data = [
            'hall_id' => $id,
            'hall_name' => $_POST['hall_name'],
            'capacity' => $_POST['capacity'],
            'charge_per_hour' => $_POST['charge_per_hour']
        ];
        $controller->update($data);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['hall_id'];
        $controller->delete($id);
    }
}

$halls = $controller->index();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Banquet Halls</title>
    <!-- <link rel="stylesheet" type="text/css" href="../../assets/css/styles.css"> -->
    <style>
        .btn {
            margin: 5px;
            display: inline-block;
            padding: 10px 15px;
            border: 1px solid #000;
            text-align: center;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .btn-group .btn {
            flex: 1;
            margin: 0 5px;
        }

        .btn-group button {
            margin: 0 5px;
            padding: 10px 15px;
            border: 1px solid #000;
            text-align: center;
            /* height: 30px;
            display: inline-block;
            vertical-align: middle; */
        }

        .btn-group form {
            display: inline-block;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Banquet Halls</h1>

        <form method="POST" action="">
            <input type="hidden" name="hall_id" id="hall_id">
            <label for="hall_name">Name:</label>
            <input type="text" name="hall_name" id="hall_name" required>
            <br><br>
            <label for="capacity">Capacity:</label>
            <input type="number" name="capacity" id="capacity" required>
            <br><br>
            <label for="charge_per_hour">Charge per Hour:</label>
            <input type="number" name="charge_per_hour" id="charge_per_hour" required>
            <br>
            <button type="submit" name="create" id="create_button">Add Banquet Hall</button>
            <button type="submit" name="update" id="update_button" style="display:none;">Update Banquet Hall</button>
        </form>

        <!-- <h2>Existing Banquet Halls</h2> -->
        <div>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Capacity</th>
                <th>Charge per Hour</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($halls as $hall): ?>
            <tr>
                <td><?php echo $hall['hall_id']; ?></td>
                <td><?php echo $hall['hall_name']; ?></td>
                <td><?php echo $hall['capacity']; ?></td>
                <td><?php echo $hall['charge_per_hour']; ?></td>
                <td>
                    <div class="btn-group">
                        <button onclick="editHall(<?php echo htmlspecialchars(json_encode($hall)); ?>)">Edit</button>
                        <form method="POST" action="" style="display:inline;">
                            <input type="hidden" name="hall_id" value="<?php echo $hall['hall_id']; ?>">
                            <!-- <button onclick="editHall(<?php // echo htmlspecialchars(json_encode($hall)); ?>)">Edit</button> -->
                            <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this Banquet Hall?')">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        </div>
    </div>

    <script>
        function editHall(hall) {
            document.getElementById('hall_id').value = hall.hall_id;
            document.getElementById('hall_name').value = hall.hall_name;
            document.getElementById('capacity').value = hall.capacity;
            document.getElementById('charge_per_hour').value = hall.charge_per_hour;

            document.getElementById('create_button').style.display = 'none';
            document.getElementById('update_button').style.display = 'inline';
        }
    </script>
</body>
</html>
<?php include_once '../../templates/footer.php'; ?>
