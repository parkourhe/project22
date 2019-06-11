<?php 

      require_once('../config.php');

      SESSION_START();



      function login(){
         if (empty($_POST['email'])) {
           $GLOBALS['errormess'] = '请输入正确邮箱';
           return;
         }
         if (empty($_POST['password'])) {
           $GLOBALS['errormess'] = '请输入正确密码';
           return;
         }

         $email = $_POST['email'];

         $password = $_POST['password'];


        $con = mysqli_connect(XIU_DB_HOST,XIU_DB_USER,XIU_DB_PASS,XIU_DB_NAME);



        if (!$con) {
              exit('服务器繁忙，请稍后再试');
        }


        $query = mysqli_query($con,"SELECT * FROM users WHERE email='{$email}' LIMIT 1");

        $res = mysqli_fetch_assoc($query);


        if (!$res) {
          $GLOBALS['errormess'] = '用户名不存在';
          return;
        }

        var_dump($res);
         
        var_dump(md5(995758538));
        if ($res['password']!==$password) {

          $GLOBALS['errormess'] = '密码错误';
          return;
        }


        header('location:/admin/index.php');

        $_SESSION['cuurent_login'] = $res;


      }

      if ($_SERVER['REQUEST_METHOD']==='POST') {
        login();

      }

 ?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
  <link rel="stylesheet" href="/static/assets/vendors/animate/animate.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap <?php echo isset($GLOBALS['errormess'])?"animated shake":"" ?>" action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST' autocomplete='off' novalidate>
      <img class="avatar" src="/static/assets/img/default.png">
      
      <!-- 有错误信息时展示 -->
      <?php if (isset($GLOBALS['errormess'])):  ?>
       <div class="alert alert-danger">
        <strong>错误！</strong> <?php echo $GLOBALS['errormess']; ?>
      </div>
      <?php endif ?>

      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" type="email" name='email' class="form-control" placeholder="邮箱" autofocus value="<?php echo isset($_POST['email'])?$_POST['email']:"" ?> ">
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" name='password' class="form-control" placeholder="密码">
      </div>
      <button class="btn btn-primary btn-block" type="submit" >登 录</button>
    </form>
  </div>
  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script>
      
      $(function($){
          var emailFormat = /^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]+$/;
          // 目标：在用户输入自己的邮箱过后，页面上展示这个邮箱对应的头像
      // 实现：
      // - 时机：邮箱文本框失去焦点，并且能够拿到文本框中填写的邮箱时
      // - 事情：获取这个文本框中填写的邮箱对应的头像地址，展示到上面的 img 元素上

        $('#email').on('blur',function(){
           var value = $('#email').val();
           if (!value || !emailFormat.test(value)) {
            console.log('test');
              return;
           }

           // 用户输入了一个合理的邮箱地址
        // 获取这个邮箱对应的头像地址
        // 因为客户端的 JS 无法直接操作数据库，应该通过 JS 发送 AJAX 请求 告诉服务端的某个接口，
        // 让这个接口帮助客户端获取头像地址


        $.get('/admin/api/avatar.php',{'email':value},function(res){

              $('.avatar').fadeOut(function(){
                $(this).on('load',function(){
                  $(this).fadeIn()
                }).attr('src',res);
              })

        })

       



        });


      });
      



  </script>

</body>
</html>
