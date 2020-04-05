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
                session_start();
                session_destroy();
            ?>
            
            <h1>Авторизация прекращена!</h1>
            <a href=<?php echo $_SERVER['HTTP_REFERER'] ?> class="btn btn-warning" role="button">Назад</a>
        </div>
    </body>
</html>