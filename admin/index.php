<?php 
    

    require_once('../functions.php');

    require_once('../config.php');


    xiu_get_current_user(); 


    $article = xiu_get_data('SELECT count(1) as num FROM posts');



    $drafted = xiu_get_data("SELECT count(1) as drafted FROM posts WHERE status='drafted';");


    $published = xiu_get_data("SELECT count(1) as published FROM posts WHERE status='published';");

    $categories = xiu_get_data("SELECT count(1) as categories FROM categories;");

    $comments =xiu_get_data("SELECT count(1) as comments FROM comments;");

    $held =xiu_get_data("SELECT count(1) as held FROM comments WHERE status='held'");




 ?>



<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
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
      <div class="jumbotron text-center">
        <h1>One Belt, One Road</h1>
        <p>Thoughts, stories and ideas.</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.php" role="button">写文章</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <li class="list-group-item"><strong><?php echo $article[0]['num'] ?></strong>篇文章（<strong><?php echo $drafted[0]['drafted'] ?></strong>篇草稿）</li>
              <li class="list-group-item"><strong><?php echo $categories[0]['categories'] ?></strong>个分类</li>
              <li class="list-group-item"><strong><?php echo $comments[0]['comments'] ?></strong>条评论（<strong><?php echo $held[0]['held']; ?></strong>条待审核）</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4">
            <canvas id="myChart" width="400" height="400"></canvas>
        </div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div>
  


  <?php $current_pages='index' ?>
  <?php 
      include 'inc/sidebar.php';

   ?>
   <script src="/static/assets/vendors/Chart.js/Chart.js"></script>
  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['文章', '分类', '评论', '草稿', '待审核'],
        datasets: [{
            label: '# of Votes',
            data: [<?php echo $article[0]['num'] ?>, <?php echo $categories[0]['categories'] ?>, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)'
                
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
                
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>
  <script>NProgress.done()</script>
</body>
</html>
