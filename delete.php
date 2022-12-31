<?php
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    echo $id;

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "todo_list";

    // Connect to the sql database
    $connection = new mysqli($servername, $username, $password, $database);

    $sql_query = "DELETE FROM tasks WHERE id=$id;";
    $connection->query($sql_query);
}

header("LOCATION: ./index.php");
exit();
?>
