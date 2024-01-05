<?php

include("database.php");

// Check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// If a search is being submitted
if (isset($_POST['search'])) {
    $id = $_POST['id'];
    $user = $_POST['user'];
    $password = $_POST['password'];
    $reg_date = $_POST['reg_date'];

    // Build the WHERE clause dynamically based on provided criteria
    $whereClause = "";
    $params = [];
    $types = "";

    if (!empty($id)) {
        $whereClause .= "id = ?";
        $params[] = $id;
        $types .= "i";
    }

    if (!empty($user)) {
        if (!empty($whereClause)) {
            $whereClause .= " AND ";
        }
        $whereClause .= "user LIKE ?";
        $params[] = "%$user%";
        $types .= "s";
    }

    // ... similar checks for password and reg_date (adjust like for user) ...

    // Prepare the query with placeholders
    $sql = "SELECT * FROM contacts WHERE $whereClause";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters to placeholders
    mysqli_stmt_bind_param($stmt, $types, ...$params);

    // Execute the query
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if any contacts were found
    if (mysqli_num_rows($result) == 0) {
        echo "<p>No contacts found.</p>";
    } else {
        // Display the search results
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>User</th><th>Password</th><th>Registration Date</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['user'] . "</td>";
            echo "<td>" . $row['password'] . "</td>";
            echo "<td>" . $row['reg_date'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    mysqli_stmt_close($stmt);
}

// Display search form
echo "<form method='post'>";
echo "<label for='id'>ID:</label>";
echo "<input type='text' name='id' id='id'><br>";
echo "<label for='user'>User:</label>";
echo "<input type='text' name='user' id='user'><br>";
echo "<label for='password'>Password:</label>";
echo "<input type='text' name='password' id='password'><br>";
echo "<label for='reg_date'>Registration Date:</label>";
echo "<input type='date' name='reg_date' id='reg_date'><br>";
echo "<button type='submit' name='search'>Search</button>";
echo "</form>";

// Close connection
mysqli_close($conn);

?>
