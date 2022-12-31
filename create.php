<?php
$name = "";
$task = "";
$deadline = "";

$error_msg = "";
$sucess_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $task = $_POST["task"];
    $deadline = $_POST["deadline"];

    if (empty($name) || empty($task)) {
        $error_msg = "please fill all the required filed";
    } else {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "todo_list";

        // Connect to the sql database
        $connection = new mysqli($servername, $username, $password, $database);

        if ($connection->connect_error) {
            $error_msg =
                "failed to connect to database" . $connection->connect_error;
        }

        // transform deadline to correct DATETIME type value
        $deadline = empty($deadline) ? "NULL" : "'$deadline'";

        // insert information into the database
        $sql_query =
            "INSERT INTO tasks (name,task,deadline)" .
            "VALUES" .
            "('$name', '$task', $deadline);";
        $result = $connection->query($sql_query);

        if (!$result) {
            $error_msg = "Invalid query" . $connection->error;
        } else {
            $name = "";
            $task = "";
            $deadline = "";

            $sucess_msg = "Task added successfully";
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

            <?php if (!empty($error_msg)) {
                echo "
                  <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
                    <strong>$error_msg</strong>
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                  </div>
                ";
            } elseif (!empty($sucess_msg)) {
                echo "
                  <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                    <strong>$sucess_msg</strong>
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                  </div>
                ";
            } ?>

            <form method="post">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Name</label>
                    <div class="col sm-6">
                        <input type="text" name="name" value="<?php echo $name; ?>" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Task</label>
                    <div class="col sm-6">
                        <input type="text" name="task" value="<?php echo $task; ?>" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Deadline (optional)</label>
                    <div class="col sm-6">
                        <input type="text" name="deadline" value="<?php echo $deadline; ?>" class="form-control">
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
