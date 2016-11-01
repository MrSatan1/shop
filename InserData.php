<?php
include ('Helper.class.php');
include ('Student.class.php');
class Data{
	private $num;
	public function __construct($num=10)
	{
		$this->num=$num;
	}
	public function getStudent()
	{
		$arr=[];
		$student=new Student();
		for($i=0;$i<$this->num;$i++)
		{
			$arr[]=$student->getInfo();
		}
		return $arr;
	}
	public function getAllInfo()
	{
		$arr1=$this->getStudent();
		$arr2=$this->getAddress();
		$stuId=$this->getStuId();
		for($i=0;$i<$this->num;$i++)
		{
			$arr1[$i]['address']=$arr2['address'][$i];
			$arr1[$i]['school']=$arr2['school'][$i];
			$arr1[$i]['stu_id']=$stuId+1+$i;
		}
		return $arr1;
	}
	public function getAddress()
	{
		$num=$this->num;
		$helper=new Helper('novel');
		$sql="SELECT
				province.name as pname,
				city.name as cname,
				area.name as aname
			FROM
				province
			LEFT JOIN city ON province.`code` = city.provincecode
			LEFT JOIN area ON city.`code` = area.citycode
			ORDER BY
				RAND()
			LIMIT $num;
			";
		$dArr=[];
		 $arr= $helper->getAssoc($sql);
		 foreach ($arr as $key => $value) {
		 	  $str='';
		 	  foreach($value as $v)
		 	  {
		 	  	$str.=$v;
		 	  }
		 	 $dArr['address'][]=$str;
		 }
		 $schoolSql="SELECT
						school. NAME
					FROM
						school
					ORDER BY
						RAND()
					LIMIT $num;";
		$arr2=$helper->getAssoc($schoolSql);
		 foreach ($arr2 as $key => $value) {
		 	  $str='';
		 	  foreach($value as $v)
		 	  {
		 	  	$str.=$v;
		 	  }
		 	   $dArr['school'][]=$str;
		 }
		return $dArr;
	}
	function getStuId()
	{
		$helper=new Helper('train');
		$sql="select max(stu_id) as maxid from student_detail;";
		$arr=$helper->getRow($sql);
		if(isset($arr))
			return $arr[0][0];
	}



}
$d=new Data(100);
//$arr=$d->getStudent();
//echo "<pre>";
//print_r($arr);
//echo "</pre>";
//$arr=$d->getAddress();
//echo "<pre>";
//print_r($arr);
//echo "</pre>";
//echo $d->getStuId();

$arr2=$d->getAllInfo();
echo "<pre>";
print_r($arr2);
echo "</pre>";