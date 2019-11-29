<main role="main">
    <form action="/blog/" method="GET" autocomplete='off'>
        <h1>Errore</h1>
        <?php if (!empty($message)): ?>
        <div class='message'><?=$message?></div>
        <?php endif?>
        <button type="submit" class="button">Riprova</button>
    </form>
</main>






