<main role="main">
    <h1>Profilo di&nbsp;<?=$data->name?></h1>
    <!-- <img src="/img/auth/<?=!empty($data->user_image)?$data->user_image:'default.jpg'?>" alt="avatar personale"> -->
    <table>
        <tbody>
            <tr>
                <td>Nome</td>
                <td><?=$data->name?></td>
            </tr>
            <tr>
                <td>Permessi</td>
                <td><?=$data->roletype?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?=$data->email?></td>
            </tr>
            <tr>
                <td>Data Registrazione</td>
                <td><?=$data->created_at?></td>
            </tr>
            <?php if (isset($_SESSION['roletype']) && $_SESSION['roletype'] === 'admin') :?>
            <tr>
                <td>Modifica permessi</td>
                <td>
                    <a href='/user/<?=$data->id?>/banned'>banned</a>
                    <a href='/user/<?=$data->id?>/reader'>reader</a>
                    <a href='/user/<?=$data->id?>/contributor'>contributor</a>
                    <a href='/user/<?=$data->id?>/admin'>administrator</a>
                </td>
            </tr>
            <?php endif;?>
            <?php if ($data->roletype !== 'reader') : ?>
            <tr>
                <td>Totale post</td>
                <td>totlae numero post</td>
                <!-- <td><?=$data->user_num_posts?></!-->
            </tr>
            <tr>
                <td>
                    <p>Ultimo post<br>
                    <!-- <?=$data->dateformatted?> -->
                    </p>
                </td>
                <td>titolo ultimo post</td>
                <!-- <td><?=isset($data->title)?"<a href='/post/$data->post_ID'>$data->title</a>":'nessun post pubblicato'?></!--> -->
            </tr>
            <?php endif;?>
            <tr>
                <td>Totale commenti</td>
                <td>numero commenti</td>
                <!-- <td><?=$data->user_num_comments?></td> -->
            </tr>
            <tr>
                <td><p>Ultimo commento<br>00/00/0000</p></td>
                <!-- <td><p>Ultimo commento<br><?=$data->c_dateformatted?></p></td> -->
                <!-- <td><?=isset($data->comment)?"<a href='/post/$data->post_id'>$data->comment</a>":'nessun commento pubblicato'?></!--> -->
            </tr>
        </tbody>
    </table>
</main>









