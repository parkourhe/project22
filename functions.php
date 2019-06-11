<?php  
	SESSION_START();

	require_once('config.php');


	// 定义函数一个要注意与内置函数冲突的问题



	// 取得当前登陆用户信息
function xiu_get_current_user()
{
	if (empty($_SESSION['cuurent_login'])) {
      header('location:/admin/login.php');
      exit();
    }
	  
	  return $_SESSION['cuurent_login'];


};

	// 封装数据库查询

function xiu_get_data($needsql){
	$con =mysqli_connect(XIU_DB_HOST,XIU_DB_USER,XIU_DB_PASS,XIU_DB_NAME);

	if (!$con) {
      exit('连接数据库失败');
    }	

    $query = mysqli_query($con,$needsql);

    if (!$query) {
      exit('查询失败');
    }

     while ($row = mysqli_fetch_assoc($query)) {
      $data[]=$row;
    }

    return $data;

}