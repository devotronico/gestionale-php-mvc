<main role="main">
  <form action="/auth/password/save" method="POST" autocomplete='off'>
    <h1>Nuova Password</h1>
    <?php if (!empty($message)): ?>
    <div class='message'><?=$message?>
      <div class="message-close">X</div>
    </div>
    <?php endif?>
        <input type="hidden" name="email" value="<?=isset($_GET['email'])? $_GET['email'] : $_POST['email']?>">
        <label for="email">email</label> 
        <input type="text" placeholder="<?=isset($_GET['email'])? $_GET['email'] : $_POST['email']?>" maxlenght="16" readonly>
        <label for="password">password</label>  
        <input type="password" name="pass" id='password' placeholder="Password" maxlenght="16" required autocomplete='off'>
        <label for="passwordcopy">riscrivi la password</label> 
        <input type="password" name="passconfirm" id='passwordcopy' placeholder="Riscrivi la password" maxlenght="16" required autocomplete='off'>
        <button type="submit" class="button">Salva</button>
  </form>
</main>






