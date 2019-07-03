<?php 
	// 服务端接受文件逻辑
	
	

	if (empty($_FILES['avatar'])) {
		exit('没有头像');
	}

	// 接收一下文件

	$avatar = $_FILES['avatar'];

	if ($avatar['error']!==UPLOAD_ERR_OK) {
		exit('上传失败');
	}


	//在这里限制上传文件的格式和大小


	$extension = strtolower(pathinfo($avatar['name'],PATHINFO_EXTENSION));
	

	if ($extension!=='png') exit('请上传PNG');


	$target = '../../static/uploads/'.uniqid().'.'.$extension;


	if (!move_uploaded_file($avatar['tmp_name'], $target)) {
		exit('服务器繁忙');
	}


	$reltarget=substr($target,5);


	echo $reltarget;


	

	