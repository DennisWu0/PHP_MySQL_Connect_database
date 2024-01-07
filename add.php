

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="output.css">
</head>
<body>

    
<div class="  flex flex-col items-center justify-center h-screen w-full bg-[#e6effa]">
    <p class='text-6xl py-7'> 新增資料</p>
    <div class='w-full max-w-md p-4 rounded-lg shadow-md bg-gray-100'>
        <form action="add.php" method="post">
            <table class="w-full">
                <tr class="mb-4">
                    <th class="text-left font-medium text-gray-900 uppercase tracking-wider">User</th>
                    <td><input type="text" name="user" id="user" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></td>
                </tr>
                <tr class="mb-4">
                    <th class="text-left font-medium text-gray-900 uppercase tracking-wider">Password</th>
                    <td><input type="password" name="password" id="password" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></td>
                </tr>
                <tr class="mb-4">
                    <th class="text-left font-medium text-gray-900 uppercase tracking-wider">Registration Date</th>
                    <td><input type="date" name="reg_date" id="reg_date" value="<?php echo date("Y-m-d"); ?>" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></td>
                </tr>
            </table>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Add Contact</button>
        </form>
    </div>
    <hr class='my-4'>
        <div class="flex gap-4 mt-4">

            <a href="home.php" class="px-2 hover:text-blue-500">Homepage</a>

            <a href="add.php" class="px-2 hover:text-blue-500">Add New Information</a>

            <a href="search.php" class="px-2 hover:text-blue-500">Search</a>

        </div>
</div>

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


?>
</body>
</html>


