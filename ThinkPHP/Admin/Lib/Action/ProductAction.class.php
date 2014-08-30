<?php
/**************************************************************************************
 ***  文件：FileAction.class.php
 ***  说明：后台图片上传管理操作类
 ***  作者：
 ***  日期：2012-08-12
 *************************************************************************************/

//FileAction控制类继承统一入口加载类CommonAction
class ProductAction extends CommonAction {
            
	/****************************************************
     *** 函数名：index
     *** 参数：  无
     *** 功能 ：图片上传管理首页的显示
	***************************************************/	
	function index(){

	    	$productinfo=M('productinfo');
			if (empty($_GET['id'])) {	

				//空的时候直接初始化第一张图片信息                         
               $productinfodata = $productinfo->where('id=1')->select();
			}
			else
			{
				//不空的时候初始化第id张图片信息
				$productinfodata = $productinfo->where('id='.$_GET['id'])->select();		
			}
		//print_r($productinfodata);
		//exit();
	    $this->assign('productinfodata',$productinfodata);
	    $this->assign('editor','<textarea id="editor_id" name="content" style="width:900px;height:400px; ">'.$productinfodata[0]['content'].'</textarea>');

		$this->assign('timer',$this->getTime());		
		$this->display();

	}

	
   /***************************************
     *** 函数名：add
     *** 参数：  无
     *** 功能 ： 上传文件界面的显示
	****************************************/
	function replace()
	{

		   $this->checkdata($_POST);

		   $uptypes=array(
				'image/jpeg'	
                   );
		   //要不要试试绝对路径
		   $destination_folder='./Home/Tpl/resource/productimage/';

			        if (!$_SERVER['REQUEST_METHOD'] == 'POST')
						{
							$this->assign('message','保存产品图片信息失败！');
				            $this->error();
						}

						

						if (!is_uploaded_file($_FILES["picture"]["tmp_name"]))
						//是否存在文件
						{
							$this->assign('message','图片不存在或文件类型不支持！');
			                $this->error();
			            }

			            $file = $_FILES["picture"];
			            /*
			            图片数组
	                    [picture] => Array ( [name] => web设计文字版.docx 
	             					  [type] => application/vnd.openxmlformats-officedocument.wordprocessingml.document 
	             					  [tmp_name] => C:\wamp\tmp\phpF85.tmp 
	             					  [error] => 0 
	             					  [size] => 14423 
	             					  ) ;
			            */			      		
							//echo $file["type"];
							//exit();

				        if(!in_array($file["type"], $uptypes))
						//检查文件类型
						{
							$this->assign('message','文件类型不符，仅支持上传.jpg图片!');
			                $this->error();
							
						}

						$destination=$destination_folder.'product'.$_POST['id'].'.jpg';
					
						if(file_exists($destination))
						{
					
							unlink($filedir.$filename);
						}
										
                        //临时文件名
						$filename=$file["tmp_name"];
			            //必须保证数据跟图片替换都成功才能更新

						if(!move_uploaded_file ($filename, $destination))
						{

							$this->assign('message','图片移动出错,请重试');
			                $this->error();      
			             }  

			            $state = $this->replacepicturedata($_POST);
			            if($state)
			            {
			            	$this->success("图片替换成功");
			            }

	}

	 function checkdata($data)
	 {
	 	
	 	    if (empty($data['title'])) { 	

				$this->assign('message','标题不能为空,请重试');
			    $this->error();    

	 		}	
	 		if (empty($data['posttime'])) {

				$this->assign('message','添加时间不能为空');
                $this->error();    

	 		}	
	 		if (empty($data['keyword'])) { 

				$this->assign('message','关键字不能为空');
                $this->error();    

	 		}	
	 		if (empty($data['content'])) { 		

				$this->assign('message','产品介绍不能为空');
                $this->error();    	
	 		}	
	 }

     function replacepicturedata($data)
     {

        $data['posttime']	= strtotime($data['posttime']);  
        //print_r($data);   	
     	$productinfo=M('productinfo');
     	$state =$productinfo->where('id='.$data[id])->data($data)->save();   	  	
 	  	return $state;	
     } 

	/***************************************
     *** 函数名：add
     *** 参数：无
     *** 功能 ：上传文件界面的显示
	****************************************/	

	function add(){		
		$productinfo=M('productinfo');
		$productinfodata=$productinfo->select();

        $productinfoidarr= array(1,2,3,4,5,6,7);

        //print_r($productinfoidarr);
        //exit();

        if(count($productinfodata)==7)
        {
        	$this->assign("full",true);
        }
        else
        {

     	
	        	foreach ($productinfodata as  $value) 
	        	{
	        		if(in_array($value['id'],$productinfoidarr))
	        		{
	        			unset($productinfoidarr[$value['id']-1]);	
	        		}    	  		
	        		
	        }
	        
	    }

	    	$this->assign('editor','<textarea id="editor_id" name="content" style="width:900px;height:400px; ">产品详细说明</textarea>');
	        $this->assign('productinfoidarr',$productinfoidarr);
			$this->assign('timer',$this->getTime());
			$this->display();
	}



    
	function addproductinfo($value='')
	{
		
		   $this->checkdata($_POST);

		   $uptypes=array(
				'image/jpeg'	
                   );
		   //要不要试试绝对路径
		   $destination_folder='../MyCMS/Home/Tpl/resource/productimage/';

			        if (!$_SERVER['REQUEST_METHOD'] == 'POST')
						{
							$this->assign('message','保存产品图片信息失败！');
				            $this->error();
						}

						

						if (!is_uploaded_file($_FILES["picture"]["tmp_name"]))
						//是否存在文件
						{
							$this->assign('message','图片不存在或文件类型不支持！');
			                $this->error();
			            }

			            $file = $_FILES["picture"];
			            /*
			            图片数组
	                    [picture] => Array ( [name] => web设计文字版.docx 
	             					  [type] => application/vnd.openxmlformats-officedocument.wordprocessingml.document 
	             					  [tmp_name] => C:\wamp\tmp\phpF85.tmp 
	             					  [error] => 0 
	             					  [size] => 14423 
	             					  ) ;
			            */			      		
							//echo $file["type"];
							//exit();

				        if(!in_array($file["type"], $uptypes))
						//检查文件类型
						{
							$this->assign('message','文件类型不符，仅支持上传.jpg图片!');
			                $this->error();			
						}

						$destination=$destination_folder.'product'.$_POST['id'].'.jpg';
					
						if(file_exists($destination))
						{
					
							unlink($filedir.$filename);
						}
										
                        //临时文件名
						$filename=$file["tmp_name"];
			            //必须保证数据跟图片替换都成功才能更新

						if(!move_uploaded_file ($filename, $destination))
						{

							$this->assign('message','图片移动出错,请重试');
			                $this->error();      
			             }  

			            $state = $this->addproductinfodata($_POST);
			            if($state)
			            {
			            	$this->success("图片添加成功");
			            }
			            else
			            {
			            	$this->assign('message','图片替换成功,但图片信息出错');
			                $this->error();  
			            }

	}

	function addproductinfodata($data)
	{
		
	    $data['posttime'] = strtotime($data['posttime']); 
	    $data['viewcount']=0;
	    $data['appdowncount']=0;        	
     	$productinfo=M('productinfo');
     	//print_r($data);
     	//exit();
     	$state =$productinfo->add($data);   	  	
 	  	return $state;	
	}

		

}?>