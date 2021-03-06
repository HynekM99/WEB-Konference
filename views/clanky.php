<div class="p-2">
<?php if (!isset($articles) || count($articles) <= 0) : ?>
    <h3 class="d-flex justify-content-center">Žádné články</h3>
<?php else : ?>
    <h3 class="d-flex justify-content-center">Publikované články</h3>
    <?php foreach ($articles as $article) : ?>
        <div class="article">
            <div class="article-header">
                <em><?=$article['authors']?></em>
                <h4><?=$article['name']?></h4>
            </div>
            <p class="article-content"><?=nl2br($article['abstract'])?></p>
            <em class="article-timestamp"><?=$article['timestamp']?></em>
            <div class="article-controls">
                <a class="button download-article" href="<?=$article['pdf_path']?>"><i class="fa fa-download"></i> PDF</a>
            </div>
        </div>
    <?php endforeach ?>
<?php endif ?>
</div>
<script>
    document.getElementById("clanky").classList.add("selected");
    document.getElementById("navbar-collapsed-text").innerText = "Články";
</script>