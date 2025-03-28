<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: adminlogin.php');
    exit();
}

// Include database connection
include "../partials/db_connect.php";

if (isset($_GET['id'])) {
    $eventId = intval($_GET['id']);
    
    // Fetch the event details
    $eventQuery = "SELECT * FROM events WHERE id = $eventId";
    $eventResult = pg_query($conn, $eventQuery);
    $event = pg_fetch_assoc($eventResult);
    
    if (!$event) {
        die("Event not found.");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the updated event data from the form
    $eventName = $_POST['event_name'];
    $eventDate = $_POST['event_date'];
    $eventTime = $_POST['event_time'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    // Update the event in the database
    $updateQuery = "UPDATE events SET event_name = '$eventName', event_date = '$eventDate', event_time = '$eventTime', location = '$location', description = '$description' WHERE id = $eventId";
    pg_query($conn, $updateQuery);
    
    header('Location: home.php'); // Redirect back to the dashboard
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Event</h2>
        <form method="POST">
            <div class="form-group">
                <label for="event_name">Event Name</label>
                <input type="text" class="form-control" id="event_name" name="event_name" value="<?php echo htmlspecialchars($event['event_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="event_date">Event Date</label>
                <input type="date" class="form-control" id="event_date" name="event_date" value ="<?php echo htmlspecialchars($event['event_date']); ?>" required>
            </div>
            <div class="form-group">
                <label for="event_time">Event Time</label>
                <input type="time" class="form-control" id="event_time" name="event_time" value="<?php echo htmlspecialchars($event['event_time']); ?>" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($event['description']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Event</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>