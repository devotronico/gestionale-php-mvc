<main role="main">
    <section id="posts">
        <?php foreach ($posts as $post) : ?> 
        <article class="post">
        <h1><a class="title" href="/post/<?=$post->post_ID?>"><?=htmlentities($post->title)?></a></h1>
        <p>
            <time datetime="<?=$post->datecreated?>"><?=$post->dateformatted?></time>
            <span>di&nbsp;<a class="author" href="/profile/<?=$post->user_id?>"><?=$post->user_name?>&nbsp;</a>
            <a class="mailto" href="mailto:<?= $post->user_email ?>">&#x2709</a></span>
        </p>
        <p class="messtruncate"><?=$post->messtruncate?>&nbsp;<a class="read" href='/post/<?=$post->post_ID?>'>leggi</a></p>
        <span class="views"><?=$post->views?>&nbsp;visualizzazioni</span>&nbsp;&nbsp;|&nbsp;&nbsp;<span class="comment-num"><?=$post->num_comments?>&nbsp;commenti</span>
        <hr>
        </article>
        <?php endforeach; ?>
    </section>



















