   <?php 
       // 如果是修改操作与查询操作一起，一定是先做修改，再查询
      
      require_once('../functions.php');
      

      // 验证当前登陆用户
      xiu_get_current_user(); 

      $size = 20;

      //状态数据转换数组

      $GLOBALS['status_data'] = array('published' => '已发布',
        'drafted' => '草稿',
        'trashed'=>'回收站' );

      // 获取所有数据条数
      $totalPosts = xiu_get_data("SELECT 
        COUNT(1) as total
        from posts 
        INNER JOIN categories on posts.category_id=categories.id
        INNER JOIN users on posts.user_id=users.id
        limit 1")[0]['total'];

    
      $totalPages=(int)ceil((int)$totalPosts/$size);


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
      }

      if (isset($_GET['nextPage']) && $page>=$totalPages) {
        $page=$totalPages;

      }

      // 获取分类数据


      $categories=xiu_get_data("SELECT * from categories");

      $where = '1=1';



      //分类筛选功能

      if (isset($_GET['categories']) && is_numeric((int)$_GET['categories'])) {

        $categories_id = $_GET['categories'];

        $where = 'category_id='.$categories_id;  

      
        if (isset($_GET['status']) && array_key_exists($_GET['status'], $GLOBALS['status_data'])) {

            $where ='posts.category_id='.$categories_id.' and posts.status=\''.$_GET['status'].'\'';
          
          }  
        
      }

      if (isset($_GET['categories']) && is_numeric((int)$_GET['categories']) && $_GET['categories'] == 'all') {
        
        $where= '1=1';
      }



      

      // 关联数据查询
      $posts = xiu_get_data("SELECT 
        posts.id,
        posts.title,
        users.nickname as users_name,
        categories.name as categories_name,
        posts.created,
        posts.`status`


        from posts 
        INNER JOIN categories on posts.category_id=categories.id
        INNER JOIN users on posts.user_id=users.id
        WHERE {$where}
        ORDER BY posts.created desc
        LIMIT {$offset},{$size}");


      // 数据转换函数



      function xiu_get_status($status){

      
        return isset($GLOBALS['status_data'][$status])?$GLOBALS['status_data'][$status]:"未定义";
      } 


      //发布时间格式转换



      function xiu_get_time($time){

        $time = strtotime($time);

        return (date('Y年m月d日<b\r>H:i:s',$time));


      }
     
   ?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
  <script src="/static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>
  
  <div class="main">
   <?php include 'inc/navbar.php' ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有文章</h1>
        <a href="post-add.php" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline" method="GET" action="<?php echo $_SERVER['PHP_SELF'] ?>">
          <select name="categories" class="form-control input-sm">
            <!-- 分类筛选 -->
            <option value="all">所有分类</option>
            <?php foreach ($categories as $item): ?>
             <option value="<?php echo $item['id'] ?>" <?php if (isset($_GET['categories'])) {
               echo $item['id']==$categories_id?'selected':'';
             } ?>><?php echo $item['name'] ?></option>
            <?php endforeach ?>
          </select>
          <select name="status" class="form-control input-sm">
            <option value="all">所有状态</option>
            <option value="<?php echo 'drafted' ?>" >草稿</option>
            <option value="<?php echo 'published' ?>">已发布</option>
            <option value="<?php echo 'trashed' ?>">回收站</option>
          </select>
          <button class="btn btn-default btn-sm">筛选</button>
        </form>
        <ul class="pagination pagination-sm pull-right">
          <li><a href="?lastPage=true&page=<?php echo $page ?>">上一页</a></li>
            <?php for ($i=$begin; $i <=$end ; $i++): ?>
          <li <?php echo (int)$i===(int)$page?"class=active":"" ?>><a href="?page=<?php echo $i ?>"><?php echo $i ?></a></li>
          <?php endfor ?>
          <!-- 在这里判断一下 下一页到底时候的情况 -->
          <li><a href="?nextPage=true&page=<?php echo $page==$totalPages?--$page:$page ?>">下一页</a></li>
          
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <?php  if (!empty($posts)):?>
            <?php foreach ($posts as $item):?>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td><?php echo $item['title'] ?></td>
                <td><?php echo $item['users_name'] ?></td>
                <td><?php echo $item['categories_name'] ?></td>
                <td class="text-center"><?php echo xiu_get_time($item['created']) ?></td>
                <td class="text-center"><?php echo xiu_get_status($item['status']) ?></td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>


            <?php endforeach ?>


          <?php endif ?>
          
        </tbody>
      </table>
    </div>
  </div>
  <?php $current_pages='posts' ?>
 <?php include 'inc/sidebar.php' ?>

  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
