<?php  

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'/libraries/REST_Controller.php');
require_once(APPPATH.'/libraries/Format.php');


class Login extends REST_Controller {
     public function __construct() { 
     
		parent::__construct();
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
		header('Access-Control-Allow-Credentials: true');
        $this->load->model('Login_model');
	}
	
	function index_post()
	{  

		header('Content-type: application/json'); 
		$data = json_decode(file_get_contents('php://input'),true);
		try 
		{
			if(!empty($data))
			{
				if(isset($data['username']) && isset($data['password']))
				{
					$UserLoginArray = $this->Login_model->authenticateUser($data['username'],$data['password']);
				}
				else
				{
					$data['ErrorMessage'] = "Email or password is missing";
					$data['ResponseCode'] = 400;
					throw new Exception($data['ErrorMessage'],$data['ResponseCode']);
				}
			}
			else
			{
				$data['ErrorMessage'] = "Required data are missing";
				$data['ResponseCode'] = 401;
				throw new Exception($data['ErrorMessage'],$data['ResponseCode']);
			}
			
			$newarray['data']= $UserLoginArray;
			echo json_encode($newarray,TRUE);
			exit;
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
					
				echo json_encode($newarray,TRUE);
			   exit;
		}//end catch

  	}
	public function __destruct() {
		$this->db->close();
	}
	
}

