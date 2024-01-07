<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="output.css">
</head>
<body>
    
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

$html = <<<FORM
    <div class=" flex flex-col items-center justify-center h-screen w-full bg-[#e6effa]">
        <p class='text-6xl py-7'> 更新個人資料</p>
        <div class='space-y-4 w-full max-w-md p-4 bg-gray-100 rounded-lg shadow-md'>
        

            <form  action="edit.php?action=edit&id=$id" method="post">

                <table class="w-full ">
            
                <tr class="mb-4">

                    <th class="text-left font-medium text-gray-900 uppercase tracking-wider">ID</th>

                    <td><input type='text' name='id' value='$row[id]' readonly class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></td>

                </tr>
                <tr class="mb-4">

                    <th class="text-left font-medium text-gray-900 uppercase tracking-wider">User</th>

                    <td><input type="text" name="user" id="user" value="$row[user]" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></td>

                </tr>
                
            <tr class="mb-4">

                    <th class="text-left font-medium text-gray-900 uppercase tracking-wider">Password</th>

                    <td><input type='password' name='password' id='password' value='$row[password]' class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></td>

                </tr>
                <tr class="mb-4">

                    <th class="text-left font-medium text-gray-900 uppercase tracking-wider">Register Date</th>

                    <td><input type='date' name='reg_date' id='reg_date' value='$row[reg_date]' class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></td>

                </tr>

                </table>

                <button type="submit" class="rounded-md h-10 w-24 bg-blue-600 text-white  hover:bg-blue-800">Update</button>

            </form>

        </div>
        <hr class='my-4'>
        <div class="flex gap-4 mt-4">

            <a href="home.php" class="px-2 hover:text-blue-500">Homepage</a>

            <a href="add.php" class="px-2 hover:text-blue-500">Add New Information</a>

            <a href="search.php" class="px-2 hover:text-blue-500">Search</a>

        </div>

    </div>";

FORM;

echo $html;



?>


</body>
</html>



