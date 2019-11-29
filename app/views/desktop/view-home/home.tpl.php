<!-- <HOME> -->
<main role="main">
    <div id="wrapper">
        <?php if (isset($_GET['message'])) : ?>
        <div class="alert alert-danger alert-message" role="alert"><?=$_GET['message']?></div>
        <?php endif; ?>
        <div id="cover__box-photo">
            <img id='cover__photo' src='/img/logo/<?=$logo?>.svg'>
        </div>
        <div id="cover__box-info">
            <h1 class="page-title">Gestionale</h1>
            <a class="cover__btn" href="#contact">Contact Me</a>
        </div>
    </div>
</main>
<!-- </HOME> -->