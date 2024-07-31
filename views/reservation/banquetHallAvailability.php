<?php
    include_once __DIR__.'/../../config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Select Time Slot</title>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const startTimeInput = document.getElementById('start_time');
            const endTimeInput = document.getElementById('end_time');
            const startTimeWarning = document.getElementById('start_time_warning');
            const endTimeWarning = document.getElementById('end_time_warning');
            const timeSlots = {
                'morning': { 'start': '04:00', 'end': '12:00' },
                'afternoon': { 'start': '12:30', 'end': '16:30' },
                'evening': { 'start': '17:00', 'end': '00:00' }
            };

            function isTimeInRange(start, end, time) {
                const [startHour, startMinute] = start.split(':').map(Number);
                const [endHour, endMinute] = end.split(':').map(Number);
                const [timeHour, timeMinute] = time.split(':').map(Number);
                const startTime = new Date(1970, 0, 1, startHour, startMinute);
                const endTime = new Date(1970, 0, 1, endHour, endMinute);
                const timeToCheck = new Date(1970, 0, 1, timeHour, timeMinute);

                if (endTime < startTime) {
                    endTime.setDate(endTime.getDate() + 1); // Handle overnight range
                }

                return (timeToCheck >= startTime && timeToCheck <= endTime);
            }

            function validateTime(input, warningElement) {
                const selectedSlots = Array.from(document.querySelectorAll('input[name="time_slots[]"]:checked')).map(el => el.value);
                const timeValue = input.value;
                let isValid = false;

                if (selectedSlots.length === 0) {
                    warningElement.style.display = 'inline';
                    return;
                }

                for (let slot of selectedSlots) {
                    if (isTimeInRange(timeSlots[slot].start, timeSlots[slot].end, timeValue)) {
                        isValid = true;
                        break;
                    }
                }

                if (isValid) {
                    warningElement.style.display = 'none';
                } else {
                    warningElement.style.display = 'inline';
                }
            }

            function validateEndTime() {
                if (endTimeInput.value && startTimeInput.value && endTimeInput.value <= startTimeInput.value) {
                    endTimeWarning.style.display = 'inline';
                } else {
                    endTimeWarning.style.display = 'none';
                }
            }

            startTimeInput.addEventListener('input', function () {
                validateTime(startTimeInput, startTimeWarning);
                validateEndTime();
            });

            endTimeInput.addEventListener('input', function () {
                validateTime(endTimeInput, endTimeWarning);
                validateEndTime();
            });

            // Re-validate on time slot selection change
            document.querySelectorAll('input[name="time_slots[]"]').forEach(slotCheckbox => {
                slotCheckbox.addEventListener('change', function () {
                    validateTime(startTimeInput, startTimeWarning);
                    validateTime(endTimeInput, endTimeWarning);
                });
            });
        });
    </script>
</head>
<body>
    <h3>Select Time Slot for Your Event</h3>
    <form action="<?php echo BASE_URL; ?>/handlers/banquetHallReservationHandler.php" method="POST">
        <input type="hidden" name="hall_id" value="<?php echo htmlspecialchars($hall_id); ?>">
        <input type="hidden" name="event_date" value="<?php echo htmlspecialchars($date); ?>">

        <table>
            <tr>
                <th>Time Slot</th>
                <th>Availability</th>
                <th>Select</th>
            </tr>
            <tr>
                <td>Morning (4:00 AM - 12:00 Noon)</td>
                <td><?php echo htmlspecialchars($slots['morning']); ?></td>
                <td><input type="checkbox" name="time_slots[]" value="morning" <?php echo $slots['morning'] == 'booked' ? 'disabled' : ''; ?>></td>
            </tr>
            <tr>
                <td>Afternoon (12:30 PM - 4:30 PM)</td>
                <td><?php echo htmlspecialchars($slots['afternoon']); ?></td>
                <td><input type="checkbox" name="time_slots[]" value="afternoon" <?php echo $slots['afternoon'] == 'booked' ? 'disabled' : ''; ?>></td>
            </tr>
            <tr>
                <td>Evening (5:00 PM - 12:00 Midnight)</td>
                <td><?php echo htmlspecialchars($slots['evening']); ?></td>
                <td><input type="checkbox" name="time_slots[]" value="evening" <?php echo $slots['evening'] == 'booked' ? 'disabled' : ''; ?>></td>
            </tr>
        </table>

        <h3>Reservation Details</h3>
        <label for="start_time">Start Time:</label>
        <input type="time" id="start_time" name="start_time" required>
        <span id="start_time_warning" style="color: red; display: none;">Invalid start time.</span>
        
        <label for="end_time">End Time:</label>
        <input type="time" id="end_time" name="end_time" required>
        <span id="end_time_warning" style="color: red; display: none;">Invalid end time.</span>
        
        <label for="number_of_guests">Number of Guests:</label>
        <input type="number" id="number_of_guests" name="number_of_guests" required>

        <button type="submit">Reserve</button>
    </form>

</body>
</html>



