<?php

include("database.php");  // Include database connection variables

// Check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = $_GET['id'];  // Assuming the ID is passed via GET

$result = mysqli_query($conn, "SELECT * FROM contacts WHERE id = $id");
$row = mysqli_fetch_assoc($result);

if (!$row) {  // Handle contact not found
    header("Location: home.php?error");
    exit();}

// Process form submission (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $reg_date = mysqli_real_escape_string($conn, $_POST['reg_date']);

    $sql = "UPDATE contacts SET user = '$user', password = '$password', reg_date = '$reg_date' WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header("Location: home.php?success");
        exit();
    } else {
        echo "Error updating contact: " . mysqli_error($conn);
    }
}

mysqli_close($conn);

// Display edit form with table structure
echo "<form action='edit.php?action=edit&id=$id' method='post'>";  // Pass 'action=edit' for subsequent POST requests
echo "<table>";
echo "<tr><th>ID</th><td><input type='text' name='id' value='$row[id]' readonly></td></tr>";  // Make ID readonly
echo "<tr><th>User</th><td><input type='text' name='user' id='user' value='$row[user]'></td></tr>";
echo "<tr><th>Password</th><td><input type='password' name='password' id='password' value='$row[password]'></td></tr>";
echo "<tr><th>Registration Date</th><td><input type='date' name='reg_date' id='reg_date' value='$row[reg_date]'></td></tr>";
echo "</table>";
echo "<button type='submit'>Update</button>";
echo "</form>";

?>
