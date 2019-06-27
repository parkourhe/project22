<?php 

$size = 20;

      //sql语句
       $where = '1=1';

      	//状态数据转换数组
	
      	$GLOBALS['status_data'] = array('published' => '已发布',
      	  'drafted' => '草稿',
      	  'trashed'=>'回收站' );


      //分类筛选功能

      $serch = '';
      if (isset($_GET['categories']) && is_numeric((int)$_GET['categories'])) {

        $categories_id = $_GET['categories'];

        $where = 'category_id='.$categories_id;  

        $serch .= '&categories='.$_GET['categories'];

      
        if (isset($_GET['status']) && array_key_exists($_GET['status'], $GLOBALS['status_data'])) {

            $where ='posts.category_id='.$categories_id.' and posts.status=\''.$_GET['status'].'\'';

            $serch.='&status='.$_GET['status'];
            

          } 
        
      }

      if (isset($_GET['categories']) && is_numeric((int)$_GET['categories']) && $_GET['categories'] == 'all') {
        
        $where= '1=1';
      }

      
      // 获取所有数据条数
      $totalPosts = xiu_get_data("SELECT 
        COUNT(1) as total
        from posts 
        INNER JOIN categories on posts.category_id=categories.id
        INNER JOIN users on posts.user_id=users.id
        WHERE ${where}
        limit 1")[0]['total'];

    
      $totalPages=(int)ceil((int)$totalPosts/$size);


      

      // 获取分类数据


      $categories=xiu_get_data("SELECT * from categories");

      // 上一页逻辑
      if (!empty($_GET['lastPage']) && $_GET['lastPage']) {

            $_GET['page']--;
      }

      // 下一页逻辑

      if (!empty($_GET['nextPage']) && $_GET['nextPage']) {

            $_GET['page']++;
           
      }

      //GET方式传递当前选值
      $page =empty($_GET['page'])?1:(int)$_GET['page'];

      // 判断用户是否通过URL操作
      // 这里可以通过赋值的方式限制用户，也可以通过跳转的方式限制
      // 列如
      // header('location:/admin/posts.php?page=1')
      $page = $page<1 ? $page=1:$page;

      $page = $page>$totalPages?$page=$totalPages:$page;

      // 计算超出多少条公式,分页功能

      $offset=  ($page-1)*$size;
      

      //导航器

      $navCount=10;

      // 计算间距
      $qujian = (int)floor(($navCount-1)/2);

      $begin = $page-$qujian;

      $end =$page+$qujian;


       //导航器如果出现小于1的情况

      if ($begin<=0) {
        $begin=1;

        $end = $begin +($navCount-1);
      }

      
      //导航器如果超出总页数处理

      if ($end>$totalPages||$page>$totalPages) {
      
        $end=$totalPages;
        $begin=$totalPages-($navCount-1);

        if ($begin<=0) {
        $begin=1;
        }
      }

     


      if (isset($_GET['nextPage']) && $page>=$totalPages) {
        $page=$totalPages;

      }



 ?>