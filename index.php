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

// Check for form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate input
    if (isset($_POST['username']) && isset($_POST['password'])) {

        // Sanitize input
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Authenticate user
        $sql = "SELECT * FROM contacts WHERE user = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            if (mysqli_num_rows($result) == 1) {

                // Successful login
                $row = mysqli_fetch_assoc($result);

                // Start session and store relevant user data
                session_start();
                $_SESSION['user_id'] = $row['id'];

                // Redirect to appropriate page
                header("Location: home.php");
                exit();
            } else {

                // Invalid credentials
                // Display appropriate error message
                $both_error = "Invalid username or password.";
            }
        } else {

            // SQL query error
            // Log error or display generic error message
            $both_error = "An error occurred. Please try again later.";
        }

        mysqli_free_result($result); // Free the result set
    } else {

        // Handle missing form data
        if (empty($username)) {
            $username_error = "Please fill a username.";
        } else {
            $username_error = "";
        }

        if (empty($password)) {
            $password_error = "Please fill a password.";
        } else {
            $password_error = "";
        }
    }
}




?>


    <div class=" h-screen w-full items-center justify-center flex bg-[#e6effa]">
            <form  class=" bg-gray-100  shadow-xl grid box-border h-[48rem] w-96 border-2 rounded-md items-center justify-center " action="index.php" method="POST">
                <h1 class="text-7xl pt-6" >登入網站</h1> <br>
                <div class=" grid grid-cols-1 space-y-2 ">
                    <p>Username: </p>
                    <input class=" w-60 h-8 bg-white inline p-2 rounded-sm" type="text" name="username">
                    <p>Password: </p>
                    <input class=" w-60 h-8 bg-white inline p-2 rounded-sm" type="password" name="password">
                   
                </div>
                <input class=" rounded-md h-10 w-24 bg-blue-600 text-white my-4 hover:bg-blue-800" type="submit" name="register" value="Log in"> <br>
            </form>
    </div>



</body>
</html>
