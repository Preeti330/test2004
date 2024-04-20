<?php
include('db.php');
$email = $_POST['email'];
$password = $_POST['password'];

if (empty($email) || empty($password)) {
    echo "Email and password are required.";
} else {
    // Hash the password for security
    $hashed_password = sha1($password);

    // Insert data into the database
    $sql="SELECT * FROM customer AS c WHERE c.email='$email'";
    $result=$conn->query($sql); 
    $row = $result->fetch_assoc();
    $pwd='';
   
    if ($row != null) {
        while ($row) {

           if($row['password'] !=$hashed_password){
            $pwd=$row['password'];
            echo '<script>alert("Please enter valid password");</script>';

          //  header("Location: login.html");
            // exit;
            // throw new Exception("Please enter valid password");
           }
           header("Location: registration.php");
        
        }
        $result->free();
        
        //    if($pwd !=$hashed_password){
        //     header("Location: login.html");
        //    }
    }else{

        $sql = "INSERT INTO customer (email, password) VALUES ('$email', '$hashed_password')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            session_start();
            // echo '<a href="registarion.php">Contact Us</a>';
            header("Location: registarion.php");
            
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
    } 
    
    }
}

// Close the database connection
$conn->close();
?>
