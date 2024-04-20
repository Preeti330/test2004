<?php
include('db.php');
$error_message = ""; 

session_start();
if (isset($_GET['id'])) {
    $_SESSION['id'] = $_GET['id'];
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $id= $_POST['id'];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

   
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        //  validation  password 
        $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{6,}$/';
        if (!preg_match($passwordRegex, $password)) {
            $error_message = "Password must contain at least 6 characters with at least one lowercase letter, one uppercase letter, one digit, and one special character.";
        } else {
            $hashed_password = sha1($password);

            // $date=date('YYYY-MM-dd H::i::s');
            $date = date('Y-m-d H:i:s');
            $sql = "UPDATE customer
                    SET first_name=?, last_name=?, password=?, created_at=?
                    WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $first_name, $last_name, $hashed_password, $date, $id);
            

            if ($stmt->execute()) {
               
                // echo '<a href="registarion.php">Contact Us</a>';
                // header("Location: dashboard.php/$email");
                // $id = $conn->insert_id;
             
                // header("Location: dashboard.php?id=$id&email=$email");

                
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            } 
            header("Location: dashboard.php?id=$id&email=$email");
            $error_message = "Registration successful!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <style>
        /* Custom CSS styles */
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-top: 50px;
        }
        .inputfeild {
            margin-top: 5px;
        }
        .text{
            background-color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-container">
                    <h2 class="mb-3 inputfeild">Edit Profile</h2>
                    <?php if (!empty($error_message)) : ?>
                        <div class="alert alert-danger text" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="mb-3">
                    <input type="hidden" name="id" value="<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : 1; ?>">
                    </div>
                        <div class="mb-3 inputfeild">
                            <label for="first_name" class="form-label">First Name:</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="mb-3 inputfeild">
                            <label for="last_name" class="form-label">Last Name:</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="mb-3 inputfeild">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3 inputfeild">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3 inputfeild">
                            <label for="confirm_password" class="form-label">Confirm Password:</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
