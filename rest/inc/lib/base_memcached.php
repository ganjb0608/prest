<?php
class base_memcached extends Memcache{
	public $servers;
	public static $_instance = NULL;
	/*
	 * 构造函数
	*/
	public function __construct() {
		global $main_conf;
		if(!isset($main_conf['cache'])){
			exit("The memcache configuration does not exist!");
		}
		$this->servers = $main_conf['cache'];
	}
	
	public function init(){
		foreach ($this->servers as $item)
		{
			$this -> addServer($item['host'], $item['port'], 1);
		}
	}
	
	/**
	 * 析构函数
	 */
	function __destruct()
	{
		$this->close();
	}
	
	/**
	 * 设置'key'对应存储的值
	 * @param string $key
	 * @param object $value
	 * @param int $time
	 */
	public function save($key,$value,$time=MEM_DEFAULT_TIMEOUT,$include_root = true)
	{
		if(MEM_OPEN)
		{
			self::init();
			if($include_root)
				return parent::set(MEM_ROOT.':'.$key,json_encode($value, JSON_NUMERIC_CHECK),0,$time);
			else
				return parent::set($key,json_encode($value, JSON_NUMERIC_CHECK),0,$time);
		}
		return FALSE;
	}
	/**
	 * 获取memcache的值
	 * @param string $key
	 */
	public function fetch($key,$include_root = true)
	{
		if(MEM_OPEN)
		{
			self::init();
			if($include_root)
				$res = parent::get(MEM_ROOT.':'.$key);
			else
				$res = parent::get($key);
			if (FALSE !== $res)
			{
				return json_decode($res, 1);
			}
			return FALSE;
		}
		return FALSE;
	}
	
	/**
	 * 返回Memcache
	 * @return	object
	 */
	public static function getCache() {
		if (empty(self::$_instance) || !(self::$_instance instanceof self)) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}
}