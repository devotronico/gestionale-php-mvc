<main role="main">
  <form action='/auth/signin/access' method='POST'>
    <h1>Accedi</h1>
    <?php if (!empty($message)): ?>
    <div class='message'><?=$message?>
    <div class="message-close">X</div>
    </div>
    <?php endif?>
    <label for='email'>email</label> 
    <input type='email' name='email' id='email' placeholder='Email' aria-describedby='email' maxlenght="32" required>
    <label for='password'>password</label>  
    <input type='password' name='password' id='password' placeholder='Password' aria-describedby='password' maxlenght="32" required>
    <a href='/auth/password/form'><small>password dimenticata?</small></a>
    <button type='submit' class="button">Accedi</button>
  </form>
</main>
