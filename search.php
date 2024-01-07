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
    $contacts = [];
    if (mysqli_num_rows($result) > 0) {
       while ($row = mysqli_fetch_assoc($result)) {
           $contacts[] = $row;
       }
    }
    else{
        $error_message="No contacts found";
    }
    
    // Build CSS-ready values (replace with your desired styling)
    $id_values = implode(" ", array_column($contacts, 'id'));
    $user_values = implode(" ", array_column($contacts, 'user'));
    $password_values = implode(" ", array_column($contacts, 'password'));
    $reg_date_values = implode(" ", array_column($contacts, 'reg_date'));

    mysqli_stmt_close($stmt);
}

// Close connection
mysqli_close($conn);

?>


    <div class="flex flex-col items-center justify-center h-screen w-full bg-[#e6effa]">
        <p class='text-6xl py-7'> 查詢資料</p>
        <div class=' bg-gray-100 w-[48rem] p-4 bg-white rounded-lg shadow-md '>
            <form method="post">
                <table class=" columns-3 w-full ">
                    <tr class="mb-4">
                        <th class="text-left font-medium text-gray-900 uppercase tracking-wider">ID:</th>
                        
                        <td><input type="text" name="id" id="id" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></td>
                        <td  class='w-full px-3 py-2 border rounded-md bg-white' >
                        <?php 
                            echo $id_values;
                        ?>
                        </td>
                        
                    </tr>
                    <tr class="mb-4">
                        <th class="text-left font-medium text-gray-900 uppercase tracking-wider">User:</th>
                        <td><input type="text" name="user" id="user" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></td>
                        <td  class='w-full px-3 py-2 border rounded-md bg-white' >
                        <?php 
                            echo $user_values;
                        ?>
                        </td>
                        
                    </tr>
                    <tr class="mb-4">
                        <th class="text-left font-medium text-gray-900 uppercase tracking-wider">Password:</th>
                        <td><input type="text" name="password" id="password" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></td>
                        <td  class='w-full px-3 py-2 border rounded-md bg-white' >
                        <?php 
                            echo $password_values;
                        ?>
                        </td>
                    </tr>
                    <tr class="mb-4">
                        <th class="text-left font-medium text-gray-900 uppercase tracking-wider">Date:</th>
                        <td><input type="date" name="reg_date" id="reg_date" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></td>
                        <td  class='w-full px-3 py-2 border rounded-md bg-white' >
                        <?php 
                            echo $reg_date_values;
                        ?>
                        </td>
                        
                    </tr>
                    
                </table>
                <button type="submit" name="search" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Search</button>
            </form>
            
        </div>
        <hr class='my-4'>
        <div class="flex gap-4 mt-4">

            <a href="home.php" class="px-2 hover:text-blue-500">Homepage</a>

            <a href="add.php" class="px-2 hover:text-blue-500">Add New Information</a>

            <a href="search.php" class="px-2 hover:text-blue-500">Search</a>

        </div>
    </div>







</body>
</html>
