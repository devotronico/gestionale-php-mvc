<main role="main">
    <form action='/blog/' method='GET'>
        <?php if (isset($_SESSION['user_id'])): ?>
        <h1>Login riuscito</h1>
        <button type='submit' class="button">Entra</button>
        <?php else: ?>
        <h1>Attiva il tuo account</h1>
        <div class='message'>
        Prima di loggarti ti chiediamo di confermare la tua iscrizione.<br>Un link di conferma è stato mandato alla tua casella di posta <strong><?=$email?></strong><br>Per verificare il tuo account clicca sul link che trovi nella mail che ti abbiamo inviato!
        </div>
        <?php endif ?>
    </form>
</main>








