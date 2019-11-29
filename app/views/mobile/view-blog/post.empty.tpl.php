<main role="main">
    <form action='/post/create' method='GET'>
        <h1>Blog vuoto</h1>
        <?php if ( isset($_SESSION['role']) &&  $_SESSION['role'] != 'reader' ) : ?>  
        <div class='message'>Crea il tuo primo post</div>
        <button>New&nbsp;Post</button>
        <?php endif ?>
    </form>
</main>





