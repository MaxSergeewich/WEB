<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div>
		<?php
			$dbhost='localhost: 3306';
			$dbuser='root';
			$dbpwd='';
			$dbname='table';
			$con=mysqli_connect($dbhost,$dbuser,$dbpwd,$dbname);
			if($con){
				$sql="SELECT * FROM media";
				$datab=mysqli_query($con,$sql);
				while ($row=mysqli_fetch_assoc($datab)) {
					$type=$row['type'];
					echo "<div>";
					if ($type=="video") {
						echo "<video controls width=400>
							<source src=".$row['name']." type='video/mp4'/>
						</video>";
					}else if ($type=="audio") {
						echo "<audio controls width=400>
							<source src=".$row['name']." type='audio/mpeg'/>
						</audio>";
					}
					else if ($type=="youtube") {
						echo "<iframe src='".$row['name']."'></iframe>";
					}
					echo "</div>";
				}
			}
		?>
	</div>
</body>
</html>