<?php
require_once 'rest/inc/init.php';

$resobj= new base_response();
$handler = find_handler(filter_path());
if($handler){
	$params = check_method_params($handler['method'],extract_params());
	if(!$params && !is_array($params)){
		$resobj->set(array('code'=>500,'body'=>"params invalid!"));
	}else {
		try{
			$resobj = $handler['method']->invokeArgs ($handler['class'],$params);
		}catch(ForbiddenException $e){
			$resobj->set(array('code'=>403,'body'=>$e->getMessage()));
		}catch (Exception $e) {        // Will be caught
			$resobj->set(array('code'=>500,'body'=>$e->getMessage()));
		}	
	}
}else{
	$resobj->set(array('code'=>404));
}
$resobj->flush();

?>