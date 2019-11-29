<main role="main">
    <form action="/post/save" method="POST" enctype="multipart/form-data">
        <h1>Crea un nuovo post</h1>
        <?php if ( isset($message) ): ?>
        <div class='message'><?=$message?>
        <div class="message-close">X</div>
        </div><?php endif?>
        <label for="title">Titolo</label>
        <input type="text" name="title" id="title" placeholder="Titolo del post" maxlenght="64" value="<?=isset($_POST['title'])? $_POST['title'] : false ?>" required>
        <label for="image">Immagine</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
        <input type="file" name="file" id="image" size="<?=$bytes?>" accept="<?=$acceptFileType?>"> 
        <small>il file deve essere minore di&nbsp;<?=$megabytes?>&nbsp;megabytes</small>
        <small class="preview">ciao</small>
        <label for="textarea">Messaggio</label>
        <textarea name="text" id="textarea" rows='7' placeholder="Testo del post" maxlenght="2000" required><?=isset($_POST['text'])? $_POST['text'] : false ?></textarea>
        <button type='submit' class="button">Salva</button>
    </form>
</main>
