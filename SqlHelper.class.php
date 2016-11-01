<?php
error_reporting(E_ALL ^ E_DEPRECATED);
header("Content-type:text/html;charset=utf-8");
class SqlHelper{
	private $host;//主机名
	private $user;// 用户名
	private $pwd;//密码
	private $charset;//字符集
	private $dbName;//数据库名
	private $link;//connect

	function __construct($dbName)
	{
		$this->host='localhost';
		$this->user='root';
		$this->pwd='root';
		$this->dbName=$dbName;
		$this->charset='utf8';

		$this->link=mysql_connect($this->host,$this->user,$this->pwd) or die("数据库连接失败".$this->error());
		$bool=mysql_select_db($this->dbName) or die("数据库操作失败".$this->error());
		mysql_set_charset($this->charset);
		if($bool)
		{
			echo "数据库连接到　$this->dbName 成功<br>";
		}
	}

//处理错误信息的方法
	private function  error()
	{
		if($this->link)
			return mysql_error($this->link);
		else 
			return mysql_error();
	}
//执行dql语句 select 
	private function exeDql($sql)
	{
		$res=mysql_query($sql) or die("执行 $sql 失败".$this->error());
		return $res;
	}
//获取关联数组，返回一个二维数组
	public function getAssoc($sql)
	{
		$arr=[];
		$res=$this->exeDql($sql);
		while($row=mysql_fetch_assoc($res))
		{
			$arr[]=$row;
		}
		mysql_free_result($res);
		return $arr;
	}
//获取索引数组，返回一个数组
    public function getRow($sql)
    {
    	$arr=[];
		$res=$this->exeDql($sql);
		while($row=mysql_fetch_row($res))
		{
			$arr[]=$row;
		}
		mysql_free_result($res);
		return $arr;
    }
 // 执型dml语句 insert update delete
 	public function exeDml($sql)
 	{
 		$res=mysql_query($sql) or die("执行 $sql 失败".$this->error());
 		$num=mysql_affected_rows();
 		if($num>0)
 			return $num;
 		elseif($num==-1)
 			return "执行 $sql 失败<br>";
 		elseif($num==0)
 			return "执型成功，但没有记录受到影响<br>";
 	}
 	public funtcion setDb($dbName)	
 	{
 		return $this->conn->select_db($dbName);
 	}
	public function __destruct()
	{
		echo "数据库连接关闭！<br>";
		mysql_close($this->link);
	}
}

$s=new SqlHelper('train');
//$sql="SELECT * FROM student_detail;";
$sql="DELETE FROM test1 WHERE id=16;";
// $arr=$s->getRow($sql);
$num=$s->exeDml($sql);
echo "<pre>";
print_r($num);
echo "</pre>";