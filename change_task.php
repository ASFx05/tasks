<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		
		<title>Задачи</title>
	</head>
	<body>
	    <div class="container-fluid" >
            <?php
                include("auth.php");
                if($_SESSION["username"]=="admin") {
                    include('db.php'); //Connecting to sql db.
                    $old = mysqli_fetch_array(mysqli_query($con,"
                        SELECT Task
                        FROM Tasks
                        WHERE TaskId = $_POST[TaskId]
                    "));
                    if ($old[0] != $_POST[changeTask]) {
                        mysqli_query($con,"
                            UPDATE Tasks
                            SET Task = '$_POST[changeTask]', Edited = 1
                            WHERE TaskId = $_POST[TaskId]
                        ");
                        echo "
                            <h1>Задача обновлена!</h1>
                            <a href=".$_SERVER['HTTP_REFERER']." class='btn btn-success' role='button'>Назад</a>
                        ";
                    }
                    else
                        echo "
                            <h1>Вы забыли изменить задачу...</h1>
                            <a href=".$_SERVER['HTTP_REFERER']." class='btn btn-warning' role='button'>Назад</a>
                        ";
                }
                else{
                    echo "
                        <h1>Изменять задачу может только <b>admin</b></h1>
                        <a href=".$_SERVER['HTTP_REFERER']." class='btn btn-danger' role='button'>Назад</a>
                    ";
                }
            ?>
            
        </div>
    </body>
</html>