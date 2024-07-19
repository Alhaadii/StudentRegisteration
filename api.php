<?php
header("Content-type:application/json");
include('./conn.php');


$action = $_POST["action"];

function readAll($connection)
{
    $data = array();
    $message = array();

    $query = "SELECT * FROM `student`";
    $result = $connection->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $message = array("status" => "true", "data" => $data);
    } else {
        $message = array("status" => "false", "data" => "haa waxaa jira qalad");
    }
    echo json_encode($message);
}
function readStudentInfo($connection)
{
    $data = array();
    $message = array();
    $id = $_POST["id"];


    $query = "SELECT * FROM student WHERE stdid ='$id'";
    $result = $connection->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $message = array("status" => "true", "data" => $data);
    } else {
        $message = array("status" => "false", "data" => "haa waxaa jira qalad");
    }
    echo json_encode($message);
}

function create($connection)
{
    $stdid = $_POST["id"];
    $stdname = $_POST["name"];
    $stdclass = $_POST["class"];

    $message = array();

    $sql = "INSERT INTO student VALUES($stdid, '$stdname', '$stdclass')";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        $message = array("status" => "true", "data" => "Registered successfully");
    } else {
        $message = array("status" => "false", "data" => "Error: " . $connection->error);
    }
    echo json_encode($message);
}
function updateStd($connection)
{
    $stdid = $_POST["id"];
    $stdname = $_POST["name"];
    $stdclass = $_POST["class"];

    $message = array();

    $sql = "UPDATE student SET stdname='$stdname', stdclass='$stdclass' WHERE stdid='$stdid'";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        $message = array("status" => "true", "data" => "Updated successfully");
    } else {
        $message = array("status" => "false", "data" => "Error: " . $connection->error);
    }
    echo json_encode($message);
}


function deleteStd($connection)
{
    $stdid = $_POST["id"];


    $message = array();

    $sql = "DELETE FROM student WHERE stdid='$stdid'";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        $message = array("status" => "true", "data" => "Deleted successfully");
    } else {
        $message = array("status" => "false", "data" => "Error: " . $connection->error);
    }
    echo json_encode($message);
}




if (isset($action)) {
    $action($connection);
} else {
    echo "Error: " . $connection->error;
}
