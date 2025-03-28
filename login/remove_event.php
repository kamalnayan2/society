<?php
include "../partials/db_connect.php";

if (isset($_GET['id'])) {
    $eventId = intval($_GET['id']);
    $deleteQuery = "DELETE FROM Events WHERE id = $eventId";
    pg_query($conn, $deleteQuery);
    header('Location: home.php'); // Redirect back to the dashboard
    exit();
}
?>