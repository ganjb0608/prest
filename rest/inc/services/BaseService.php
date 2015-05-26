<?php
class BaseService{
	public $cache;
	public function __construct(){
		$this->cache = base_memcached::getCache();
	}
}