<main role="main">
    <div id="wrapper">
        <h1 class="page-title">Registrati</h1>
        <div class="message-container"></div>
        <form action="/auth/signup/store" enctype="multipart/form-data" method="POST">

            <!-- <IMAGE> -->
            <div class="form-group">
                <small>carica un immagine per il tuo profilo</small>
                <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                <input type="file" name="file" size="<?=$bytes?>" accept="<?=$acceptFileType?>">
                <small>il file deve essere minore di&nbsp;<?=$megabytes?>&nbsp;megabytes</small>
            </div>
            <!-- </IMAGE> -->


            <!-- <NAME> -->
            <div class="form-group">
                <label for="username">username</label>
                <input type="text" name="username" id="signup-name" class="signup-input" aria-describedby="username" placeholder="Username" maxlenght="32" autocomplete="username">
                <div class="alert alert-danger alert-name" role="alert" hidden></div>
            </div>
            <!-- </NAME> -->

            <!-- <EMAIL> -->
            <div class="form-group">
                <label for="email">email</label>
                <input type="email" name="email" id="signup-email" class="signup-input" aria-describedby="email" placeholder="Email *" value="<?=isset($_POST['email'])? $_POST['email'] : false ?>" maxlenght="32" autocomplete="username" required>
                <div class="alert alert-danger alert-email" role="alert" hidden></div>
            </div>
            <!-- </EMAIL> -->

            <!-- <PASSWORD> -->
            <div class="form-group">
                <label for="password">password</label>
                <input type="password" name="password" id="signup-password" class="signup-input" placeholder="Password *" aria-describedby="password" maxlenght="32" autocomplete="off" autocomplete="new-password" required>
                <div class="alert alert-danger alert-password" role="alert" hidden></div>
                <small>la password deve avere minimo 8 caratteri</small>
            </div>
            <!-- </PASSWORD> -->

            <!-- <BUTTON> -->
            <div class="box-btn text-center">
                <button type="submit" id="signup-btn" class="btn btn-submit">Registrati</button>
            </div>
            <!-- </BUTTON> -->
        </form>
    </div>
</main>

