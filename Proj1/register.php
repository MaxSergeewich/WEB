<?php
	session_start();

	if (isset($_POST['register'])) {
		$password=trim($_POST['password1']);
    	$repeatpassword=trim($_POST['password2']);

    	if($password==$repeatpassword){
    		if ($_FILES && $_FILES['image']['error']== UPLOAD_ERR_OK){
        		
        		$dbhost='localhost: 3306';
				$dbuser='root';
				$dbpwd='';
				$dbname='table';
				$con=mysqli_connect($dbhost,$dbuser,$dbpwd,$dbname);
				
				$sql="SELECT * FROM users";
				$datab=mysqli_query($con,$sql);
				$user_contains=FALSE;
				while($row=mysqli_fetch_assoc($datab)){
					if (!strcasecmp($_POST['login'], $row['login'])) {
						echo '<script type="text/javascript">
    						alert("Пользователь с таким логином уже существует");
    						</script>';
    						$user_contains=TRUE;
    						mysqli_close($con);
					}
				}
				if(!$user_contains)
				if($con){
					$role;
					if (isset($_SESSION['role']) && !strcasecmp($_SESSION['role'], "admin")) {
						$role=$_POST['role'];
					}else $role="user";
					$sql = "INSERT INTO users (login, pwd, fname, lname, role) VALUES ('".$_POST['login']."','". $_POST['password1']."','". $_POST['fname']."','".$_POST['lname']."','".$role."')";
					if(mysqli_query($con,$sql)){
					//картинка
					$sql = "SELECT * FROM users WHERE login='".$_POST['login']."'";
					$row=mysqli_fetch_assoc(mysqli_query($con,$sql));
					$name_img = 'imgs/'.$row['id'].'.img';
        			move_uploaded_file($_FILES['image']['tmp_name'], $name_img);
        			$sql="UPDATE users SET img='$name_img' WHERE login='".$_POST['login']."'";
        			mysqli_query($con,$sql);

					mysqli_close($con);
					header("location: index.php");
					}else
						echo '<script type="text/javascript">
    						alert("ERROR db");
    						</script>';
				}else{
					echo '<script type="text/javascript">
    				alert("Не удалось соединится с бд");
    			</script>';				
    			}
    		}
    	}else{
    			?>
    			<script type="text/javascript">
    				alert("Пароли не совпадают")
    			</script>
    			<?php
    		}
	}
?>
<html>
<head>
	<title></title>
</head>
<body>
	<p>
		<center>
			<form action="register.php" method="post" enctype='multipart/form-data' id ="change">
				<p>
					login
					<input type="text" name="login" required>
				</p>
				<p>
					password
					<input type="password" name="password1" required>
				</p>
				<p>
					repeat password
					<input type="password" name="password2" required>
				</p>
				<p>
					first name
					<input type="text" name="fname" required>
				</p>
				<p>
					last name
					<input type="text" name="lname" required>
				</p>
				<?php
					if (isset($_SESSION['role']) && !strcasecmp($_SESSION['role'], "admin")) {
						echo "<p>role
								<input type='text' name='role' required>
								</p>";
					}
				?>
				<p>
					Image
					<input type="file" name="image" required>
				</p>
				<p>
					
					<input type="submit" value="Регистрация" name="register">
					<input type="button" name="back" value="Выйти" onclick="location.href='index.php' ">
				</p>

			</form>
		</center>
	</p>
</body>
