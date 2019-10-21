<?php
require_once __DIR__.'/server.php';

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
		$grant_types='client_credentials';
		$scope='default';
		if(!isset($params['client_id'])){
			echo json_encode(array('error'=>'client_id',"error_description"=>'Please enter client id'));
			die;
		}
		if(!isset($params['client_secret'])){
			echo json_encode(array('error'=>'client_secret',"error_description"=>'Please enter client secret'));
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
		
		if(isset($params['user_id'])){
			if($params['user_id']!=''){
				$user_id=$params['user_id'];
			}
		}
		
		if(isset($params['user_id'])){
			if($params['user_id']!=''){
				$user_id=$params['user_id'];
			}
		}
		
		
		
		$insertQry="INSERT INTO oauth_clients (client_id,client_secret,grant_types,scope,user_id) VALUES ('$client_id','$client_secret','$grant_types','$scope','$user_id')";
		
		$result = mysqli_query($conn,$insertQry);
		//$user_id=$conn->insert_id;
		if($result){
			$query=mysqli_query($conn,"select * from oauth_clients where client_id='$client_id'");
			$result=mysqli_fetch_array($query,MYSQLI_ASSOC);
			echo json_encode($result);
		}
		else{
			echo json_encode(array('error'=>'DB_ERROR',"error_description"=>'Something went wrong.Please try with different client id'));
		}
		die;
	}
	else{
		echo json_encode(array('error'=>'MISSING_VARIABLES',"error_description"=>'Please enter variables'));
		die;
	}
		
}
?>