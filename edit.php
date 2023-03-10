<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "todo_list";

// Connect to the sql database
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    $error_msg = "failed to connect to database" . $connection->connect_error;
}

$id = "";
$name = "";
$task = "";
$deadline = "";

$error_msg = "";
$sucess_msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    // show data to the client
    if (!isset ($_GET["id"]))
    {
        header ("LOCATION: ./index.php");
        exit;
    }

    // insert information into the database
    $id = $_GET["id"];
    $sql_query = "SELECT * FROM tasks WHERE id=$id;";
    $result = $connection->query($sql_query);
    $row = $result->fetch_assoc ();

    if (!$row) {
        header ("LOCATION: ./index.php");
        exit;
    }

    $name = $row["name"];
    $task = $row["task"];
    $deadline = $row["deadline"];
}
else
{
    $id = $_POST["id"];
    $name = $_POST["name"];
    $task = $_POST["task"];
    $deadline = $_POST["deadline"];

    if (empty($name) || empty($task)){
        $error_msg = "please fill all the required filed";
    }
    else{
        // transform deadline to correct DATETIME type value
        $deadline = empty($deadline)?"NULL":"'$deadline'";

        // insert information into the database
        $sql_query = "UPDATE tasks ".
                     "SET name = '$name', task= '$task', deadline = $deadline ".
                     "WHERE id='$id';";
        $result = $connection->query($sql_query);

        if (!$result) {
            $error_msg = "Invalid query" . $connection->error;
        }
        else
        {
            $sucess_msg = "Task updated successfully";
            header ("LOCATION: ./index.php");
            exit;
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>TODO list</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <body>
        <div class="container my-5">
            <h2>Create new task</h2>

            <?php
            if (!empty($error_msg)){
                echo "
                  <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
                    <strong>$error_msg</strong>
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                  </div>
                ";
            }
            else if (!empty($sucess_msg)){
                echo "
                  <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                    <strong>$sucess_msg</strong>
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                  </div>
                ";
            }
            ?>

            <form method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Name</label>
                    <div class="col sm-6">
                        <input type="text" name="name" value="<?php echo $name ?>" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Task</label>
                    <div class="col sm-6">
                        <input type="text" name="task" value="<?php echo $task ?>" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Deadline (optional)</label>
                    <div class="col sm-6">
                        <input type="text" name="deadline" value="<?php echo $deadline ?>" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="offset-sm-3 col-sm-3 d-grid">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <div class="col-sm-3 d-grid">
                        <a class="btn btn-outline-primary" href="./index.php" role="button">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </body>

</html>
