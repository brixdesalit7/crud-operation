<?php 
    require_once 'conn.php';
    // ADD RECORD
    // check if the form is submitted
    // isset() method in PHP to test the form is submitted successfully or not
    if(isset($_POST['submit'])) {
    // assign the value of GLOBAL $_POST ASSOCIATIVE ARRAY
    $name = $_POST['name'];
    $age = $_POST['age'];
    $number = $_POST['number'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    // perform a query to database using mysqli_query
    // this query will check if the name already exist in database
    $check = mysqli_query($conn, "SELECT * FROM table_records WHERE NAME = '".$_POST['name']."'");
    // mysqli_num_rows used to check if the value of variable $check is already exist in database
    // if true use script tag to alert the following string
    // else create a query
    if(mysqli_num_rows($check)) {
        echo "<script>alert('Name Already Exist!');</script>";
    } else {
        // perform query to database
        $sql = "INSERT INTO table_records(Name, Age, contactNumber, Address, Email, creationDate) 
        VALUES('$name', '$age', '$number', '$address', '$email', NOW())";
        $query = $conn->query($sql);

        if($query) {
            echo "<script>alert('New Record Added!');</script>";
        } else {
            echo "<script>alert('Something went wrong');</script>";
        }
    }
    }

    // DELETE RECORD
    if(isset($_GET['delete'])) {
        // intval to get the int value of varible $_GET[delete]
        $id = intval($_GET['delete']);
        // query to database
        $sql = "DELETE FROM table_records WHERE ID='$id'";
        $query = $conn->query($sql);
        if($query) {
            // display a message
            echo "<script>alert('Record Deleted!');</script>";
            echo "<script>window.location='index.php';</script>";
        } else {
            echo "<script>alert('Something went wrong');</script>";
        }
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud Operation</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,600;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <!-- DATA TABLE JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif!important;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark py-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Dashboard</a>
    </div>
    </nav>
    
        
    <div class="container mt-3">
        <div class="d-sm-flex justify-content-between align-items-center">
        <div class="title my-5">
            <h2>Crud Operation</h2>
        </div>
        <div class="add-record-btn">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addRecord">Add Record</button>
            <button type="submit" class="btn btn-success" onclick="Export()"><i class="bi bi-file-earmark-spreadsheet"></i>Excel</button>
        </div>
    </div>
    <div class="table-responsive-sm">
    <table class="table table-bordered overflow-scroll" id="dataTable">
        <thead>
        <tr>
            <th>Name</th>
            <th>Age</th>
            <th>Contact #</th>
            <th>Address</th>
            <th>Email</th>
            <th>Creation Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            <!-- DISPLAY DATA FROM DATABASE -->
            <?php
                //include the file connected to database
                include('conn.php');
                // perform query to database
                $query = mysqli_query($conn,"SELECT * FROM `table_records`");
                //  fetch the next row of a result set as an associative array
                while($row = mysqli_fetch_array($query)) {
            ?>
            <tr>
                <!-- display the value of each row  -->
                <td><?php echo ($row['Name']); ?></td>
                <td><?php echo ($row['Age']); ?></td>
                <td><?php echo ($row['contactNumber']); ?></td>
                <td><?php echo ($row['Address']); ?></td>
                <td><?php echo ($row['Email']); ?></td>
                <td><?php echo ($row['creationDate']); ?></td>
                <td>
                <button data-bs-toggle="modal" data-bs-target="#editRecords<?php echo $row['ID'];?>" class="btn btn-success"><i class="bi bi-pencil-square"></i></button> 
                <button data-bs-toggle="modal" data-bs-target="#delRecords<?php echo $row['ID']; ?>" class="btn btn-danger"><i class="bi bi-trash"></i></button> 
                <button data-bs-toggle="modal" data-bs-target="#viewRecords<?php echo $row['ID']; ?>" class="btn btn-primary"><i class="bi bi-eye-fill"></i></button> 
                <?php include('action.php'); ?>
                </td>                                  
            </tr>
            <?php
            }
            ?>       
        </tbody>
    </table>
    </div>
    </div>

    <!-- Add Record  Modal -->
    <div class="modal fade" id="addRecord">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Add Record</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <form method="POST">
            <div class="mb-2 mt-2">
                <label for="email" class="form-label">Name:</label>
                <input type="text" class="form-control"  placeholder="Enter name" name="name">
            </div>
            <div class="mb-2">
                <label for="pwd" class="form-label">Age:</label>
                <input type="number" class="form-control" placeholder="Enter age" name="age">
            </div>
            <div class="mb-2">
                <label for="pwd" class="form-label">Contact Number:</label>
                <input type="number" class="form-control" placeholder="Enter number" name="number">
            </div>
            <div class="mb-2">
                <label for="pwd" class="form-label">Address:</label>
                <input type="text" class="form-control"  placeholder="Enter address" name="address">
            </div>
            <div class="mb-2">
                <label for="pwd" class="form-label">Email:</label>
                <input type="email" class="form-control"  placeholder="Enter email" name="email">
            </div>
            <button type="submit" class="btn btn-success mt-3" name="submit">Save</button>
            </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
    </div>

    <script>
        function Export() {
            let conf = confirm("Procees Record to Excel?")
            if (conf == true) {
                window.open("export_excel.php",'_blank');
            }else {
                window.close();
            }
        }
        $(document).ready(function() {
            $('#dataTable').DataTable();
        } );
    </script>

</body>
</html>