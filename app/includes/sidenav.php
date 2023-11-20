<?php

    require_once 'accounts_access.php';

    $currentRoute = ($logged_page != 'pages/index.php') ? $_GET['route'].'&tmpl_page='.$logged_page.'&page='.$page : 'dashboard.php'; 

?>

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3  bg-dark" id="sidenav-main">
    <div class="sidenav-header d-flex align-items-center">
      <div class="m-3 avatar bg-white text-light rounded-circle" >
        <span class="text-secondary"><?php echo $userLetter; ?></span> 
      </div>
      <h5 class="mt-2 text-bold text-white">Welcome!</h5> 
    </div>

    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <?php foreach ($pages as $name => $url) : ?>
            <li class="nav-item">
                <a class="nav-link text-white <?php echo $url === $currentRoute ? 'active bg-gradient-faded-primary' : ''; ?>" href="index.php?route=<?php echo $url; ?>">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10"><?php echo getIconForPage($name); ?></i>
                    </div>
                    <span class="nav-link-text ms-1"><?php echo $name; ?></span>
                </a>
            </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </aside>
