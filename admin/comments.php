<?php 
       // 如果是修改操作与查询操作一起，一定是先做修改，再查询
      
      require_once('../functions.php');
      

      // 验证当前登陆用户
    xiu_get_current_user(); 

 ?>


<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
  <script src="/static/assets/vendors/nprogress/nprogress.js"></script>
  <style type="text/css">@keyframes lds-spinner {
    0% {
      opacity: 1;
    }
    100% {
      opacity: 0;
    }
  }
  @-webkit-keyframes lds-spinner {
    0% {
      opacity: 1;
    }
    100% {
      opacity: 0;
    }
  }
  .lds-spinner {
    position: relative;
  }
  .lds-spinner div {
    left: 94px;
    top: 48px;
    position: absolute;
    -webkit-animation: lds-spinner linear 1s infinite;
    animation: lds-spinner linear 1s infinite;
    background: #93dbe9;
    width: 12px;
    height: 24px;
    border-radius: 40%;
    -webkit-transform-origin: 6px 52px;
    transform-origin: 6px 52px;
  }
  .lds-spinner div:nth-child(1) {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
    -webkit-animation-delay: -0.916666666666667s;
    animation-delay: -0.916666666666667s;
  }
  .lds-spinner div:nth-child(2) {
    -webkit-transform: rotate(30deg);
    transform: rotate(30deg);
    -webkit-animation-delay: -0.833333333333333s;
    animation-delay: -0.833333333333333s;
  }
  .lds-spinner div:nth-child(3) {
    -webkit-transform: rotate(60deg);
    transform: rotate(60deg);
    -webkit-animation-delay: -0.75s;
    animation-delay: -0.75s;
  }
  .lds-spinner div:nth-child(4) {
    -webkit-transform: rotate(90deg);
    transform: rotate(90deg);
    -webkit-animation-delay: -0.666666666666667s;
    animation-delay: -0.666666666666667s;
  }
  .lds-spinner div:nth-child(5) {
    -webkit-transform: rotate(120deg);
    transform: rotate(120deg);
    -webkit-animation-delay: -0.583333333333333s;
    animation-delay: -0.583333333333333s;
  }
  .lds-spinner div:nth-child(6) {
    -webkit-transform: rotate(150deg);
    transform: rotate(150deg);
    -webkit-animation-delay: -0.5s;
    animation-delay: -0.5s;
  }
  .lds-spinner div:nth-child(7) {
    -webkit-transform: rotate(180deg);
    transform: rotate(180deg);
    -webkit-animation-delay: -0.416666666666667s;
    animation-delay: -0.416666666666667s;
  }
  .lds-spinner div:nth-child(8) {
    -webkit-transform: rotate(210deg);
    transform: rotate(210deg);
    -webkit-animation-delay: -0.333333333333333s;
    animation-delay: -0.333333333333333s;
  }
  .lds-spinner div:nth-child(9) {
    -webkit-transform: rotate(240deg);
    transform: rotate(240deg);
    -webkit-animation-delay: -0.25s;
    animation-delay: -0.25s;
  }
  .lds-spinner div:nth-child(10) {
    -webkit-transform: rotate(270deg);
    transform: rotate(270deg);
    -webkit-animation-delay: -0.166666666666667s;
    animation-delay: -0.166666666666667s;
  }
  .lds-spinner div:nth-child(11) {
    -webkit-transform: rotate(300deg);
    transform: rotate(300deg);
    -webkit-animation-delay: -0.083333333333333s;
    animation-delay: -0.083333333333333s;
  }
  .lds-spinner div:nth-child(12) {
    -webkit-transform: rotate(330deg);
    transform: rotate(330deg);
    -webkit-animation-delay: 0s;
    animation-delay: 0s;
  }
  .lds-spinner {
    width: 200px !important;
    height: 200px !important;
    -webkit-transform: translate(-100px, -100px) scale(1) translate(100px, 100px);
    transform: translate(-100px, -100px) scale(1) translate(100px, 100px);
  }
  .lds-css{
    position: absolute;
    top: 50%;
    left: 50%;
    z-index: 999;
  }
  .lds-spinner{
    margin-left: -50%;
    margin-top: -50%;
  }
</style>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php  include 'inc/navbar.php' ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm">批量批准</button>
          <button class="btn btn-warning btn-sm">批量拒绝</button>
          <button class="btn btn-danger btn-sm" id="batches_dele">批量删除</button>
        </div>
        <ul class="pagination pagination-sm pull-right">
          <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li>
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="150">操作</th>
          </tr>
        </thead>
        <tbody>
   
        </tbody>
      </table>
    </div>
  </div>


  <!-- loading进度条 -->
  <div class="lds-css ng-scope" style="display: none" id="loading">
    <div class="lds-spinner" style="width:100%;height:100%"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
  </div>

  <?php $current_pages='comments' ?>
  <?php include 'inc/sidebar.php' ?>
  <script type="text/js-render" id="tmp1">
   {{for comments}}
   <tr {{if status=='held'}}
   class="warning"
   {{else status=='rejected'}}
   class='danger' 
   {{/if}}  data-id='{{:id}}'>
   <td class="text-center"><input type="checkbox"></td>
   <td>{{:author}}</td>
   <td>{{:content}}</td>
   <td>《{{:title}}》</td>
   <td>{{:created}}</td>
   <td>{{:status}}</td>
   <td class="text-center">
    {{if status=='held'}}
    <a href="post-add.php" class="btn btn-info btn-xs">批准</a>
    <a href="post-add.php" class="btn btn-warning btn-xs">拒绝</a>
    {{else status=='rejected'}}
    <a href="post-add.php" class="btn btn-info btn-xs">批准</a>
    {{else}}
    {{/if}}
    <a href="javascript:;" class="btn btn-danger btn-xs btn-delete">删除</a>
  </td>
</tr>
{{/for}}
</script>
<script src="/static/assets/vendors/jquery/jquery.js"></script>
<script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
<script src="/static/assets/vendors/jsrender/jsrender.js"></script>
<script src="/static/assets/vendors/twbs-pagination/jquery.twbsPagination.js"></script>
<script>


        $(document).ajaxStart(function(){
          NProgress.start();
          $('#loading').fadeIn();

        })
        $(document).ajaxStop(function(){
          NProgress.done();
          $('#loading').fadeOut();
        })


       


    // ajax请求加载页面      


    var current_pages=1;

      function load_data(page) {
        $.get('/admin/api/comments-data.php',{page:page},function(res){    
          var html = $("#tmp1").render({comments : res.comment});
          console.log(res);
          if (page>res.total_page) {
            page=res.total_page;
          }
          // 分页器操作
          $('.pagination').twbsPagination({

            totalPages:res.total_page,
            visiablePages:5,
            startPage:page,
            initiateStartPageClick: false,
            onPageClick:function(e,page){
              // $('tbody').fadeOut();
              load_data(page);
              $('tbody').fadeOut();
            }

          })
          $("tbody").html(html).fadeIn();
          current_pages=page;
       });

      }
      

      load_data(1);
     
       // 事件冒泡判断点击源头
        $('tbody').on('click','.btn-delete',function(){
          var id=$(this).parent().parent().data('id');

          $.get('/admin/api/comments-delete.php',{id:id},function(res){

              // 如果删除成功就重新加载页面
                if (res) {
                  load_data(current_pages);         
                }
                

          })

        })



  </script>
  <script>NProgress.done()</script>
</body>
</html>
