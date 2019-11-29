<main role="main">
    <div id="wrapper">
        <h1 class="page-title">Nessun Documento</h1>
        <form action="/doc/create" method="GET">
            <?php if (isUserAdmin()) : ?>
            <p>Non e` stato ancora creato un documento</p>
            <button type="submit" class="btn btn-submit">Crea&nbsp;un&nbsp;Documento</button>
            <?php endif ?>
        </form>
    </div>
</main>








