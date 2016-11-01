<?php
	//对外的一个方法返回一个数组 随机的
	//身高 体重 性别 年龄 return array()
include ('ChineseName.class.php');
include ('Phone.class.php');

abstract class StuManage  
{
	protected abstract  function getGender();//随机性别
	protected  abstract function getHeight();//随机身高
	protected  abstract function getWeight();//随机体重
	protected  abstract function getAge();//随机年龄
	 abstract  function getInfo();//返回数组
}


header("Content-type:text/html;charset=utf-8");
class Student extends StuManage{
	private $height;
	private $weight;
	private $gender;//男，女
	private $age;
	private $sex;//0  男,1  女

	protected  function getGender()
	{
		$this->sex=mt_rand(0,1);
		if($this->sex==0)
			$this->gender='男';
		else
			$this->gender='女';
	}
	protected  function getHeight()
	{
		if($this->sex==0)
			$this->height=mt_rand(165,185);
		else
			$this->height=mt_rand(155,170);
	}
	protected  function getWeight()
	{
		if($this->sex==0)
			$this->weight=mt_rand(50,80);
		else
			$this->weight=mt_rand(40,55);
	}
	protected  function getAge()
	{
		 $this->age=mt_rand(20,35);
	}

	public function getHobby()
	{
		$hobby=['音乐','舞蹈','电影','旅游','演讲','阅读','运动'];
		shuffle($hobby);
		$arr=array_slice($hobby,mt_rand(0,6),7-mt_rand(0,6));
		$str=implode(',', $arr) ;
		return $str;

	}
	private function getMajor()
	{
		$majorArr=array('音乐表演','艺术设计','播音与主持艺术','数学与应用数学','信息与计算科学','应用物理学','分子科学与工程',
            '应用化学','生物科学与生物技术','生物信息学','地理信息科学与技术','海洋生物资源与环境','电子信息科学与技术','光电子技术科学',
            '材料物理','环境科学','心理学','统计学','石油工程','冶金工程','高分子材料加工工程','机械设计制造及其自动',
            '机械工程及自动化','机械电子工程','电子信息技术及仪器','电气工程及其自动化','通信工程','计算机科学与技术',
            '软件工程','网络工程','建筑学','水文与水资源工程','环境工程','交通设备信息工程','航空航天工程',
            '农业水利工程','木材科学与工程','应用生物科学','临床医学','医学实验学','护理学','工商管理','市场营销',
            '图书馆学');
		$num=count($majorArr)-1;
		return $majorArr[mt_rand(0,$num)];

	}
	private function getName()
	{
		$name=new ChineseName();
		return $name->getName();
	}
	private function getPhone()
	{
		$phone=new Phone();
		return $phone->getPhone();
	}
	
	public function getInfo()
	{
		$arr=[];
		$this->getGender();
		$this->getHeight();
		$this->getWeight();
		$this->getAge();
		$arr['gender']=$this->gender;
		$arr['height']=$this->height;
		$arr['weight']=$this->weight;
		$arr['age']=$this->age;
		$arr['hobby']=$this->getHobby();
		$arr['major']=$this->getMajor();
		$arr['name']=$this->getName();
		$arr['phone']=$this->getPhone();
		return $arr;
	}

}
// $s=new Student();
//
//
// for($i=0;$i<10;$i++)
// {
// 	$arr=$s->getInfo();
// 	echo "<pre>";
// 	print_r($arr);
// 	echo "</pre>";
// }
