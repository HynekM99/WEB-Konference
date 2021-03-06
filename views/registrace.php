<div class="p-3">
    <h3>
        Registrace
    </h3>

    <div class="d-flex justify-content-center">
        <form class="register-form" method="post" onsubmit="return checkPasswords()">
            <?php if (isset($usernameExists) && $usernameExists == true) : ?>
                <span class="text-danger">
                    Uživatel se zadaným uživatelským jménem již existuje.
                </span><br>
            <?php endif ?>
            <?php if (isset($emailExists) && $emailExists == true) : ?>
                <span class="text-danger">
                    Uživatel se zadaným emailem již existuje.
                </span>
            <?php endif ?>

            <label for="name">Celé jméno</label>
            <div class="d-flex justify-content-center pb-2">
                <i class="fa fa-user-o input-sign"></i>
                <input type="text" id="name" name="name" placeholder="Jan Novák..." required>
            </div>

            <label for="username">Uživatelské jméno</label>
            <div class="d-flex justify-content-center pb-2">
                <i class="fa fa-user input-sign"></i>
                <input type="text" id="username" name="username" placeholder="jnovak123..." required>
            </div>
            
            <label for="password">Heslo</label>
            <div class="d-flex justify-content-center pb-2">
                <i class="fa fa-unlock-alt input-sign"></i>
                <input type="password" id="password" name="password" placeholder="..." required>
            </div>
            
            <label for="password-confirm">Potvrďte heslo</label>
            <div class="d-flex justify-content-center pb-2">
                <i class="fa fa-unlock-alt input-sign"></i>
                <input type="password" id="password-confirm" name="password-confirm" placeholder="..." required>
            </div>
            
            <div id="password-mismatch">
                <span class="text-danger pb-2">Hesla se neshodují</span>
            </div>
            
            <label for="email">Email</label>
            <div class="d-flex justify-content-center pb-2">
                <i class="fa fa-at input-sign"></i>
                <input type="email" id="email" name="email" placeholder="jnovak123@gmail.com..." required>
            </div>
            <br>
            <div class="d-flex justify-content-center">
                <button name="submit" type="submit" id="submit" class="submit"><i class="fa fa-check"></i> Registrovat</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.getElementById("navbar-collapsed-text").innerText = "Registrace";
    if (window.history.replaceState) window.history.replaceState(null, null, window.location.href);

    $("#password").keyup(checkPasswords);
    $("#password-confirm").keyup(checkPasswords);
    $("#password-mismatch").hide();

    function checkPasswords() {
        if ($("#password").val().length == 0 || $("#password-confirm").val().length == 0) {
            $("#password-mismatch").hide();
            return false;
        }
        if ($("#password").val() !== $("#password-confirm").val()) {
            $("#password-mismatch").show();
            return false;
        }
        $("#password-mismatch").hide();
        return true;
    }
</script>