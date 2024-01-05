include("database.php");
    $sql="SELECT * FROM contacts WHERE user='[John]' ";
    $result= mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);
        echo $row["id"]. "<br>";
        echo $row["password"]. "<br>";
        echo $row["reg_date"]. "<br>";

    }
    mysqli_close($conn);


// select the row in the database
    $sql =" SELECT * FROM contacts W";
    $results= mysqli_query($conn,$sql);
    if(mysqli_num_rows($results) >0 ){
        while($row=mysqli_fetch_assoc($results)){
        echo $row["id"]. "<br>";
        
        echo $row["user"]. " is the handsome boy with his ".$row["password"]. "<br>";
        echo $row["password"]. "<br>";
        };
        
    }
    else{
        echo"No user found";
    }


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username= filter_input(INPUT_POST,"username",FILTER_SANITIZE_SPECIAL_CHARS);
        $password= filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);

        if(empty($username)){
            echo"Please fill a username";
        }
        elseif(empty($password)){
            echo"Please fill a password";
        }
        else{
            $hash=password_hash($password,PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO contacts (user, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hash);

            if ($stmt->execute()) {
                echo "You are now registered";
            } else {
                echo "Registration failed: " . $conn->error;
            }

            $stmt->close();
            }

        mysqli_close($conn);

    }