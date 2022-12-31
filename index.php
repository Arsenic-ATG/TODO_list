<!DOCTYPE html>
<html lang="en">

<head>
    <title>TODO list</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5">
        <h1>List of entries</h1>
        <a class="btn btn-primary" href="/crud/create.php" role="button">new entry</a>
        <br>
        <table class="table" summary="table of all the tasks in todo list">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>task</th>
                    <th>deadline</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "todo_list";

                // Connect to the sql database
                $connection = new mysqli($servername, $username, $password, $database);

                if ($connection->connect_error) {
                    die("failed to connect to database" . $connection->connect_error);
                }

                // Read the entire database
                $sql_query = "SELECT * FROM tasks";
                $result = $connection->query($sql_query);

                if (!$result) {
                    die("invalid query : " . $sql_query);
                }

                // Write the content on webpage
                while ($curr_row = $result->fetch_assoc()) {
                    echo "
                       <tr>
                           <td>$curr_row[name]</td>
                           <td>$curr_row[task]</td>
                           <td>$curr_row[deadline]</td>
                           <td>
                               <a class='btn btn-primary btn-sm' href='/crud/edit.php?id=$curr_row[id]'>Edit</a>
                               <a class='btn btn-danger btn-sm' href='/crud/delete.php?id=$curr_row[id]'>Delete</a>
                           </td>
                       </tr>
                    ";
                }


                ?>

            </tbody>
        </table>
    </div>
</body>

</html>
