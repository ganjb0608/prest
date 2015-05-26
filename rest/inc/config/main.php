<?php
require_once 'constants.php';
require_once 'route.php';
$main_conf = array(
		'mmall' => array(
				'connectstr' => "oci:dbname=(DESCRIPTION=(ADDRESS=(PROTOCOL =TCP)(HOST=192.168.0.225)(PORT = 1531))(CONNECT_DATA =(SERVER = DEDICATED)(SID=pangusc)));charset=UTF8",
				'userName' => 'hmsc_s',
				'passWord' => 'CTxgTSN2SC',
				'pdo_cfg' => array(
						PDO::ATTR_PERSISTENT => 0,
						PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
						PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
						PDO::ATTR_CASE => PDO::CASE_LOWER,
						PDO::ATTR_AUTOCOMMIT => TRUE
				)
		),
		'hmm' => array(
				'connectstr' => "mysql:host=127.0.0.1;dbname=test",
				'userName' => 'root',
				'passWord' => '',
				'pdo_cfg' => array(
						PDO::ATTR_PERSISTENT => 0,
						PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
						PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
						PDO::ATTR_CASE => PDO::CASE_LOWER,
						PDO::MYSQL_ATTR_USE_BUFFERED_QUERY =>TRUE,
						PDO::ATTR_AUTOCOMMIT => TRUE
				)
		),
		'cache' => array(
				array(
						'host' => '192.168.0.51',
						'port' => 11212
				),
				array(
						'host' => '192.168.0.52',
						'port' => 11212
				)
		)  
);
?>