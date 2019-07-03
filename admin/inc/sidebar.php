<!-- 使用php_self可以直接拿到当前URL，可以用来代替$current; -->
  <?php 

      

      $xiu_current_user = $_SESSION['cuurent_login'];

      $current_pages = isset($current_pages)?$current_pages:'';


 ?>

<div class="aside">
    <div class="profile">
      <img class="avatar" src="<?php echo $xiu_current_user['avatar'] ?> ">
      <h3 class="name"><?php echo $xiu_current_user['nickname']; ?></h3>
    </div>
    <ul class="nav">
      <li <?php echo $current_pages === 'index'? "class=active":"" ?>>
        <a href="index.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>

      <?php $list = array('posts','post-add','categories') ?>
      <li <?php echo in_array($current_pages,$list)?'class=active':'' ?>>
        <a href="#menu-posts" class="collapsed" data-toggle="collapse">
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" class="collapse <?php echo in_array($current_pages,$list)?"in":'' ?>">
          <li <?php echo $current_pages==='posts' ?'class=active':'' ?>><a href="posts.php">所有文章</a></li>
          <li <?php echo $current_pages==='post-add' ?'class=active':'' ?>><a href="post-add.php">写文章</a></li>
          <li <?php echo $current_pages==='categories' ?'class=active':'' ?>><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
      <li <?php echo $current_pages==='comments'?'class=active':'' ?>>
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <li <?php echo $current_pages==='users'?'class=active':'' ?>>
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>

      <?php $list2 =array('nav-menus','slides','settings') ?>
      <li <?php echo in_array($current_pages,$list2)?'class=active':'' ?>>
        <a href="#menu-settings" class="collapsed" data-toggle="collapse">
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse <?php echo in_array($current_pages,$list2)?'in':'' ?>">
          <li <?php echo $current_pages==='nav-menus'?'class=active':'' ?>><a href="nav-menus.php">导航菜单</a></li>
          <li <?php echo $current_pages==='slides'?'class=active':'' ?>><a href="slides.php">图片轮播</a></li>
          <li <?php echo $current_pages==='settings'?'class=active':'' ?>><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
      <li <?php echo $current_pages === 'movie.php'? "class=active":"" ?>>
        <a href="movie.php"><i class="fa fa-dashboard"></i>电影</a>
      </li>
    </ul>
  </div>
