<main role="main">
    <form action='/auth/signup/store' method='POST' autocomplete='off' enctype="multipart/form-data">
        <h1>Registrati</h1>
        <?php if (!empty($imgMessage)): ?>
        <div class='message'><?= $imgMessage ?>
            <div class="message-close">X</div>
        </div>
        <?php endif?>
        <small>carica un immagine per il tuo profilo</small>   
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
        <input type="file" name="file" size="<?=$bytes?>" accept="<?=$acceptFileType?>"> 
        <small>il file deve essere minore di&nbsp;<?=$megabytes?>&nbsp;megabytes</small>   
       
        <?php if (!empty($message)): ?>
        <div class='message'><?=$message?>
            <div class="message-close">X</div>
        </div>
        <?php endif?>
        <label for='username'>username</label> 
        <input type='text' name='username' id='username' aria-describedby='username' placeholder='Username' maxlenght="32" autocomplete="off">
        <label for='email'>email</label> 
        <input type='email' name='email' id='email' aria-describedby='email' placeholder='Email *' value="<?=isset($_POST['email'])? $_POST['email'] : false ?>" required  maxlenght="32" autocomplete="off">
        <label for='password'>password</label> 
        <input type='password' name='password' id='password' placeholder='Password *' aria-describedby='password' required maxlenght="32" autocomplete="off">
        <small>la password deve avere minimo 8 caratteri</small>
        <button type='submit' class="button">Registrati</button>
    </form>
</main>

