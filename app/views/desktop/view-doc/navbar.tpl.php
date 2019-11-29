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
      <li class="nav-li nav-deactive">
        <a class="aPageLink" href="/">Home</a>
      </li>
      <?php if (isUserAuthenticated()) : ?>
        <?php if (userCanAccess()) : ?>
          <li class="nav-li nav-show <?=$navlink==='doc-list'? 'nav-active' : 'nav-deactive' ?>">
            <a class="aPageLink" href="/doc/list">Docs</a>
          </li>
        <?php endif; ?>
        <?php if (isUserAdmin()) : ?>
          <li class="nav-li <?=$navlink==='doc-create'? 'nav-active' : 'nav-deactive' ?>">
            <a class="aPageLink" href="/doc/create">New&nbsp;Doc</a>
          </li>
        <?php endif; ?>
        <li class="nav-li nav-deactive">
          <a class="aPageLink" href="/user/<?=getUserId()?>"><?=getUserName()?></a>
        </li>
        <li class="nav-li nav-deactive">
          <a class="aPageLink" href="/auth/logout">Logout</a>
        </li>
      <?php else: ?>
      <li class="nav-li nav-deactive">
        <a class="aPageLink" href="/auth/signin">Accedi</a>
      </li>
      <li class="nav-li nav-deactive">
        <a class="aPageLink" href="/auth/signup">Registrati</a>
      </li>
    <?php endif; ?>
    </ul>
  </nav>
</header>
<!-- <div id='risoluzione'></div> -->
<div id="btn-scroll"><i class="scrollFA fas fa-chevron-circle-up"></i></div>
<!-- END NAVBAR AUTH -->

