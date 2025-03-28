<?php
// Database connection parameters
$host = "localhost";
$dbname = "society";
$user = "postgres";
$password = "kamal";

$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");
if (!$conn) {
  die("Error in connection: " . pg_last_error());
}

// Fetch events
$sql = "SELECT event_name, event_date, description FROM events";
$result = pg_query($conn, $sql);

$events = [];
if ($result) {
    // Fetch each row and store it in the events array
    while ($row = pg_fetch_assoc($result)) {
        $events[] = $row;
    }
    // Free the result resource
    pg_free_result($result);
} else {
    echo "Error in SQL query: " . pg_last_error();
}

// Close the database connection
pg_close($conn);

// Return the events array
return $events;
?>