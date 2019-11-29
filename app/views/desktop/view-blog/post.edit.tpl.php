<main role="main">
    <form action="/post/<?=$post->post_ID?>/update" method="POST" enctype="multipart/form-data">
        <h1>Modifica il post</h1>
        <?php if ( isset($_GET['message']) ): ?>
        <div class='message'><?=$_GET['message']?>
        <div class="message-close">X</div>
        </div><?php endif?>
        <label for="title">Titolo</label>
        <input type="text" name="title" id="title" value="<?=$post->title?>" required>
        <input type="hidden" name="MAX_FILE_SIZE" value="<?=$bytes?>" />
        <label for="image">Immagine</label>
        <input type="file" name="file" id="image"> 
        <small>il file deve essere minore di&nbsp;<?=$megabytes?>&nbsp;megabytes</small>
        <label for="textarea">Testo</label>
        <textarea name="text" id="textarea" rows='7' maxlenght="2000" required><?=$post->message?></textarea>
        <button type="submit" class="button">Salva</button>
    </form>
</main>
