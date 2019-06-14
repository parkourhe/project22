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


//添加数据的函数封装


function xiu_add_data($needsql){

	$con =mysqli_connect(XIU_DB_HOST,XIU_DB_USER,XIU_DB_PASS,XIU_DB_NAME);

	if (!$con) {
      exit('连接数据库失败');
    }	

    $query = mysqli_query($con,$needsql);


    if (!$query) {
      exit('查询失败');
    }

    $affected = mysqli_affected_rows($con);

   	if (!affected) {
   		exit('失败');
   	}

    
}


function xiu_execute ($sql) {
  $conn = mysqli_connect(XIU_DB_HOST, XIU_DB_USER, XIU_DB_PASS, XIU_DB_NAME);
  if (!$conn) {
    exit('连接失败');
  }

  $query = mysqli_query($conn, $sql);
  if (!$query) {
    // 查询失败
    return false;
  }

  // 对于增删修改类的操作都是获取受影响行数
  $affected_rows = mysqli_affected_rows($conn);

  mysqli_close($conn);

  return $affected_rows;
}