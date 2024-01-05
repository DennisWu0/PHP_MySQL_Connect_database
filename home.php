<?php
include("database.php");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL query to select all elements from the table
$sql = "SELECT * FROM contacts";

// Execute query
$result = mysqli_query($conn, $sql);

// Print table headers
echo "<table border='1'>";
echo "<tr>";
echo "<th>id</th>";
echo "<th>user</th>";
echo "<th>password</th>";
echo "<th>reg_date</th>";
echo "<th>Edit</th>";
echo "<th>Delete</th>";
echo "</tr>";

// Print table rows
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row["id"] . "</td>";
    echo "<td>" . $row["user"] . "</td>";
    echo "<td>" . $row["password"] . "</td>";
    echo "<td>" . $row["reg_date"] . "</td>";
    echo "<td><a href='edit.php?action=edit&id=$row[id]'>Edit</a></td>";
    echo "<td><a href='delete.php?action=delete&id=$row[id]'>Delete</a></td>";
    echo "</tr>";
}


// Close table
echo "</table>";
echo"----------------------------------------------------------------------------------"."<br>";

echo "<br>";
echo "<a href='index.php'>Homepage</a>";  // Link to homepage
echo " | <a href='add.php'>Add New Information</a>";  // Link to add new information
echo " | <a href='search.php'>Search</a>";


// Close connection
mysqli_close($conn);
?>