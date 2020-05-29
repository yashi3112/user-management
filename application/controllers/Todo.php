<?php  

defined('BASEPATH') OR exit('No direct script access allowed');
 //needed when extending REST COntroller
require_once(APPPATH.'/libraries/REST_Controller.php');
require_once(APPPATH.'/libraries/Format.php');


class Todo extends REST_Controller {
     public function __construct() { 
     	//load user model
        //header('Access-Control-Allow-Origin: *');
    	//header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		parent::__construct();
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
		header('Access-Control-Allow-Credentials: true');
        $this->load->model('Todo_model');

	    

	}
	
	function index_post()
	{  

		header('Content-type: application/json'); 
		

		try 
		{
			$UserLoginArray = $this->Todo_model->get_all_notes();
			$newarray['data']= $UserLoginArray;
			//echo "hello";
			echo json_encode($newarray,TRUE);
			exit;
		
				
					//end if returnAuth
		}//end try
		catch(Exception $e)
		{
				$newarray['Data']['Message'] = 'Fail';
				$newarray['Data']['ResponseCode'] = $e->getCode();
				$newarray['Data']['ErrorMessage'] = $e->getMessage();
				$newarray['Data']['UnreadNotification'] = 0;
				$newarray['Data']['Credit'] = 0;
				$newarray['Data']['Records'] = '';
	
				$InsertErrData = array(
						"Exception"=>$e->getMessage(),
						"DeviceID"=>"",
						"Activity"=>$this->router->fetch_class(),
						"GmtTimeStamp"=>gmdate("Y-m-d H:i:s"),
						"TimeStamp"=>date('Y-m-d H:i:s'),
						"IPAddress"=>$_SERVER['REMOTE_ADDR'],
						"PrimaryEmail"=>$Data['PrimaryEmail'],
						"ManufactureModel"=>"",
						"VersionInfo"=>"",
						"ErrorSource"=>"php",
						"ExceptionCode"=>$e->getCode(),
						"CarParkID"=>""
					);
					
				//$this->ProjectFunction_model->fnErrorLog($InsertErrData);

				echo json_encode($newarray,TRUE);
			   exit;
		}//end catch

  	}
	
	function update_post()
	{  

		header('Content-type: application/json'); 
		$update_data = json_decode(file_get_contents('php://input'),true);

		//print_r($update_data);die;
		try 
		{
			
			  
			if(!empty($update_data))
			{
		
				$update_todo = array(
				  'notes' => $update_data['notes']
				);
				$data = $this->Todo_model->update_notes($update_todo);
			
				$newarray['Data'] = $data;
				
				
				echo json_encode($newarray,TRUE);
				exit;
			}
			else
			{
				throw new Exception("Method Not Allowed",405);
			}	
			
					//end if returnAuth
		 }//end try
		catch(Exception $e)
		{
				$newarray['Data']['Message'] = 'Fail';
				$newarray['Data']['ResponseCode'] = $e->getCode();
				$newarray['Data']['ErrorMessage'] = $e->getMessage();
				$newarray['Data']['UnreadNotification'] = 0;
				$newarray['Data']['Credit'] = 0;
				$newarray['Data']['Records'] = '';
	
				$InsertErrData = array(
						"Exception"=>$e->getMessage(),
						"DeviceID"=>"",
						"Activity"=>$this->router->fetch_class(),
						"GmtTimeStamp"=>gmdate("Y-m-d H:i:s"),
						"TimeStamp"=>date('Y-m-d H:i:s'),
						"IPAddress"=>$_SERVER['REMOTE_ADDR'],
						"PrimaryEmail"=>$data['PrimaryEmail'],
						"ManufactureModel"=>"",
						"VersionInfo"=>"",
						"ErrorSource"=>"php",
						"ExceptionCode"=>$e->getCode(),
						"CarParkID"=>""
					);
					
			//	$this->ProjectFunction_model->fnErrorLog($InsertErrData);

				echo json_encode($newarray,TRUE);
			   exit;
		}//end catch
  	}
	public function __destruct() {
		$this->db->close();
	}
	
}

