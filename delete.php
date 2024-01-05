<?php

include("database.php");
if ($_GET['action'] == 'delete') {
    $id = $_GET['id'];

    $sql = "DELETE FROM contacts WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        
        header("Location: home.php?success"); 

        exit();
    } else {
        echo "Error deleting contact: " . mysqli_error($conn);
    }
}

?>