<?php 
     // 如果是修改操作与查询操作一起，一定是先做修改，再查询
      
      require_once('../functions.php');
      
    


      // 先做修改再做数据展示
      function add_data(){

          if (empty($_POST['name'])||empty($_POST['slug'])) {
            $GLOBALS['errormess'] = '请正确填写表单';
            return;

          }
          $name = $_POST["name"];

          $slug = $_POST['slug'];

          $affected = xiu_update_data("insert into categories values (null, '{$slug}', '{$name}');");

          if ($affected<0) {
            exit("添加分类失败");
          }


          $GLOBALS['sussce'] = true;


      };


      function edit_data(){


       if (empty($_POST['name'])||empty($_POST['slug'])) {
        $GLOBALS['errormess'] = '请正确填写编辑表单';
        return;

      }
      $id = $_GET['id'];

      $name = $_POST["name"];

      $slug = $_POST['slug'];


      $affected = xiu_update_data("UPDATE categories set slug='{$slug}',name='{$name}' WHERE id ='{$id}'");

      if ($affected<0) {
        exit("编辑失败");
      }


      $GLOBALS['sussce'] = true;

      }




      if ($_SERVER['REQUEST_METHOD']==='POST') {

        // 如果url中id为空,说明用户想增加数据
        if (empty($_GET['id'])) {
          var_dump($_GET);
          add_data();
        }else{
          edit_data();
        }



      }

      // 如果url 中id不为空说明，用户想编辑
      if (!empty($_GET['id'])) {
        $id = $_GET['id'];

        $current_data = xiu_get_data("SELECT * FROM categories where id='{$id}'")[0];
     
      }


      $categories=xiu_get_data('SELECT name,slug,id  from categories;');




 ?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
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
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
            
      

      <?php if (isset($GLOBALS['errormess'])) :?>
        <div class="alert alert-danger">
          <strong>错误！</strong> <?php echo $GLOBALS['errormess'] ?>
        </div>
    <?php endif ?>


    <?php if (isset($GLOBALS['sussce'])):  ?>
      <div class="alert alert-success">
        <stron>成功</strong>
        </div>
      <?php endif ?>




      <div class="row">
        <div class="col-md-4">
          
          
            <?php if (isset($current_data)): ?>
              <form action="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $current_data['id'] ?> " method="POST" >
                <h2>编辑 《<?php echo $current_data['name'] ?>》</h2>
                <div class="form-group">
                  <label for="name">名称</label>
                  <input id="name" class="form-control" name="name" type="text" placeholder="分类名称" value="<?php echo $current_data['name'] ?>">
                </div>
                <div class="form-group">
                  <label for="slug">别名</label>
                  <input id="slug" class="form-control" name="slug" type="text" placeholder="slug" value="<?php echo $current_data['slug'] ?>">
                  <p class="help-block">https://parkourhe.com<strong>slug</strong></p>
                </div>
                <div class="form-group">
                  <button class="btn btn-primary" type="submit">保存</button>
                </div>
              </form>
            <?php endif ?>

            <?php if (empty($current_data)):?>
              <form action="<?php echo $_SERVER['PHP_SELF'] ?> " method="POST" >
              <h2>添加新分类目录</h2>
              <div class="form-group">
                <label for="name">名称</label>
                <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
              </div>
              <div class="form-group">
                <label for="slug">别名</label>
                <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
                <p class="help-block">https://parkourhe.com<strong>slug</strong></p>
              </div>
              <div class="form-group">
                <button class="btn btn-primary" type="submit">添加</button>
              </div>
              </form>
            <?php endif ?>
          
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="/admin/categories-delete.php" style="display: none" id="batches_dele">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              
              <?php 
                  foreach ($categories as $value):
               ?>
                  
                <tr>
                <td class="text-center"><input type="checkbox" data-id=<?php echo $value['id'] ?>></td>
                <td><?php echo $value['name'] ?></td>
                <td><?php echo $value['slug'] ?></td>
                <td class="text-center">
                  <a href="/admin/categories.php?id=<?php echo $value['id'] ?> " class="btn btn-info btn-xs">编辑</a>
                  <a href="/admin/categories-delete.php?id=<?php echo $value['id'] ?> " class="btn btn-danger btn-xs">删除</a>
                </td>


             <?php endforeach ?> 
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

<?php $current_pages='categories' ?>
 <?php include 'inc/sidebar.php' ?>
  

  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>
      $(function($){
          var inputelem = $('tbody input');

          var batches_dele = $('#batches_dele');

          var deleteArr =[];
          // 这种方法效率较低
          // inputelem.on('click',function(){
          //       inputelem.each(function(i,item){
          //         console.log($(item).prop('checked'));
          //       });

          // });

          // 方法2

          inputelem.change(function(){

            if ($(this).prop('checked')) {

              // 三种拿到自定义属性的方式
              // console.log(this.dataset['id']);

              // console.log($(this).attr('data-id'));

              // console.log($(this).data('id'));

              deleteArr.push($(this).attr('data-id'));
             
            }else{
              deleteArr.splice(deleteArr.indexOf($(this).attr('data-id'),1));
              
            }

           
            deleteArr.length ? batches_dele.fadeIn():batches_dele.fadeOut(); 

            batches_dele.prop('search','?id='+ deleteArr);


          })




      });


  </script>

  <script>NProgress.done()</script>
</body>
</html>
