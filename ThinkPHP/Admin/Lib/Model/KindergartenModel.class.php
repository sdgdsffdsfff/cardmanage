<?php
	class KindergartenModel extends Model{
	
	protected $tableName = 'kindergarten';

	protected $_validate = array(

    array('name',array(1,2,3),'值的范围不正确！',2,'in'), 
    array('name','require','请填写正确幼儿园名称！')


);


	
	}
?>