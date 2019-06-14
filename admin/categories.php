<?php 
     // ������޸Ĳ������ѯ����һ��һ���������޸ģ��ٲ�ѯ

      require_once('../functions.php');
      
      $categories=xiu_get_data('SELECT name,slug  from categories;');


      // �����޸���������չʾ
      function add_data(){

     

          if (empty($_POST['name'])||empty($_POST['slug'])) {
            $GLOBALS['errormess'] = '����ȷ��д��';
            return;

          }
          $name = $_POST["name"];

          $slug = $_POST['slug'];

          $affected22 = xiu_execute("insert into categories values (null, '{$slug}', '{$name}');");


      };

      function add_category () {
        if (empty($_POST['name']) || empty($_POST['slug'])) {
          $GLOBALS['message'] = '��������д����';
          $GLOBALS['success'] = false;
          return;
        }

  // ���ղ�����
        $name = $_POST['name'];
        $slug = $_POST['slug'];

  // insert into categories values (null, 'slug', 'name');
        $rows = xiu_execute("insert into categories values (null, '{$slug}', '{$name}');");

        $GLOBALS['success'] = $rows > 0;
        $GLOBALS['message'] = $rows <= 0 ? '���ʧ�ܣ�' : '��ӳɹ���';
      }

      if ($_SERVER['REQUEST_METHOD']==='POST') {
        add_category ();
      }




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
        <h1>����Ŀ¼</h1>
      </div>
      <!-- �д�����Ϣʱչʾ -->
      <?php if (isset($GLOBALS['errormess'])) :?>
            <div class="alert alert-danger">
        <strong>����</strong> <?php echo $GLOBALS['errormess'] ?>
      </div>
    <?php endif ?>
      <div class="row">
        <div class="col-md-4">
          <form action="<?php echo $_SERVER['PHP_SELF'] ?> " method="POST" >
            <h2>����·���Ŀ¼</h2>
            <div class="form-group">
              <label for="name">����</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="��������">
            </div>
            <div class="form-group">
              <label for="slug">����</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">���</button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">����ɾ��</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>����</th>
                <th>Slug</th>
                <th class="text-center" width="100">����</th>
              </tr>
            </thead>
            <tbody>
              
              <?php 
                  foreach ($categories as $value):
               ?>

                <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td><?php echo $value['name'] ?></td>
                <td><?php echo $value['slug'] ?></td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs">�༭</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">ɾ��</a>
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
  <script>NProgress.done()</script>
</body>
</html>