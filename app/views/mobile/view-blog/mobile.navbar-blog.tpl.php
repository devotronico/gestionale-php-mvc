<!-- MOBILE NAVBAR BLOG -->
<header>  
  <div id="navbar">
    <a href="/" class="logo">
      <img src="/img/logo/logo.svg" alt="logo">
    </a>
    <div class="toggleNav"></div>
  </div>
  <nav>
    <ul id="nav-list">
      <li class="liPageLink deactive">
        <a class="aPageLink" href="/">Home</a>
      </li>
      <li class="liPageLink <?=$link==='posts'? 'active' : 'deactive'?>">
          <a class="aPageLink" href="/blog/">Posts</a> 
      </li>
      <?php if ( isset($_SESSION['role']) && ($_SESSION['role'] === 'contributor' || $_SESSION['role'] === 'administrator') ) : ?>  
      <li class="liPageLink <?=$link==='create'? 'active' : 'deactive' ?>">
        <a class="aPageLink" href="/post/create">New&nbsp;Post</a>
      </li>
      <?php endif ?>
      <?php if ( isset($_SESSION["user_id"]) ) : ?>
      <li class="liPageLink deactive">
        <a class="aPageLink" href="/profile/<?=$_SESSION['user_id']?>">Profilo</a> 
      </li>
      <li class="liPageLink deactive">
        <a class="aPageLink" href="/auth/logout">Logout</a> 
      </li>
      <?php else: ?>
      <li class="liPageLink deactive">
        <a class="aPageLink" href="/auth/signin/form">Accedi</a> 
      </li>
      <li class="liPageLink deactive">
        <a class="aPageLink" href="/auth/signup/form">Registrati</a> 
      </li>
      <?php endif ?>
    </ul>
  </nav>
</header>  
<!-- END NAVBAR BLOG -->
<div id='risoluzione'></div>
<div id="btn-scroll"><i class="scrollFA fas fa-chevron-circle-up"></i></div>






