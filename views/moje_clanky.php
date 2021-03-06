<div class="p-2">
    <h3 class="d-flex justify-content-center">Články</h3>
    <?php if (!$is_banned) : ?>
        <div class="pb-2 mb-2">
            <a class="button new-article" href="moje-clanky/pridat"><i class="fa fa-plus pe-1"></i>Nový</a>
        </div>
    <?php endif ?>
    <?php if (isset($articles) && count($articles) > 0) : ?>
        <?php foreach ($articles as $article) : ?>
            <div id="article-<?=$article['id']?>" class="article">
                <div class="article-header <?php if ($article['published'] !== null) echo $article['published'] ? "article-accepted": "article-dismissed"; ?>">
                    <em><?=$article['authors']?></em>
                    <h4><i class="fa <?php if ($article['published'] !== null) echo $article['published'] ? "fa-check-circle-o": "fa-times-circle-o"; ?>"></i> <?=$article['name']?></h4>
                </div>
                <p class="article-content"><?=nl2br($article['abstract'])?></p>
                <em class="article-timestamp"><?=$article['timestamp']?></em>
                <div class="d-flex justify-content-between article-controls">
                    <div class="d-flex">
                        <?php if (!$is_banned && $article['published'] === null) : ?>
                            <a class="button edit-article" href="moje-clanky/upravit?id=<?=$article['id']?>"><i class="fa fa-pencil"></i> Upravit</a><br>
                        <?php endif ?>
                        <a class="button download-article text-center" href="<?=$article['pdf_path']?>"><i class="fa fa-download"></i> PDF</a>
                    </div>
                    <div>
                        <?php if (!$is_banned) : ?>
                            <a id=<?=$article['id']?> class="button delete-article"><i id=<?=$article['id']?> class="fa fa-trash delete-article"></i></a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    <?php endif ?>
</div>
<script>
    document.getElementById("navbar-collapsed-text").innerText = "Moje články";

    document.addEventListener("click", function(event) {
        let target = event.target;

        if (target.classList.contains("delete-article")) {
            $.ajax({
                url: "ajax/delete_article.php",
                data: {
                    user_id: <?=$user_id?>,
                    article_id: target.id
                },
                success: function(result) {
                    if (!result) {
                        document.querySelector(".article#article-"+target.id).remove();
                    }
                }
            })
        }
    });
</script>