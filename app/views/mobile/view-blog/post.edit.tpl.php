<main role="main">
    <form action="/post/<?=$post->post_ID?>/update" method="POST" enctype="multipart/form-data">
        <h1>Modifica il post</h1>
        <label for="title">Titolo</label>
        <input type="text" name="title" id="title" value="<?=$post->title?>" required>
        <label for="image">Immagine</label>
        <input type="file" name="file" id="image"> 
        <small>il file deve essere minore di&nbsp;<?=$megabytes?>&nbsp;megabytes</small>
        <label for="textarea">Testo</label>
        <textarea name="message" id="textarea" rows='7' maxlenght="2000" required><?=$post->message?></textarea>
        <button type="submit" class="button">Salva</button>
    </form>
</main>
