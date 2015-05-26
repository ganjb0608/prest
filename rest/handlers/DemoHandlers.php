<?php
class DemoHandlers extends BaseHandlers{
	//取数加使用memcache实例    XXX.com/rest/demo?order_sn=M2102288876
	public function test($order_sn){
		$demo = new DemoModel();
		$info = $demo->getOrderInfo($order_sn);
		return new base_response(array('body'=>$info,'cache'=>'5'));
	}
	
	//获取刚才缓存的值    XXX.com/rest/democache
	public function test2(){
		$demo = new DemoModel();
		$info = $demo->getOrderInfoFromCache();
		return new base_response(array('body'=>$info,'cache'=>'5'));
	}
	
	//services调用
	public function test3(){
 		$service = new DemoService();
 		$info = $service->test('M2101279712');
		//$info = $service->tmp();
		return new base_response(array('body'=>$info,'cache'=>'5'));
	}
	
	
}
?>