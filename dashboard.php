<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details and Addresses</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <style>
        .tittle {
            background-color: blueviolet;
            font-size: 20px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white; /* Adjust text color for better readability */
        }

        .table {
            text-align: center;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
          
        </div>
        <div class="row justify-content-center mt-5">
        <div class="col-3">
                <div class="user-details">
                    <h2>User Details</h2>
                    <?php
                    include('db.php');
                    $email = isset($_GET['email']) ? trim($_GET['email']) : null;
                    $id    = isset($_GET['id']) ? trim($_GET['id']) : null;
                    if ($email || $id) {
                        if($email){
                            $sql = "SELECT * FROM customer WHERE email=?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("s", $email);

                        }else if($id){
                            $sql = "SELECT * FROM customer WHERE id=?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("s", $id);
                        }
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($row = $result->fetch_assoc()) {
                            $id=$row['id'];
                            echo "<h7><strong>First Name:</strong> " . htmlspecialchars($row['first_name']) . "</h7><br><br>";
                            echo "<h7><strong>Last Name:</strong> " . htmlspecialchars($row['last_name']) . "</h7><br><br>";
                            echo "<h7><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</h7><br><br>";
                        } else {
                            echo "<p>User not found</p>";
                        }
                    } else {
                        echo "<p>Email parameter is missing</p>";
                    }
                    ?>
                </div>
                <div class="div">
                    <a href="edit.php/id?<?php echo $id;?>" class="btn btn-primary">Edit Profile</a>
                    <a href="index.html" class="btn btn-primary">Logout</a>
                </div>
            </div>
            <div class="col-8 col-md-6">
                <h2 class="tittle">Customer Address</h2>
               
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Street</th>
                                <th scope="col">City</th>
                                <th scope="col">State</th>
                                <th scope="col">Country</th>
                                <th scope="col">Phone Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if($email){
                                $where="Where c.email=";
                                $parm=$email;
    
                            }else if($id){
                               $where="Where c.id=";
                               $parm=$id;
                            }
                            if ($email || $id) {
                                $sql = "SELECT s.id, s.street, s.city, s.state, s.country, s.phone_no FROM customer AS c
                                LEFT JOIN customer_address AS s ON (c.id=s.cust_id) $where?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("s", $parm);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td scope='row'>" . htmlspecialchars($row["id"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["street"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["city"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["state"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["country"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["phone_no"]) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No addresses found</td></tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <a class="btn btn-primary" href="addaddress.php?id=<?php echo $id; ?>&email=<?php echo $email;?>">Add Your Address</a>

            </div>

        </div>
    </div>
</body>
</html>
