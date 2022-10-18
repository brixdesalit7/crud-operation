<?php
require_once 'conn.php';
// assign the value of global var $_GET['update']
$id = $_GET['update'];
// assign each name attribute of form to php variable
$name = $_POST['name'];
$age = $_POST['age'];
$number = $_POST['number'];
$address = $_POST['address'];
$email = $_POST['email'];

// perform a query to database
$sql ="UPDATE table_records SET Name='$name', Age='$age', contactNumber='$number', Address='$address', Email='$email' WHERE ID='$id' ";
$query = $conn->query($sql);
if($query){
    echo "<script>alert('Record Updated!');</script>";
    echo "<script>document.location='index.php';</script>";
}else {
    echo "<script>alert('Something went wroing');</script>";
}
