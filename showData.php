<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>数据展示页面</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="bootstrap/js/jquery-3.0.0.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
<style>
	.info{
		font-size:10px;
	}
</style>
</head>
<?php
include_once "Helper.class.php";
$s=new Helper('train');

isset($_GET['page'])?$page=$_GET['page']:$page=1;
$s->setDb('novel');
$sql="select * from stu;";
$s->getPageArray($sql,10);
$arr=$s->getLimitAssoc($sql,$page);
$str=$s->setPageParam($page,"showData.php");
// echo "<pre>";
// print_r($arr);
// echo "</pre>";
?>

<body>
<div class="container-fluid">
	
  <div class="row">
  
  	<div class="col-md-12">
  	<table class="table table-striped table-bordered">
		<?
		while(list(,$stuArr)=each($arr))
		{
			echo "<tr>";
			echo "<td>".$stuArr['name']."</td>";
			echo "<td>".$stuArr['gender']."</td>";
			echo "<td>".$stuArr['height']."</td>";
			echo "<td>".$stuArr['weight']."</td>";
			echo "<td>".$stuArr['age']."</td>";
			echo "<td>".$stuArr['hobby']."</td>";
			echo "<td>".$stuArr['major']."</td>";
			echo "<td>".$stuArr['phone']."</td>";
			echo "<td>".$stuArr['address']."</td>";
			echo "<td>".$stuArr['id']."</td>";
			echo "<td>".$stuArr['school']."</td>";

			echo "</tr>";

		}
		?>
		</table>
		<?=$str;?>
  	</div>
  	
	</div>
</div>

</body>
</html>
