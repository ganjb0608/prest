<?php
require_once("config/main.php");

//类自动加载
function loadClass($class){
	if(substr($class, -8)=='Handlers'){
		require_once(PHPROOT . "/handlers/".$class.".php");
	}elseif(substr($class, 0,5)=='base_'){
		require_once(PHPROOT."/inc/lib/".$class.".php");
	}elseif(substr($class,-5)=='Model'){
		require_once(PHPROOT."/inc/models/".$class.".php");
	}elseif (substr($class, -7)=='Service'){
		require_once(PHPROOT."/inc/services/".$class.".php");
	}else{
		exit("class '".$class."' not found");
	}
}
spl_autoload_register('loadClass');

//合并路由配置
if(!isset($route_conf) || !is_array($route_conf)){
	exit("错误:路由配置文件不能为空");
}
$sys_route_conf = array();
$route_num = 0;
foreach ($route_conf as $key=>$group){
	$route_num += count($group);
	$sys_route_conf = array_merge($sys_route_conf,$group);
}
if($route_num!=count($sys_route_conf)){
	exit("错误:路由配置有重复项目");
}

function find_handler($path)
{
	global $sys_route_conf;
	$route_path = substr($path, 5);
	if($sys_route_conf && isset($sys_route_conf[$route_path])){
		$object = $sys_route_conf[$route_path]['class'];
		$action = $sys_route_conf[$route_path]['method'];
	}else if(preg_match('/^\/rest\/(\w+)\/(\w+)\/?[^\/]*$/i',$path,$ret)){
		$object = $ret[1];
		$action = $ret[2];
	}
	if(isset($object) && isset($action)){
		try {
			$class_file = CLASSES_PATH . "/${object}.php";
			if(file_exists ( $class_file )){
				require_once($class_file);
				$class = new ReflectionClass($object);
				if ($class->isInstantiable()) {
					return array('class'=>$class->newInstance(),'method'=>new ReflectionMethod($object, $action));
				}
			}
		}catch(Exception $e){
			exit("system errors");
		}
	}
	return null;
}

/*extract params from http requeset*/
function extract_params()
{
	return array_merge($_POST,$_GET);
}

/*check sql injection*/
function check_param_safe($input)
{
	if(preg_match("/['=]/",$input)){
		return false;
	}else{
		return true;
	}
}

function check_method_params($method,$params)
{
	$ret = array();
	$func_args = $method->getParameters();
	for($i=0;$i<count($func_args);$i++){
		$arg_name = $func_args[$i]->getName();
		if(isset($params[$arg_name])){
			if(!check_param_safe($params[$arg_name])){
				//echo "check_method_params 1:$arg_name\n";
				return null;
			}
			array_push($ret,$params[$arg_name]);
		}else if($func_args[$i]->isOptional() || $func_args[$i]->isDefaultValueAvailable()){
			continue;
		}
		else{
			//echo "check_method_params 2:$arg_name\n";
			return null;
		}
	}
	return $ret;
}

/**
 * 清除请求url中的参数部分  返回样式/rest/xxx/xxx/
 */
function filter_path()
{
	$path = preg_replace('/\\|\\\\|\/\//','/',$_SERVER["REQUEST_URI"]);
	$path = preg_replace('/\?[^\/]*$/','',$path);
	$path = preg_replace('/\/$/','',$path);
	return $path;
}

class ForbiddenException extends Exception
{
	protected $code = 403;
	protected $message = 'The request is denied!';
}
class NotFoundException extends Exception
{
	protected $code = 404;
	protected $message = 'Handler not found!';
}

/**
 * 参数加密校验
 */
function checkCode(){
// 	$ticket=isset($_COOKIE["ticket"])?$_COOKIE["ticket"]:null;
// 	$resobj= new response();
// 	if($ticket && !auth::check_ticket($ticket)){
// 		$resobj->set(array('code'=>403,'body'=>"ticket invalid!"));
// 		$resobj->flush();
// 	}
}
