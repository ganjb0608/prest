<?php
class DemoService extends BaseService{
	public function test($order_sn){
		$demo = new DemoModel();
		$info = $demo->getOrderInfo($order_sn);
		$this->cache->save('kk11', $info);
		return $info;
	}
	
	public function tmp(){
		$info = $this->cache->fetch('kk11');
		return $info;
	}
}