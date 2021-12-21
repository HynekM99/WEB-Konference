<!DOCTYPE html>
<html lang="cs-cz">
<head>
    <base href="/localhost"/>
    <meta charset="UTF-8"/>
    <meta content='width=device-width' name='viewport'>
    <title><?= $title?></title>
    <meta name="description" content="<?= $description?>"/>
    <meta name="keywords" content="<?= $keywords?>"/>

    <link rel="stylesheet" href="/src/css/style.css">
    <link rel="stylesheet" href="/src/node_modules/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="/src/node_modules/bootstrap/dist/css/bootstrap.css">
    <script src="/src/node_modules/jquery/dist/jquery.js"></script>
    <script src="/src/node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
</head>

<body>
    <div class="wrapper navigation">
        <nav class="container navbar navbar-expand-sm navbar-toggleable-sm p-0">
            <button 
            class="navbar-toggler shadow-none border-0 pt-2 pb-2" 
            type="button" 
            data-bs-toggle="collapse" 
            data-bs-target=".navbar-collapse" 
            aria-controls="navbar-collapse" 
            aria-expanded="false" 
            aria-label="Toggle navigation">
                <h5 id="navbar-collapsed-text" class="m-0 pt-1 pb-1">
                    Nabídka
                </h5>
            </button>
            <button 
            class="navbar-toggler shadow-none border-0" 
            type="button" 
            data-bs-toggle="collapse" 
            data-bs-target=".navbar-collapse" 
            aria-controls="navbar-collapse" 
            aria-expanded="false" 
            aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse d-sm-inline-flex justify-content-between">
                <ul class="navbar-nav">
                    <li class="nav-item"><a id="uvod" class="nav-link" href="uvod">Úvod</a></li>
                    <li class="nav-item"><a id="clanky" class="nav-link" href="clanky">Články</a></li>
                </ul>
                <ul class="navbar-nav">
                <?php if ($logged_in) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php if ($is_author) : ?>
                                <i class="fa fa-book"></i>
                            <?php elseif ($is_reviewer) : ?>
                                <i class="fa fa-star"></i>
                            <?php elseif ($is_admin) : ?>
                                <i class="fa fa-user-plus"></i>
                            <?php elseif ($is_super) : ?>
                                <i class="fa fa-user-secret"></i>
                            <?php endif ?>
                            <?= $username?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <?php if ($is_author) : ?>
                                <li><a class="dropdown-item" href="moje-clanky">Moje články</a></li>
                            <?php elseif ($is_reviewer) : ?>
                                <li><a class="dropdown-item" href="moje-recenze">Moje recenze</a></li>
                            <?php elseif ($is_super || $is_admin) : ?>
                                <li><a class="dropdown-item" href="sprava-clanku">Správa článků</a></li>
                                <li><a class="dropdown-item" href="uzivatele">Správa uživatelů</a></li>
                            <?php endif ?>
                            
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout">Odhlásit</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li class="nav-item"><a id="login" class="nav-link" href="login"><i class="fa fa-user-o"></i> Přihlásit</a></li>
                <?php endif ?>
                
                </ul>
            </div>
        </nav>
    </div>
    <article class="container">
        <?php $this->controller->return_view();?>
    </article>
    <footer>
        <div class="p-2 text-center">
            © 2021 Hynek Moudrý
        </div>
    </footer>
</body>
</html>