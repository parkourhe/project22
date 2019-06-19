   <?php 
       // 如果是修改操作与查询操作一起，一定是先做修改，再查询
      
      require_once('../functions.php');
      

      // 验证当前登陆用户
      xiu_get_current_user(); 



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
        ORDER BY posts.created desc
        LIMIT 0,10");


      // 数据转换函数

      function xiu_get_status($status){


        $status_data = array('published' => '已发布',
          'drafted' => '草稿',
          'trashed'=>'回收站' );


        return isset($status_data[$status])?$status_data[$status]:"未定义";
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
        <form class="form-inline">
          <select name="" class="form-control input-sm">
            <option value="">所有分类</option>
            <option value="">未分类</option>
          </select>
          <select name="" class="form-control input-sm">
            <option value="">所有状态</option>
            <option value="">草稿</option>
            <option value="">已发布</option>
          </select>
          <button class="btn btn-default btn-sm">筛选</button>
        </form>
        <ul class="pagination pagination-sm pull-right">
          <li><a href="<?php echo $_SERVER['PHP_SELF'] ?>">上一页</a></li>
          <li><a href="<?php echo $_SERVER['PHP_SELF'] ?>">1</a></li>
          <li><a href="<?php echo $_SERVER['PHP_SELF'] ?>">2</a></li>
          <li><a href="<?php echo $_SERVER['PHP_SELF'] ?>">3</a></li>
          <li><a href="<?php echo $_SERVER['PHP_SELF'] ?>">下一页</a></li>
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
