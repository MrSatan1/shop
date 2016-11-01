<?php
class Phone
{
	private $arrHead;//手机号码前2位
	private $arrTail;//手机号码后9位

	function __construct()
	{
		$this->arrHead=array('13','14','15','17','18');
		$this->arrTail=range(0,9);
	}
	function getPhone()
	{
		$arr=array();
		for($i=0;$i<9;$i++)
		{
			// $arr[]=$this->arrTail[mt_rand(0,9)];
			 $arr[]=mt_rand(0,9);
		}
		$first=$this->arrHead[mt_rand(0,4)];
		$result=array_merge(array($first),$arr);
		$str=implode('', $result);
		return $str;
	}
}
