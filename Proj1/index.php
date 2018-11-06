<?php
	session_start();
	if (isset($_POST['delete'])) {
		$dbhost='localhost: 3306';
		$dbuser='root';
		$dbpwd='';
		$dbname='table';
		$con=mysqli_connect($dbhost,$dbuser,$dbpwd,$dbname);
    	if($con){
			$sql="DELETE FROM users WHERE id = '".$_POST['delete']."'";
			mysqli_query($con,$sql);
			mysqli_close($con);
    	}
    	unlink('imgs/'.$_POST['delete'].'.img');
	}
	if (isset($_POST['edit'])) {
		$_SESSION['edit_id']=$_POST['edit'];
		header("location: change_info.php");
	}
	if (isset($_POST['profile'])) {
		$_SESSION['seeID']=$_POST['profile'];
		header("location: profile.php");
	}
	if (isset($_POST['exit'])){
		$_SESSION=array();
	}
	
	if (isset($_POST['log_in'])) {
		$password=trim($_POST['password']);
		$dbhost='localhost: 3306';
		$dbuser='root';
		$dbpwd='';
		$dbname='table';
		$con=mysqli_connect($dbhost,$dbuser,$dbpwd,$dbname);
    	if($con){
    		$login = mysqli_real_escape_string($con,trim($_POST['login']));
    		$password = mysqli_real_escape_string($con,trim($_POST['password']));
    		$sql = "SELECT login, id, role FROM users WHERE login='$login' AND pwd='$password'";
    		$result = mysqli_query($con,$sql);
    		$row=mysqli_fetch_assoc($result);
    		if (!mysqli_num_rows($result)) {
    			echo '<script type="text/javascript">
    				alert("Такого пользователя нет");
    			</script>';
    		}else{
    			$_SESSION['id']=$row['id'];
    			$_SESSION['role']=$row['role'];

    		}
		}
    	mysqli_close($con);
      	}
?>
<html>
<head>
	<title>fxhfdgh</title>
</head>
<body>
	<p>
		<?php
		if(!isset($_SESSION['id'])){
			?>
			<form action="" method="POST">
				login
				<input type="text" name="login" required>
				password
				<input type="password" name="password" required>
				<input type="submit" value="Войти" name="log_in">
				<p>
					<input type="button" value="Зарегистрироватся" onClick="location.href='register.php'">
				</p>
			</form>
			<?php
			}else {
				 ?>
				 <form action="" method="POST">
				 	<?php if (isset($_SESSION['id'])) {
				 		?>
				 		<input type="button" value="Зарегистрировать" onClick="location.href='register.php'">
				 		<?php
				 	}else{
				 		?>
				 		<input type="button" value="Редактировать профиль" onClick="location.href='change_info.php'">
				 		<?php
				 	}?>
				 <input type="submit" value="Выйти" name="exit">
				 </form>
				<?php
			}
		
		?>
	</p>
	<p>
	<table border="1">
		<?php
		$dbhost='localhost: 3306';
		$dbuser='root';
		$dbpwd='';
		$dbname='table';
		$con=mysqli_connect($dbhost,$dbuser,$dbpwd,$dbname);
		if($con){
			$sql="SELECT * FROM users";
			$datab=mysqli_query($con,$sql);
			$count=1;
			while($row=mysqli_fetch_assoc($datab)){
				echo "<tr >
						<th >
							
							".$count++."
						</th>
						<th>
							<a>".$row["login"]."</a>
						</th>
						<th>
							<a>".$row["fname"]."</a>
						</th>
						<th>
							<a>".$row["lname"]."</a>
						</th>
						<th>
							<a>".$row["role"]."</a>
						</th>
						<th>
							<img width='50' height='50'src=".$row["img"].">
						</th>
						<th>
						<form action='index.php' method='post'>
							<p><button name='profile' value='".$row["id"]."'>Просмотреть</button></p>
						";
				if (isset($_SESSION['role']) && !strcasecmp($_SESSION['role'], "admin")){
					echo "<p><button name='edit' value='".$row["id"]."'>Редактировать</button></p>
						<p><button name='delete' value='".$row["id"]."'>Удалить</button></p>";
				}
				echo "</form>
						</th>
						</tr>";
			}
		}
		mysqli_close($con);
		?>
	</table>
	</p>
</body>
</html>

<style type="text/css">
	th {
		padding:6;
	}
</style>
