<main role="main">
  <div id="wrapper">
  <h1 class="page-title">Accedi</h1>
    <div class="message-container"></div>
    <form action="/auth/signin/access" method="POST" id="signin-form">

      <input type="hidden" name="_csrf" id="signin-token" value="<?=$token?>">

      <!-- <EMAIL> -->
      <div class="form-group">
        <label for="email">email</label>
        <input type="email" name="email" id="signin-email" placeholder="Email" aria-describedby="email" maxlenght="32" autocomplete="username" required>
        <div class="alert alert-danger alert-email" role="alert" hidden></div>
      </div>
      <!-- <EMAIL> -->

      <!-- <PASSWORD> -->
      <div class="form-group">
        <label for="password">password</label>
        <input type="password" name="password" id="signin-password" placeholder="Password" aria-describedby="password" maxlenght="32" autocomplete="current-password" required>
        <div class="alert alert-danger alert-password" role="alert" hidden></div>
        <a href="/auth/password/form"><small>password dimenticata?</small></a>
      </div>
      <!-- </PASSWORD> -->

      <!-- <BUTTON> -->
      <div class="box-btn text-center">
        <button type="submit" id="signin-btn" class="btn btn-submit">Accedi</button>
      </div>
      <!-- </BUTTON> -->
    </form>
  </div>
</main>
