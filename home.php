<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="output.css">
</head>
<body>
    

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


// 1. Outer container for overall content structure
echo "<div class='flex items-center justify-center h-screen w-full bg-[#e6effa]'>";
    
    // 2. Container for the table with padding and centering
    echo "<div class='grid items-center justify-items-center container px-4'>";
        echo "<p class='text-6xl py-7'> 通訊管理頁面</p>";  
        // 3. Table with styling
        echo "<table class='bg-gray-100 rounded-lg shadow-md w-full h-auto'>";
            
            echo "<tr>";
            echo "<th class='px-4 py-2 text-left font-medium text-gray-900 uppercase tracking-wider'>id</th>";
            echo "<th class='px-4 py-2 text-left font-medium text-gray-900 uppercase tracking-wider'>user</th>";
            echo "<th class='px-4 py-2 text-left font-medium text-gray-900 uppercase tracking-wider'>password</th>";
            echo "<th class='px-4 py-2 text-left font-medium text-gray-900 uppercase tracking-wider'>reg_date</th>";
            echo "<th class='px-4 py-2 text-left font-medium text-gray-900 uppercase tracking-wider'>Edit</th>";
            echo "<th class='px-4 py-2 text-left font-medium text-gray-900 uppercase tracking-wider'>Delete</th>";
            echo "</tr>";
            // 4. Table rows (unchanged)
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr class='bg-white border-b border-gray-200 hover:bg-gray-100'>";
                echo "<td class='px-4 py-2'>" . $row["id"] . "</td>";
                echo "<td class='px-4 py-2'>" . $row["user"] . "</td>";
                echo "<td class='px-4 py-2'>" . $row["password"] . "</td>";
                echo "<td class='px-4 py-2'>" . $row["reg_date"] . "</td>";
                echo "<td class='px-4 py-2'><a href='edit.php?action=edit&id=$row[id]' class='text-blue-500 hover:text-blue-700'>Edit</a></td>";
                echo "<td class='px-4 py-2'><a href='delete.php?action=delete&id=$row[id]' class='text-red-500 hover:text-red-700'>Delete</a></td>";
                echo "</tr>";
            }

        echo "</table>";

        // 5. Visual separator for clarity
        echo "<hr class='my-4'>";  // Horizontal rule for visual separation

        // 6. Navigation links with spacing
        echo "<div class='flex items-center justify-center mt-4'>";
            echo " <a href='index.php' class='px-2 hover:text-blue-500'>Log out</a>";
            echo "  <a href='add.php' class='px-2 hover:text-blue-500'>Add New Information</a>";
            echo "  <a href='search.php' class='px-2 hover:text-blue-500'>Search</a>";
            
        echo "</div>";

    echo "</div>";  // Close table container

echo "</div>";  // Close outer container




mysqli_close($conn);
?>


</body>
</html>

