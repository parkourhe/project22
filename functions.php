<?php  
	SESSION_START();

	require_once('config.php');


	// ���庯��һ��Ҫע�������ú�����ͻ������



	// ȡ�õ�ǰ��½�û���Ϣ
function xiu_get_current_user()
{
	if (empty($_SESSION['cuurent_login'])) {
      header('location:/admin/login.php');
      exit();
    }
	  
	  return $_SESSION['cuurent_login'];


};

	// ��װ���ݿ��ѯ

function xiu_get_data($needsql){
	$con =mysqli_connect(XIU_DB_HOST,XIU_DB_USER,XIU_DB_PASS,XIU_DB_NAME);

	if (!$con) {
      exit('�������ݿ�ʧ��');
    }	

    $query = mysqli_query($con,$needsql);

    if (!$query) {
      exit('��ѯʧ��');
    }

     while ($row = mysqli_fetch_assoc($query)) {
      $data[]=$row;
    }

    return $data;

}


//������ݵĺ�����װ


function xiu_add_data($needsql){

	$con =mysqli_connect(XIU_DB_HOST,XIU_DB_USER,XIU_DB_PASS,XIU_DB_NAME);

	if (!$con) {
      exit('�������ݿ�ʧ��');
    }	

    $query = mysqli_query($con,$needsql);


    if (!$query) {
      exit('��ѯʧ��');
    }

    $affected = mysqli_affected_rows($con);

   	if (!affected) {
   		exit('ʧ��');
   	}

    
}


function xiu_execute ($sql) {
  $conn = mysqli_connect(XIU_DB_HOST, XIU_DB_USER, XIU_DB_PASS, XIU_DB_NAME);
  if (!$conn) {
    exit('����ʧ��');
  }

  $query = mysqli_query($conn, $sql);
  if (!$query) {
    // ��ѯʧ��
    return false;
  }

  // ������ɾ�޸���Ĳ������ǻ�ȡ��Ӱ������
  $affected_rows = mysqli_affected_rows($conn);

  mysqli_close($conn);

  return $affected_rows;
}