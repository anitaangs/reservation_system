<?php
    $local =  "localhost"; // Host Name
    $user  =  "root"; // Host Username
    $pass  =  ""; // Host Password
    $db    =  "room_reservation"; // Database Name

    // Establish connection to the database
    $con = new mysqli($local, $user, $pass, $db);
    // if there is a problem, show error message
    if ($con->connect_errno) {
        echo "Failed to connect to MySQL: " . $con->connect_error;
        exit();
    }

    if(isset($_POST["btnReserve"])) {
        $name = trim($con->real_escape_string($_POST["txtName"]));
        $email = trim($con->real_escape_string($_POST["txtEmail"]));
        $room = trim($con->real_escape_string($_POST["txtRoom"]));
        $datein = trim($con->real_escape_string($_POST["txtDateIn"]));
        $dateout = trim($con->real_escape_string($_POST["txtDateOut"]));

        if ($stmt = $con->prepare("INSERT INTO `reservations`(`name`, `email`, `room`, `date_in`, `date_out`) VALUES (?, ?, ?, ?, ?)")) {
            $stmt->bind_param("sssss", $name,  $email, $room, $datein, $dateout );
            $stmt->execute();
            $stmt->close();
        } else {
            die('prepare() failed: ' . htmlspecialchars($con->error));
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Simple Room Reservation System in PHP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/c82e9a37b7.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <style>
        body {
            background: #98c1d9;
            font-family: sans-serif;
        }

        .database-header {
            background-color: #293241;
        }
    </style>
</head>
<body >
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="index.php">Home</a>
      <a class="nav-item nav-link active" href="database.php">Database <span class="sr-only">(current)</span></a>
    </div>
  </div>
</nav>
    <main class="container">
    <div class="row mt-2">
            <div class="offset-2 col-8 mt-5">
                <table class="table table-striped table-bordered" id="datatable">
                    <legend class="database-header p-3 text-white text-center rounded">
                        <h2 class="m-0">Reservations Table</h2>
                    </legend>
                    <thead>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Room Type</th>
                        <th>Check-In</th>
                        <th>Check-Out</th>
                    </thead>
                    <tbody>
                        <?php                         
                            // Display database table data
                            if ($stmt = $con->prepare("SELECT * FROM `reservations`")) {
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>".
                                            "<td>".$row["id"]."</td>".
                                            "<td>".$row["name"]."</td>".
                                            "<td>".$row["email"]."</td>".
                                            "<td>".$row["room"]."</td>".
                                            "<td>".$row["date_in"]."</td>".
                                            "<td>".$row["date_out"]."</td>".
                                        "</tr>";
                                }
                                $stmt->close();
                            } else {
                                die('prepare() failed: ' . htmlspecialchars($con->error));
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#datatable').DataTable();

        });
    </script>
</body>
</html>