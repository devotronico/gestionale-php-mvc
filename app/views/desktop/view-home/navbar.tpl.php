<!-- MOBILE NAVBAR AUTH -->
<header>
  <div id="navbar">
    <a href="/" id="logo-link">
      <img id="logo-img" src="/img/logo/logo.svg" alt="logo">
    </a>
    <div class="toggleNav"></div>
  </div>
  <nav>
    <ul id="nav-list">
      <li class="nav-li nav-show nav-deactive">
        <a class="nav-link" href="/test/index.php">Home</a>
      </li>
      <li class="nav-li nav-show <?=$navlink==='home'? 'nav-active' : 'nav-deactive'?>">
        <a class="nav-link" href="/">Home</a>
      </li>
      <?php if (isUserAuthenticated()) : ?>
      <li class="nav-li nav-show nav-deactive">
          <a class="nav-link" href="/doc/list">Docs</a>
      </li>
      <li class="nav-li nav-show nav-deactive">
          <a class="nav-link" href="/doc/create">New&nbsp;Doc</a>
      </li>
      <li class="nav-li nav-show nav-deactive">
        <a class="nav-link" href="/user/<?=getUserId()?>"><?=getUserName()?></a>
      </li>
      <li class="nav-li nav-show nav-deactive">
          <a class="nav-link" href="/auth/logout">Logout</a>
      </li>
      <?php else : ?>
      <li class="nav-li nav-show nav-deactive">
        <a class="nav-link" href="/auth/signin">Accedi</a>
      </li>
      <li class="nav-li nav-show nav-deactive">
        <a class="nav-link" href="/auth/signup">Registrati</a>
      </li>
      <!-- <li class="nav-li nav-hide nav-deactive">
          <a class="nav-link" href="/doc/list">Docs</a>
      </li>
      <li class="nav-li nav-hide nav-deactive">
          <a class="nav-link" href="/doc/create">New&nbsp;Doc</a>
      </li> -->
      <li class="nav-li nav-hide nav-deactive">
          <a class="nav-link" href=""></a>
      </li>
      <?php endif ; ?>
    </ul>
  </nav>
</header>
<!-- <div id='risoluzione'></div> -->
<div id="btn-scroll"><i class="scrollFA fas fa-chevron-circle-up"></i></div>
<!-- END NAVBAR AUTH -->

