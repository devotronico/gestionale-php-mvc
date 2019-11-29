<main role="main">
    <table class="docs-table">
        <thead class="docs-thead">
            <tr class="docs-row">
            <th class="docs-th">id</th>
            <th class="docs-th">cliente_id</th>
            <th class="docs-th">fornitore_id</th>
            <th class="docs-th">pagamento_id</th>
            <th class="docs-th">data</th>
            <th class="docs-th">importo</th>
            </tr>
        </thead>
        <tbody class="docs-tbody">
            <?php foreach ($docs as $doc) : ?>
            <tr class="docs-row">
                <td class="docs-td"><?=$doc->id?></td>
                <td class="docs-td"><?=$doc->cliente_id?></td>
                <td class="docs-td"><?=$doc->fornitore_id?></td>
                <td class="docs-td"><?=$doc->pagamento_id?></td>
                <td class="docs-td"><?=$doc->data?></td>
                <td class="docs-td"><?=$doc->importo?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>




<!-- <article class="post">
        <h1><a class="title" href="/post/<?=$post->post_ID?>"><?=htmlentities($post->title)?></a></h1>
        <p>
            <time datetime="<?=$post->datecreated?>"><?=$post->dateformatted?></time>
            <span>di&nbsp;<a class="author" href="/profile/<?=$post->user_id?>"><?=$post->user_name?>&nbsp;</a>
            <a class="mailto" href="mailto:<?= $post->user_email ?>">&#x2709</a></span>
        </p>
        <p class="messtruncate"><?=$post->messtruncate?>&nbsp;<a class="read" href='/post/<?=$post->post_ID?>'>leggi</a></p>
        <span class="views"><?=$post->views?>&nbsp;visualizzazioni</span>&nbsp;&nbsp;|&nbsp;&nbsp;<span class="comment-num"><?=$post->num_comments?>&nbsp;commenti</span>
        <hr>
        </article> -->



















