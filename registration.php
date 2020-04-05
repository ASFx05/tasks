<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		
		<title>Задачи | Регитрация нового пользователя</title>
	</head>
	<body>
	    <?php
        	require('db.php');
            // If form submitted, insert values into the database.
            if (isset($_REQUEST['username'])){
        		$username = stripslashes($_REQUEST['username']); // removes backslashes
        		$username = mysqli_real_escape_string($con,$username); //escapes special characters in a string
        		$email = stripslashes($_REQUEST['email']);
        		$email = mysqli_real_escape_string($con,$email);
                if(mysqli_fetch_array(mysqli_query($con,"SELECT username FROM users WHERE username='$username'"))){ // проверка уникальности имени пользователя
                    echo "
                        <div class='container-fluid'>
                            <h1>Имя пользователя <b>".$username."</b> занято!</h1>
                            <a href=".$_SERVER['HTTP_REFERER']." class='btn btn-danger' role='button'>Назад</a>
                        </div>
                    ";
                }elseif(mysqli_fetch_array(mysqli_query($con,"SELECT email FROM users WHERE email='$email'"))){ // проверка уникальности email
                    echo "
                        <div class='container-fluid'>
                            <h1>Email <b>".$email."</b> занят!</h1>
                            <a href=".$_SERVER['HTTP_REFERER']." class='btn btn-danger' role='button'>Назад</a>
                        </div>
                    ";
                }else{ // если имя пользователя И email уникальны
            		$password = stripslashes($_REQUEST['password']);
            		$password = mysqli_real_escape_string($con,$password);
            		$trn_date = date("Y-m-d H:i:s");
                    $query = "INSERT into `users` (username, password, email, trn_date) VALUES ('$username', '".md5($password)."', '$email', '$trn_date')";
                    $result = mysqli_query($con,$query);
                    if($result){
                        echo "
                            <div class='container-fluid'>
                                <h1>Регистрация успешно завершена!</h1>
                                <a href='http://asf.h1n.ru/tasks.php' class='btn btn-success' role='button'>На главную</a>
                            </div>
                        ";
                    }
                }
            }else{
                ?>
        	    <div class="container-fluid" >
            	    <div class="form">
                        <h1>Регистрация</h1>
                        <form name="registration" action="" method="post">
                            <div class="form-group">
                                <label for="username">Имя пользователя:</label>
                                <input type="text" class="form-control" placeholder="Введите имя пользователя" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" placeholder="Введите email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Пароль:</label>
                                <input type="password" class="form-control" placeholder="Введите пароль" name="password" required>
                            </div>
                            <input class='btn btn-success' role='button' name='submit' type='submit' value='Зарегистрироваться'>
                        </form>
                    </div>
                </div>
                <?php
            }
        ?>
    </body>
</html>