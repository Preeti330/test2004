<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Address and Logout</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">

                <div class="add-address">
                    <h2>Add Address</h2>
                    <?php
                    include('db.php');
                    $street = $city = $state = $country = "";
                  
                    //  $id = ($_GET['id']) ?$_GET['id'] : 1;
                    //  $email = isset($_GET['email']) ? trim($_GET['email']) : null;
                    session_start();
                if (isset($_GET['id'])) {
                    $_SESSION['id'] = $_GET['id'];
                }
                    
                
                    // Processing form data when form is submitted
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Validate street
                        $id= $_POST['id'];
                    
                        if (empty(trim($_POST["street"]))) {
                            echo "<p>Please enter street.</p>";
                        } else {
                            $street = trim($_POST["street"]);
                        }

                        // Validate city
                        if (empty(trim($_POST["city"]))) {
                            echo "<p>Please enter city.</p>";
                        } else {
                            $city = trim($_POST["city"]);
                        }

                        // Validate state
                        if (empty(trim($_POST["state"]))) {
                            echo "<p>Please enter state.</p>";
                        } else {
                            $state = trim($_POST["state"]);
                        }

                        // Validate country
                        if (empty(trim($_POST["country"]))) {
                            echo "<p>Please enter country.</p>";
                        } else {
                            $country = trim($_POST["country"]);
                        }

                        if (!empty($street) && !empty($city) && !empty($state) && !empty($country)) {
                           
                         

                            $sql = "INSERT INTO customer_address (cust_id,street, city, state, country) VALUES (?,?, ?, ?, ?)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("sssss",$id, $street, $city, $state, $country);

                            if ($stmt->execute()) {
                                echo "<p>Address added successfully.</p>";
                                header("Location: dashboard.php?id=$id");

                            } else {
                                echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
                            }

                            // Close the statement and database connection
                            $stmt->close();
                            $conn->close();
                        }
                    }
                    ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                  
                    <div class="mb-3">
                    <input type="hidden" name="id" value="<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : 1; ?>">
                    </div>
                        <div class="mb-3">
                            <label for="street" class="form-label">Street:</label>
                            <input type="text" class="form-control" id="street" name="street" required>
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">City:</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        <div class="mb-3">
                            <label for="state" class="form-label">State:</label>
                            <input type="text" class="form-control" id="state" name="state" required>
                        </div>
                        <div class="mb-3">
                            <label for="country" class="form-label">Country:</label>
                            <input type="text" class="form-control" id="country" name="country" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Address</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
