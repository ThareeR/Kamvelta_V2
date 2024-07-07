<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bookings by Room Type</title>
    <!-- <script src="/assets/js/chart.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
    <h1>Bookings by Room Type</h1>
    <label for="month">Select Month:</label>
    <select id="month" name="month" onchange="fetchBookings()">
        <option value="">--Select Month--</option>
        <option value="1">January</option>
        <option value="2">February</option>
        <option value="3">March</option>
        <option value="4">April</option>
        <option value="5">May</option>
        <option value="6">June</option>
        <option value="7">July</option>
        <option value="8">August</option>
        <option value="9">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
    </select>

    <canvas id="bookingsChart" width="400" height="200"></canvas>

    <script>
        function fetchBookings() {
            const month = document.getElementById('month').value;
            if (!month) return;

            fetch(`/controllers/BookingController.php?month=${month}`)
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.type_name);
                    const values = data.map(item => item.bookings);

                    const ctx = document.getElementById('bookingsChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Number of Bookings',
                                data: values,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching bookings:', error));
        }
    </script>
</body>
</html>
