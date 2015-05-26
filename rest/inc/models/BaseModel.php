<?php
/**
 * 基础工具类
 */
class BaseModel{
	public $dataBase;
	public $dbConn;
	public $cache;
	private static $_models = array();
	
	public function __construct(){
		if(!isset($this->dataBase)){
			$this->dataBase = "mmall";  //默认去mmall
		}
		
		$db_object = base_pdo::connect($this->dataBase);
		$this->dbConn = $db_object->conn;
 		$this->cache = base_memcached::getCache();
	}
	
	/**
	 * 切换数据库
	 */
	public function selectDB($db){
		$db_object = base_pdo::connect($db);
		$this->dbConn = $db_object->conn;
	}
	
	
	/**
	 * 返回分页SQL
	 * @author	jonah.fu
	 */
	public function model_creat_limitSQL($sql, $page_size, $page = 1) {
		$nextRows = ($page-1)*$page_size;
		$nextRows = $nextRows < 0 ? 1 : $nextRows + 1;
		$rowNUM = $page_size + $nextRows;
		$returnSQL = "
		SELECT * FROM ( SELECT TEMPSELECT.*, ROWNUM as ROW_NUMBER FROM (
		$sql
		) TEMPSELECT WHERE ROWNUM < $rowNUM) WHERE $nextRows<= ROW_NUMBER
		";
	
		return $returnSQL;
	}
	
	/**
	* 返回符合条件的记录总数
	 * @param unknown $sql
	 */
	 public function create_totalSQL($sql){
		 $totalSQL = "select count(1) as total from ($sql)";
		 return $totalSQL;
	 }
}