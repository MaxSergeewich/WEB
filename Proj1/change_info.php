<?php
	session_start();
	if(isset($_POST['edit'])){
	$dbhost='localhost: 3306';
	$dbuser='root';
	$dbpwd='';
	$dbname='table';
	$con=mysqli_connect($dbhost,$dbuser,$dbpwd,$dbname);
	if($con){
		$id;
		if (isset($_SESSION['edit_id'])) {
			$id = mysqli_real_escape_string($con,trim($_SESSION['edit_id']));
		}else
			$id = mysqli_real_escape_string($con,trim($_SESSION['id']));
		$sql = "SELECT * FROM users WHERE id='$id'";
		$result = mysqli_query($con,$sql);
		$row=mysqli_fetch_assoc($result);

		$new_login=$_POST['login'];
		$fname=$_POST['first_name'];
		$lname=$_POST['last_name'];
		$password=$_POST['password'];
		$name_img;
		$role=$row['role'];
		if (isset($_POST['role'])&& (strlen($_POST['role'])!=0)) {
			$role=$_POST['role'];
		}
		if (strlen($new_login)==0) {
			$new_login=$row['login'];
		}
		if (strlen($fname)==0) {
			$fname=$row['fname'];
		}
		if (strlen($lname)==0) {
			$lname=$row['lname'];
		}
		if (strlen($password)==0) {
			$password=$row['pwd'];
		}
		if ($_FILES && $_FILES['image']['error']== UPLOAD_ERR_OK){
        		$name_img = 'imgs/'.$row['id'].'.img';
        		move_uploaded_file($_FILES['image']['tmp_name'], $name_img);
        }else
        	$name_img=$row['img'];
		$sql = "UPDATE users SET login='$new_login', fname='$fname', lname='$lname', pwd='$password', img='$name_img',role='$role' WHERE id='$id'";
		if(!mysqli_query($con,$sql))
		echo '<script type="text/javascript">alert("Error");</script>';
		mysqli_close($con);
	}
}
?>
<html>
<head>

	<title></title>
</head>
<body>
	<a href="index.php">На главную</a>
	<?php
	$dbhost='localhost: 3306';
	$dbuser='root';
	$dbpwd='';
	$dbname='table';
	$con=mysqli_connect($dbhost,$dbuser,$dbpwd,$dbname);
	if($con){
		$id;
		if (isset($_SESSION['edit_id'])) {
			$id = mysqli_real_escape_string($con,trim($_SESSION['edit_id']));
		}else
			$id = mysqli_real_escape_string($con,trim($_SESSION['id']));
		$sql = "SELECT * FROM users WHERE id='$id'";
		$result = mysqli_query($con,$sql);
		$row=mysqli_fetch_assoc($result);
			echo '<center>
			<form action="change_info.php" method="POST" enctype="multipart/form-data">
			<p>
				<img width="200" height="100" src="'.$row["img"].'">
			</p>
			<p>
				<input type="file" name="image">
			</p>
			<p>
			login
			<input type="text" name="login" value="'.$row["login"].'">
			</p>
			<p>
			first name
			<input type="text" name="first_name" value="'.$row["fname"].'">
			</p>
			<p>
			last name
			<input type="text" name="last_name" value="'.$row["lname"].'">
			</p>
			<p>
			change password
			<input type="password" name="password">
			</p>';
			if (isset($_SESSION['role']) && !strcasecmp($_SESSION['role'], "admin")) {
				echo "<p>
					change role
					<input type='text' name='role' value='".$row["role"]."'>
					</p>";
			}
			echo '<p>
			<input type="submit" value="Редактировать профиль" name="edit">
			</p>
			</form>
			</center>';
			mysqli_close($con);
	}
?>
</body>
