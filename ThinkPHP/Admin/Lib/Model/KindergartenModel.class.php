<?php
	class KindergartenModel extends Model{
	
	protected $tableName = 'kindergarten';

	protected $_validate = array(

    array('name',array(1,2,3),'ֵ�ķ�Χ����ȷ��',2,'in'), 
    array('name','require','����д��ȷ�׶�԰���ƣ�')


);


	
	}
?>