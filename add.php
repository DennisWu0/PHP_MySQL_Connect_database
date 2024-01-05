<?php

include("database.php");

// Check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the highest existing ID before form submission
$sql = "SELECT MAX(id) AS max_id FROM contacts";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$new_id = $row['max_id'] + 1;  // Calculate the next ID

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $reg_date = mysqli_real_escape_string($conn, $_POST['reg_date']);

    $sql = "INSERT INTO contacts (id, user, password, reg_date) VALUES ('$new_id', '$user', '$password', '$reg_date')";
    if (mysqli_query($conn, $sql)) {
        header("Location: home.php?success");
        exit();
    } else {
        echo "Error adding contact: " . mysqli_error($conn);
    }

}

mysqli_close($conn);
echo "<form action='add.php' method='post'>";
echo "<table>";
echo "<tr><th>User</th><td><input type='text' name='user' id='user'></td></tr>";
echo "<tr><th>Password</th><td><input type='password' name='password' id='password'></td></tr>";
echo "<tr><th>Registration Date</th><td><input type='date' name='reg_date' id='reg_date' value='" . date("Y-m-d") . "'></td></tr>";
echo "</table>";
echo "<button type='submit'>Add Contact</button>";
echo "</form>";

?>
