<?php
//数据库查询语言 DQL SELECT
//数据库的操作语言 DML
//SET AUTOCOMMIT ON;
//1. INSERT 2.UPDATE 3.DELETE
//COMMIT;
//数据库的定义语言 DDL
// CREATE TABLE/VIEW/INDEX/SYN/CLUSTER
// 数据库的控制语言 DCL
// DCL用来授予或者回收访问数据库的某种权限，并控制数据库操作事务的时间和效果，对数据库实施监督
// GRAND
// ROLLBACK
header("Content-type:text/html;charset=utf-8");
	class Helper{
		private $conn;
		private $host='localhost';
		private $username='root';
		private $password='root';
		private $dbName;
		private $charset='utf8';
		private $pageSize;//每页显示的记录数
		private $pageArr=array();

		public function __construct($dbName)
		{
			$this->dbName=$dbName;
			$this->conn=new mysqli($this->host,$this->username,$this->password,$this->dbName);
			if($this->conn->connect_error) 
			{
				die ("数据库连接失败!".$this->conn->connect_error);
			}
			else
			{
				// echo "连接数据库 $dbName 成功<br>";
				$this->conn->set_charset($this->charset);
			}
		}

		private function exeDql($sql)
		{
			$res=$this->conn->query($sql) or die ("执行 $sql 错误".$this->conn->error);
			return $res;
		}
		public function getAssoc($sql)
		{
			$arr=array();
			$res=$this->exeDql($sql);
			while($row=$res->fetch_assoc())
			{
				$arr[]=$row;
			}
			$res->free();
			return $arr;
		}
        public function getRow($sql)
        {
        	$arr=array();
			$res=$this->exeDql($sql);
			while($row=$res->fetch_row())
			{
				$arr[]=$row;
			}
			$res->free();
			return $arr;
        }
        //执行dml语句  
        public function exeDml($sql)
        {
        	$res=$this->conn->query($sql);
        	$num=$this->conn->affected_rows;
        	if($num>0)
        		return $num."条记录受到影响";
        	elseif($num==0)
        		return "执行成功，但没有记录受到影响<br>";
        	else
        		return "执行失败". $this->conn->error." <br>";
        }
//获取数据的总记录数和页数
/**
 * [getPageArray description]
 * @param  [type]  $sql      [sql语句]
 * @param  integer $pageSize [每页显示记录数]
 * @return [type]            [分页数组]
 */
      public  function getPageArray($sql,$pageSize=5)
        {
        	$this->pageSize=$pageSize;
        	$pageArr=array();
        	$arr=$this->getRow($sql);
        	if($arr)
        	{
        		$records=count($arr);//总记录数
        		$pages=ceil($records/$pageSize);
        		$pageArr['records']=$records;
        		$pageArr['pages']=$pages;
        	}
        	$this->pageArr=$pageArr;
        	return $pageArr;

        }
//分页显示语句
        public function getLimitAssoc($sql,$curPage=1)
        {
        	$sql=rtrim($sql,";");
        	$pageSize=$this->pageSize;
        	$start=($curPage-1)*$pageSize;//limit起点位置
        	$sql.=" LIMIT $start,$pageSize";
        	return $this->getAssoc($sql);
        }
    //分页设置
    public function setPageParam($curPage,$url)
    {
    	//1-10  (1-1)*10+1 
    	//11-20 (2-1)*10+1
    	//21-30 (3-1)*10+1
    	$pages=$this->pageArr['pages'];
    	$curPage<$pages?$nextPage=$curPage+1:$nextPage=$pages;
    	$curPage>1?$prePage=$curPage-1:$prePage=$curPage;
    	$start=floor(($curPage-1)/10)*10+1;//页码显示起点
    	$first=$start-1;
    	$first>0?$first=$start-1:$first=1;
    	$temp=$start;//临时存储start值
    	$end=$temp+9;//页码显示的终点
    	$last=$end+1;
    	$end<$pages?$end=$temp+9:$end=$pages;
    	$last<$pages?$last=$end+1:$last=$pages;
    	$str="
			<nav>
			  <ul class='pagination'>
			    <li>
			      <a href='{$url}?page=1' aria-label='Previous'>
			        <span aria-hidden='true'>&laquo;</span>
			      </a>
			    </li>
			    <li><a href='{$url}?page={$first}'><</a></li>";
		if($pages>10)
		{
			for(;$start<=$end;$start++)
			{
				if($start==$curPage)
					$str.="<li class='active'><a href='{$url}?page={$start}'>{$start}</a></li>";
				else
					$str.="<li><a href='{$url}?page={$start}'>{$start}</a></li>";
			}
		}
		else
		{
			for($i=1;$i<$pages;$i++)
			if($start==$curPage)
				$str.="<li class='active'><a href='{$url}?page={$i}'>{$i}</a></li>";
			else
				$str.="<li><a href='{$url}?page={$i}'>{$i}</a></li>";	
		}



		$str.="
				<li><a href='{$url}?page={$last}'>></a></li>
				<li>
			      <a href='{$url}?page={$pages}' aria-label=''>
			        <span aria-hidden='true'>&raquo;</span>
			      </a>
			    </li>
			  </ul>
			</nav>
    	";

    	return $str;

    }
        public function setDb($dbName)
	 	{
	 		return $this->conn->select_db($dbName) or die ($this->conn->error);
	 	}

		public function __destruct()
		{
			// echo "数据库关闭！<br>";
			$this->conn->close();
		}

	}




// $sql="UPDATE test1 SET test.stu_gender='男' WHERE id=12;";
// echo $s->exeDml($sql);
// $sql="SELECT * FROM test;";
// $arr=$s->getRow($sql);
// $s->setDb('novel');





// echo "<table border='1' cellspacing='0' cellpadding='5' width='90%'>";
// foreach ($arr as $key => $value) {
// 	echo "<tr>";
// 		foreach ($value as  $v) {
// 			echo "<td>$v</td>";
// 		}
// 	echo "</tr>";
// }

// echo "</table>";
?>


