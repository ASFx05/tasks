<?php
    include("auth.php"); //include auth.php file on all secure pages
    include('db.php'); //подключение к БД в $con
?>
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
		<div class="container-fluid">
			<div class="d-flex p-1 flex-row justify-content-between">
				<button class="btn btn-primary" data-toggle="collapse" data-target="#addTask">Добавить задачу</button>
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Авторизация</button>
				
				
				
                <!-- The Modal -->
                <div class="modal fade" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Авторизация</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                        
                            <!-- Modal body -->
                            <div class="modal-body">
                                <?php
                                    echo "Вы вошли как <b>";
                                    if($_SESSION["username"]=="guest")
                                        echo "Гость</b>.";
                                    else
                                        echo $_SESSION["username"]."</b>.";
                                    if($_SESSION["username"]=="guest"){
                                        // If form submitted, insert values into the database.
                                        if (isset($_POST['username'])){
                                    		
                                    		$username = stripslashes($_REQUEST['username']); // removes backslashes
                                    		$username = mysqli_real_escape_string($con,$username); //escapes special characters in a string
                                    		$password = stripslashes($_REQUEST['password']);
                                    		$password = mysqli_real_escape_string($con,$password);
                                    		
                                    	    //Checking is user existing in the database or not
                                            $query = "SELECT * FROM `users` WHERE username='$username' and password='".md5($password)."'";
                                    		$result = mysqli_query($con,$query) or die(mysql_error());
                                    		$rows = mysqli_num_rows($result);
                                            if($rows==1){
                                    			$_SESSION['username'] = $username;
                                    			header("Location: logged_in.php"); // Redirect user to index.php
                                            }else{
                                    			header("Location: login_fail.php");;
                                    		}
                                        }else{
                                            echo "
                                                <br>Для входа под своим именем введите данные ниже:<br><br>
                                                <div class='form'>
                                                    <form action='' method='post' name='login'>
                                                        <input type='text' class='form-control' name='username' placeholder='Имя пользователя' required><br>
                                                        <input type='password' class='form-control' name='password' placeholder='Пароль' required><br>
                                                        <input class='btn btn-success' role='button' name='submit' type='submit' value='Войти'>
                                                    </form>
                                                    <br>Ещё не зарегистрированы? <a href='registration.php'>Зарегистрироваться</a>
                                                </div>
                                            ";
                                        }
                    
                                    }else{
                                        echo "<br><a href='logout.php' class='btn btn-warning' role='button'>Выйти</a>";
                                    }
                                ?>
                            </div>
                        
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Отмена</button>
                            </div>
                        
                        </div>
                    </div>
                </div>
				
				
				
			</div>
			<form id="addTask" class="collapse" action="add_task.php" method="post">
                <div class="form-group">
                    <label for="add_name">Имя пользователя:</label>
                    <input type="text" class="form-control" placeholder="Введите имя пользователя" id="add_name" name="add_name" required>
                </div>
                <div class="form-group">
                    <label for="add_email">E-mail:</label>
                    <input type="email" class="form-control" placeholder="Введите e-mail" id="add_email" name="add_email" required>
                </div>
                <div class="form-group">
                    <label for="add_task">Задача:</label>
                    <textarea class="form-control" rows="3" placeholder="Введите задачу" id="add_task" name="add_task" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">Сохранить</button>
                <button type="reset" class="btn btn-danger">Отменить</button>
            </form>
            <br>
            <table class="table table-bordered">
        			<?php
                        if (isset($_GET['page_no']) && $_GET['page_no']!="") {
                        	$page_no = $_GET['page_no'];
                        } else {
                        	$page_no = 1;
                        }
                        if (isset($_GET['sort_by']) && ($_GET['sort_by']=="TaskId" || $_GET['sort_by']=="User" || $_GET['sort_by']=="email" || $_GET['sort_by']=="Status")) {
                        	$sort_by = $_GET['sort_by'];
                        } else {
                        	$sort_by = "TaskId";
                        }
                        if (isset($_GET['order']) && ($_GET['order']=="ASC" || $_GET['order']=="DESC")) {
                        	$order = $_GET['order'];
                        } else {
                        	$order = "ASC";
                        }
                        echo "
                            <thead>
                                <tr>
                        		    <th style='width: 10%'><a href='?sort_by=TaskId&order=";
                        		            if ($order == "ASC") {
                        		                echo "DESC";
                        		            }
                        		            elseif ($order == "DESC")
                        		                echo "ASC";
                        		            echo "&page_no=$page_no'>№";
                        		        if ($sort_by == "TaskId" && $order == "ASC") {
                        		            echo " ▲";
                        		        }
                        		        elseif ($sort_by == "TaskId" && $order == "DESC")
                        		            echo " ▼";
                        		        echo "</a></th>
                        			<th style='width: 20%'><a href='?sort_by=User&order=";
                        		            if ($order == "ASC") {
                        		                echo "DESC";
                        		            }
                        		            elseif ($order == "DESC")
                        		                echo "ASC";
                        		            echo "&page_no=$page_no'>Имя пользователя";
                        			    if ($sort_by == "User" && $order == "ASC") {
                        		            echo " ▲";
                        		        }
                        		        elseif ($sort_by == "User" && $order == "DESC")
                        		            echo " ▼";
                        			    echo "</th>
                        			<th style='width: 20%'><a href='?sort_by=email&order=";
                        		            if ($order == "ASC") {
                        		                echo "DESC";
                        		            }
                        		            elseif ($order == "DESC")
                        		                echo "ASC";
                        		            echo "&page_no=$page_no'>e-mail";
                        			    if ($sort_by == "email" && $order == "ASC") {
                        		            echo " ▲";
                        		        }
                        		        elseif ($sort_by == "email" && $order == "DESC")
                        		            echo " ▼";
                        			    echo "</th>
                        			<th style='width: 40%'>Задача</th>
                        			<th style='width: 10%'><a href='?sort_by=Status&order=";
                        		            if ($order == "ASC") {
                        		                echo "DESC";
                        		            }
                        		            elseif ($order == "DESC")
                        		                echo "ASC";
                        		            echo "&page_no=$page_no'>Статус";
                        			    if ($sort_by == "Status" && $order == "ASC") {
                        		            echo " ▲";
                        		        }
                        		        elseif ($sort_by == "Status" && $order == "DESC")
                        		            echo " ▼";
                        			    echo "</th>
                        		</tr>
                        	</thead>
                        	<tbody>
                        ";

                    	$total_records_per_page = 3;
                        $offset = ($page_no-1) * $total_records_per_page;
                    	$previous_page = $page_no - 1;
                    	$next_page = $page_no + 1;
                    	$adjacents = "2";

                    	$result_count = mysqli_query($con,"SELECT COUNT(*) As total_records FROM `Tasks`");
                    	$total_records = mysqli_fetch_array($result_count);
                    	$total_records = $total_records['total_records'];
                        $total_no_of_pages = ceil($total_records / $total_records_per_page);
                    	$second_last = $total_no_of_pages - 1; // total page minus 1

                        $result = mysqli_query($con,"SELECT * FROM `Tasks` ORDER BY $sort_by $order LIMIT $offset, $total_records_per_page");
                        while($row = mysqli_fetch_array($result)){
                    		echo "
                    		    <tr class='".$row['TaskId']."'>
                    		        <td class='TaskId ".$row['TaskId']."'>".$row['TaskId']."</td>
                        			<td class='User ".$row['TaskId']."'>".$row['User']."</td>
                        			<td class='email ".$row['TaskId']."'>".$row['email']."</td>
                        	 		<td class='Task ".$row['TaskId']."'>
                        	 		    <form class='form-inline' action='change_task.php' method='post'>";
                        	 		        if($_SESSION["username"]=="admin")
                        	 		            echo "
                        	 		                <button type='submit' class='btn btn-warning btn-sm mr-2 mb-2'>🖉</button>
                        	 		                <input type='hidden' name='TaskId' value='".$row['TaskId']."'>
                        	 		                <input type='checkbox' name='hiddenCheckbox' value='0' checked hidden>
                        	 		            ";
                                	 		if ($row['Edited'])
                                        		echo "<span class='badge badge-info mb-2'>Изменено администратором</span>";
                                	 		echo "<textarea class='form-control' rows='3' placeholder='Введите задачу' name='changeTask' style='min-width: 100%' ";
                            	 		    if($_SESSION["username"]=="admin")
                            	 		        echo "required>";
                            	 		    else
                            	 		        echo "readonly>";
                            	 		    echo $row['Task']."</textarea>
                        	 		    </form>
                        	 		</td>
                        		   	<td class='Status ".$row['TaskId']."'>
                            		   	<form action='change_status.php' method='post'>";
                            		   	    if($_SESSION["username"]=="admin")
                            		   	        echo "<button type='submit' class='btn btn-warning btn-sm mr-2 mb-2'>🖉</button>";
                            		   	    echo "
                                			<div class='form-check'>
                                				<label class='form-check-label'>";
                                				    if($_SESSION["username"]=="admin") {
                                				        echo "
                                    				        <input type='hidden' name='TaskId' value='".$row['TaskId']."'>
                                        				    <input type='checkbox' name='hiddenCheckbox' value='0' checked hidden>
                                        					<input type='checkbox' class='form-check-input' value='1' name='statusCheckbox'
                                				        ";
                                						if ($row['Status'])
                                						    echo " checked>";
                                						else
                                						    echo ">";
                                				    }
                                					echo "<span class='badge badge-";
                                					if ($row['Status'])
                                					    echo "success'>Выполнено";
                                					if (!$row['Status'])
                                					    echo "danger'>Не выполнено";
                                					echo "</span>
                                				</label>
                                			</div>
                                		</form>
                            		</td>
                    		    </tr>
                    		";
                        }
                        mysqli_close($con);
                    ?>
    			</tbody>
            </table>
			
            <ul class="pagination justify-content-center" style="margin:20px 0">
            	<li class='page-item <?php if($page_no <= 1){ echo "disabled"; } ?>'>
            	    <a class='page-link' <?php if($page_no > 1){ echo "href='?sort_by=$sort_by&order=$order&page_no=$previous_page'"; } ?>>Предыдущая</a>
            	</li>
                <?php 
                	if ($total_no_of_pages <= 10){
                		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                			if ($counter == $page_no) {
                		        echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                			}else{
                                echo "<li class='page-item'><a class='page-link' href='?sort_by=$sort_by&order=$order&page_no=$counter'>$counter</a></li>";
                			}
                        }
                	}
                	elseif($total_no_of_pages > 10){
                    	if($page_no <= 4) {
                    	    for ($counter = 1; $counter < 8; $counter++){
                    			if ($counter == $page_no) {
                    		        echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                    			}else{
                                    echo "<li class='page-item'><a class='page-link' href='?sort_by=$sort_by&order=$order&page_no=$counter'>$counter</a></li>";
                    			}
                            }
                    		echo "<li class='page-item'><a class='page-link'>...</a></li>";
                    		echo "<li class='page-item'><a class='page-link' href='?sort_by=$sort_by&order=$order&page_no=$second_last'>$second_last</a></li>";
                    		echo "<li class='page-item'><a class='page-link' href='?sort_by=$sort_by&order=$order&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                    	}
                    	elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {
                    		echo "<li class='page-item'><a class='page-link' href='?sort_by=$sort_by&order=$order&page_no=1'>1</a></li>";
                    		echo "<li class='page-item'><a class='page-link' href='?sort_by=$sort_by&order=$order&page_no=2'>2</a></li>";
                            echo "<li class='page-item'><a class='page-link'>...</a></li>";
                            for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                                if ($counter == $page_no) {
                    		        echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                    			}else{
                                    echo "<li class='page-item'><a class='page-link' href='?sort_by=$sort_by&order=$order&page_no=$counter'>$counter</a></li>";
                    			}
                            }
                            echo "<li class='page-item'><a class='page-link'>...</a></li>";
                    	    echo "<li class='page-item'><a class='page-link' href='?sort_by=$sort_by&order=$order&page_no=$second_last'>$second_last</a></li>";
                    	    echo "<li class='page-item'><a class='page-link' href='?sort_by=$sort_by&order=$order&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                        }
                    	else {
                            echo "<li class='page-item'><a class='page-link' href='?sort_by=$sort_by&order=$order&page_no=1'>1</a></li>";
                    		echo "<li class='page-item'><a class='page-link' href='?sort_by=$sort_by&order=$order&page_no=2'>2</a></li>";
                            echo "<li class='page-item'><a class='page-link'>...</a></li>";
                            for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                if ($counter == $page_no) {
                    		        echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                    			}else{
                                    echo "<li class='page-item'><a class='page-link' href='?sort_by=$sort_by&order=$order&page_no=$counter'>$counter</a></li>";
                    			}
                            }
                        }
                	}
                ?>
            	<li class='page-item <?php if($page_no >= $total_no_of_pages){ echo "disabled"; } ?>'>
            	<a class='page-link' <?php if($page_no < $total_no_of_pages) { echo "href='?sort_by=$sort_by&order=$order&page_no=$next_page'"; } ?>>Следующая</a>
            	</li>
            </ul>
			
		</div>
		
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		
	</body>
</html>