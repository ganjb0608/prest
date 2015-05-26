<?php
class DemoModel extends BaseModel{
//	public $dataBase="mmall";  //可不设，默认取mmall数据库配置   
	
	/**
	 * 获取订单详情
	 */
	public function getOrderInfo($order_sn){
		$sql = "select order_sn,order_status,order_amount,money_paid,postscript,to_char(latest_time,'yyyy-mm-dd hh24:mi:mm') as latest_time from sc_order_info where order_sn=:sn";
		$rs = $this->dbConn->prepare($sql);
		$rs->execute(array(
			':sn' => $order_sn
		));
		$result = $rs->fetch();
		$this->cache->save('order_info', $result);
		return $result;
	}
	
	//获取缓存数据
	public function getOrderInfoFromCache(){
		
		$info = $this->cache->fetch('order_info');
		return $info;
	}
	
	
	
}