<?php
header("Content-Type:application/json");
include "conn.php";


$action = $_POST['action'];

function readAll($con)
{
    $data = array();
    $message = array();

    $query = "SELECT *FROM `students`";
    $result = $con->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data = $row;
            $message = array("status" => "true", "data" => $data);
        }
    } else {
        $message = array("status" => "false", "data" => $con->error);
    }
    echo json_encode($message);
}

function registerStd($con)
{
    $id = $_POST['stdid'];
    $name = $_POST['stdname'];
    $class = $_POST['stdclass'];

    $message = array();
    $query = "INSERT INTO `students` (`stdid`, `stdname`, `stdclass`) VALUES ('$id', '$name', '$class')";
    $result = $con->query($query);
    if ($result) {
        $message = array("status" => "true", "data" => "Registered successfully");
    } else {
        $message = array("status" => "false", "data" => $con->error);
    }
    echo json_encode($message);
}





if ($action) {
    $action($con);
} else {
    echo "Action is Required";
}
