<div class="p-3">
    <h3>Správa uživatelů</h3>
    <div class="overflow-auto">
        <table class="user-management-table">
            <thead>
                <th>Povolen</th>
                <th>Jméno</th>
                <th>Login</th>
                <th>Role</th>
            </thead>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td>
                    <?php if (!$is_banned) : ?>
                        <div class="user-state d-flex justify-content-center" id=<?=$user['id']?>>
                            <?php if ($user['weight'] < $logged_weight) : ?>
                                <?php if ($user['banned']) : ?>
                                    <button class="user-disabled ban-edit" id=<?=$user['id']?>>
                                        <i class="fa fa-times-circle ban-edit" id=<?=$user['id']?>></i>
                                    </button>
                                <?php else : ?>
                                    <button class="user-enabled ban-edit" id=<?=$user['id']?>>
                                        <i class="fa fa-check-circle ban-edit" id=<?=$user['id']?>></i>
                                    </button>
                                <?php endif ?>
                            <?php endif ?>
                        </div>
                    <?php endif ?>
                    </td>

                    <td><?=$user['full_name']?></td>
                    <td><?=$user['username']?></td>
                    <td>
                    <?php if (!$is_banned) : ?>
                        <?php if ($user['weight'] < $logged_weight) : ?>
                            <select name="role">
                                <?php if ($is_super) : ?>
                                    <option id=<?=$user['id']?> class="role-edit" value=1 <?php if ($user['id_user_rights'] == 1) echo("selected"); ?>>SuperAdmin</option>
                                    <option id=<?=$user['id']?> class="role-edit" value=2 <?php if ($user['id_user_rights'] == 2) echo("selected"); ?>>Admin</option>
                                <?php endif ?>
                                <option id=<?=$user['id']?> class="role-edit" value=3 <?php if ($user['id_user_rights'] == 3) echo("selected"); ?>>Recenzent</option>
                                <option id=<?=$user['id']?> class="role-edit" value=4 <?php if ($user['id_user_rights'] == 4) echo("selected"); ?>>Autor</option>
                            </select>
                        <?php else : ?>
                            <?=$user['name']?>
                        <?php endif ?>
                    <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>
<script>
    document.getElementById("navbar-collapsed-text").innerText = "Správa uživatelů";
    if (window.history.replaceState) window.history.replaceState(null, null, window.location.href);

    document.addEventListener("click", function(event) {
        let target = event.target;
        if (!target.classList.contains("ban-edit") && !target.classList.contains("role-edit")) return;

        if (target.classList.contains("ban-edit")) {
            $.ajax({
                url: "ajax/uzivatel_edit.php",
                data: {
                    admin_id: <?=$user_id?>,
                    id: target.id,
                    toggle_ban: true
                },
                success: function(result) {
                    updateUserState(target.id, result);
                }
            })
        }

        if (target.classList.contains("role-edit")) {
            $.ajax({
                url: "ajax/uzivatel_edit.php",
                data: {
                    admin_id: <?=$user_id?>,
                    id: target.id,
                    new_role: target.value
                }
            })
        }
    })

    function updateUserState(id, banned) {
        if (banned == "true") {
            $(".user-state#"+id).html('<button class="user-disabled ban-edit" id='+id+'><i class="fa fa-times-circle ban-edit" id='+id+'></i></button>');
        }
        else {
            $(".user-state#"+id).html('<button class="user-enabled ban-edit" id='+id+'><i class="fa fa-check-circle ban-edit" id='+id+'></i></button>');
        }
    }
</script>