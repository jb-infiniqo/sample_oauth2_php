<?php
require_once __DIR__.'/server.php';
ini_set('display_errors',1);
error_reporting(E_ALL);
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	echo json_encode(array('error'=>'DB_CONNECTION',"error_description"=>$conn->connect_error));
  
} 
else{
	$params = (array) json_decode(file_get_contents('php://input'), TRUE);
	
	if(count($params)>0){
		$user_id='0';
		$client_id='';
		$client_secret='';
		$grant_types='';
		$scope='default';
		if(!isset($params['client_id'])){
			echo json_encode(array('error'=>'client_id',"error_description"=>'Please enter client id'));
			die;
		}
		if(!isset($params['client_secret'])){
			echo json_encode(array('error'=>'client_secret',"error_description"=>'Please enter client secret'));
			die;
		}
		
		if(!isset($params['grant_types'])){
			echo json_encode(array('error'=>'grant_types',"error_description"=>'Please enter grant types'));
			die;
		}
		
		if(isset($params['client_id'])){
			if($params['client_id']==''){
				echo json_encode(array('error'=>'client_id',"error_description"=>'Please enter client id'));
				die;
			}
			else{
				$client_id=$params['client_id'];
			}
		}
		
		if(isset($params['client_secret'])){
			if($params['client_secret']==''){
				echo json_encode(array('error'=>'client_secret',"error_description"=>'Please enter client secret'));
				die;
			}
			else{
				$client_secret=$params['client_secret'];
			}
		}
		
		if(isset($params['grant_types'])){
			if($params['grant_types']!=''){
				$grant_types=$params['grant_types'];
			}
			if($params['grant_types']==''){
				echo json_encode(array('error'=>'grant_types',"error_description"=>'Please enter grant types'));
				die;
			}
		}
		
	
		
		//API URL
		$url = 'http://112.196.54.36/oAuth/oauth2-server-php/create_token.php';

		//create a new cURL resource
		$ch = curl_init($url);

		//setup request to send json via POST
		$data = array(
			'grant_type' => 'client_credentials',
			'client_secret' => 'Igbjcq70NxqDevmRJkm5s',
			'client_id' => 'FqZzLBY8ss'
		);
		$payload = json_encode($data);

		//attach encoded JSON string to the POST fields
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

		//set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

		//return response instead of outputting
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		//execute the POST request
		$result = curl_exec($ch);
		echo $result;
		die;
		//close cURL resource
		curl_close($ch);

		
		
		
		
	}
	else{
		echo json_encode(array('error'=>'MISSING_VARIABLES',"error_description"=>'Please enter variables'));
		die;
	}
		
}
?>