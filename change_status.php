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
                    $sum = $_POST['hiddenCheckbox'] + $_POST['statusCheckbox'];
                    include('db.php'); //Connecting to sql db.
                    //Sending form data to sql db.
                    mysqli_query($con,"
                        UPDATE Tasks
                        SET Status = $sum
                        WHERE TaskId = $_POST[TaskId]
                    ");
                    echo "
                        <h1>Статус изменён!</h1>
                        <a href=".$_SERVER['HTTP_REFERER']." class='btn btn-success' role='button'>Назад</a>
                    ";
                }
                else {
                    echo "
                        <h1>Изменять статус может только <b>admin</b></h1>
                        <a href=".$_SERVER['HTTP_REFERER']." class='btn btn-danger' role='button'>Назад</a>
                    ";
                }
            ?>
        </div>
    </body>
</html>