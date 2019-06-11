<?php 
	
	require_once('../../config.php');

	if (empty($_GET)) {
		exit('请传入制定参数');		
	}


	if (empty($_GET['email'])) {
		exit('参数错误');
	}


	$email = $_GET['email'];


	$con = mysqli_connect(XIU_DB_HOST,XIU_DB_USER,XIU_DB_PASS,XIU_DB_NAME);


	if (!$con) {
		exit('数据库连接失败');
	}


	$query = mysqli_query($con,"SELECT * from users WHERE email='{$email}' limit 1");

	if (!$query) {
		exit('未查询到数据');
	}

	$data = mysqli_fetch_assoc($query);

	echo($data['avatar']);



