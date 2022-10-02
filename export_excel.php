<?php
    require_once 'conn.php';
    // filename of csv file
    $filename = 'List of Records-'.date('Y-m-d').'.csv';
    // query to database
    $sql = "SELECT * FROM table_records";
    $result = mysqli_query($conn,$sql);
    // file handling fopen
    $file= fopen($filename,'w');
    // store the name of each row to array
    $array = array ("NAME","AGE","CONTACT_NUMBER","ADDRESS","EMAIL","CREATION_DATE");
    // The fputcsv() function formats a line as CSV and writes it to an open file.
    fputcsv($file,$array);

    //mysqli_fetch_array fetch a result row as a numeric array and as an associative array:
    while($row = mysqli_fetch_array($result)){
        $name = $row ['Name'];
        $age = $row ['Age'];
        $number = $row ['contactNumber'];
        $address = $row ['Address'];
        $email = $row ['Email'];
        $creation = $row ['creationDate'];

        $array = array($name,$age,$number,$address,$email,$creation);
        // fputcsv first param $file ,second param $array this will write to csv file
        fputcsv($file,$array);
    }
    fclose($file);
    // close file
    // send raw http header
    header("Content-Description: File Transfer");
    header("Content-Disposition: Attachment; filename=$filename");
    header("Content-Type: application/csv");
    // use readfile to read $filename var
    readfile($filename);
    exit();
?>