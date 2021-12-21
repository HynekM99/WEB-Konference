<div class="p-2">
    <h3>
        Přihlášení
    </h3>
    <div class="d-flex justify-content-center">
        <form class="login-form" method="post">
            <?php if (isset($dataValid) && $dataValid == false) : ?>
                <span class="d-flex justify-content-center text-danger">
                    Zadané údaje jsou nesprávné.
                </span>
            <?php endif ?>

            <label for="name-or-email">Jméno/email</label>
            <div class="d-flex justify-content-center">
                <i class="fa fa-user input-sign"></i>
                <input type="text" id="name-or-email" name="name-or-email" placeholder="..." required>  
            </div>
            <label for="password">Heslo</label>
            <div class="d-flex justify-content-center">
                <i class="fa fa-lock input-sign"></i>
                <input type="password" id="password" name="password" placeholder="..." required/>
            </div><br>
            <div class="d-flex justify-content-center">
                <button name="submit" type="submit" class="submit"></i>Přihlásit</button>
            </div>
            <div class="d-flex justify-content-center">
                <a href="registrace">Registrovat</a>
            </div>
        </form>
    </div>
</div>
<script>
    document.getElementById("login").classList.add("selected");
    document.getElementById("navbar-collapsed-text").innerText = "Přihlášení";
    if (window.history.replaceState) window.history.replaceState(null, null, window.location.href);
</script>