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

        .reservation-header {
            background-color: #293241;
        }

        .red-btn {
            background-color: #ee6c4d;
            color: white;
        }

        .database-header {
            background-color: #293241;
        }
    </style>
</head>
<body class="">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Sunset</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="database.php">Database</a>
    </div>
  </div>
</nav>
    <main class="container">
        <div class="row">
            <div class="mt-5 offset-2 col-8 font-size-xl">
                <div class="reservation-header text-white rounded  text-center py-3">
                    <h2 class="font-weight-bold">Room Reservation System</h2>
                </div>
                <form action="" method="post" class="my-5">
                    <div class="form-group text-white">
                        <label for="txtName">Name:</label>
                        <input type="text" class="form-control" name="txtName" required>

                        <label for="txtEmail">Email:</label>
                        <input type="text" class="form-control" name="txtEmail" required>
                    </div>


                    <div class="form-group text-white">
                        <label for="txtRoom">Room Type:</label>
                        <select class="form-control" name="txtRoom" required>
                            <option value="Regular">Regular</option>
                            <option value="Deluxe">Deluxe</option>
                            <option value="VIP Suite">VIP Suite</option>
                        </select>
                    </div>

                    <div class="form-group text-white">
                        <label for="txtDateIn">Date:</label>
                        <input type="text" class="form-control datepicker" name="txtDateIn" id="txtDateIn" required>

                        <label for="txtDateOut">Date:</label>
                        <input type="text" class="form-control datepicker" name="txtDateOut" id="txtDateOut" required>
                    </div>

                    <button type="submit" class="btn btn-danger" name="btnReserve">Reserve Now!</button>
                </form>
            </div>
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
            $('.datepicker').datepicker({
                autoclose: true,
                todayHighlight: true,
                todayBtn: 'linked',
                startDate: 'today',
            });

            $('#datatable').DataTable();

            $('#txtDate').keypress(function(e) {
                e.preventDefault();
            });
        });
    </script>
</body>
</html>
