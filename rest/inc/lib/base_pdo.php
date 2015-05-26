<?php
class base_pdo {
	/**
	 * 返回的连接状态
	 * @author	jonah.fu
	 * @date	2012-04-21
	 */
	public $connected = FALSE;

	/**
	 * 返回的pdo对象
	 * @author	jonah.fu
	 * @date	2012-04-21
	 */
	public $conn;
	protected $DbConnectStr,$DbUserName, $DbPassWord,$pdoCfg;

	public static $_instance = array();

	private function __construct($dbname) {
		global $main_conf;
		if(!isset($main_conf[$dbname])){
			exit("This database '".$dbname."' configuration does not exist!");
		}
		$cfg = $main_conf[$dbname];
		$this -> DbConnectStr = $cfg['connectstr'];
		$this -> DbUserName = $cfg['userName'];
		$this -> DbPassWord = $cfg['passWord'];
		$this -> pdoCfg = $cfg['pdo_cfg'];

		try {
			$this -> conn = new PDO($this->DbConnectStr, $this -> DbUserName, $this -> DbPassWord,$this->pdoCfg);
			$this -> connected = TRUE;
		} catch ( Exception $e ) {
			printf($e -> getMessage());
			exit();
		}
	}

	/**
	 * 防止复制对象,因为单例模式要保证一个类实例的对象是唯一的.
	 */
	private function __clone() {
	}

	/**
	 * 返回数据库连接对象
	 * @return	object		返回pdo_oci_obj 对象
	 */
	public static function connect($dbname) {
		if (empty(self::$_instance[$dbname]) || !(self::$_instance[$dbname] instanceof self)) {
			self::$_instance[$dbname] = new self($dbname);
		}
		return self::$_instance[$dbname];
	}
}