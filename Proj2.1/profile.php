<?php
	session_start();
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
		$id = mysqli_real_escape_string($con,trim($_SESSION['seeID']));
		$sql = "SELECT * FROM users WHERE id='$id'";
		$result = mysqli_query($con,$sql);
		$row=mysqli_fetch_assoc($result);
			echo '<center>
			<p>
				<img width="200" height="100" src="'.$row["img"].'">
			</p>
			<p>
			login
			<input type="text" name="login" value="'.$row["login"].'" readonly>
			</p>
			<p>
			first name
			<input type="text" name="first_name" value="'.$row["fname"].'" readonly>
			</p>
			<p>
			last name
			<input type="text" name="last_name" value="'.$row["lname"].'" readonly>
			</p>
			<p>
			role
			<input type="text" name="role" value="'.$row["role"].'" readonly>
			</p>
			</center>';
			mysqli_close($con);
	}
?>
</body>
