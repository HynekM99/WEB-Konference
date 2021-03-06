<div class="p-2">
    <?php if (!isset($unfinished_reviews) || count($unfinished_reviews) <= 0) : ?>
        <h3 class="d-flex justify-content-center">Nic k ohodnocení</h3>
    <?php else : ?>
        <h3 class="d-flex justify-content-center">Zbývá ohodnotit</h3>
        <?php foreach ($unfinished_reviews as $review) : ?>
            <div class="article">
                <div class="article-header">
                    <em><?=$review['article']['authors']?></em>
                    <h4><?=$review['article']['name']?></h4>
                </div>
                <p class="article-content"><?=nl2br($review['article']['abstract'])?></p>
                <em class="article-timestamp"><?=$review['article']['timestamp']?></em>
                <form method="post">
                    <input type="number" name="article_id" value=<?=$review['article']['id']?> hidden>
                    <div class="row justify-content-center review-area d-none" id="unfinished-review-<?=$review['article']['id']?>">
                        <div class="scores col-12 col-sm-6 col-md-4">
                            <label for="content">Obsah</label>
                            <input name="content" id="content" type="number" min=0 max=10 value=5>
                            <label for="relevance">Relevance</label>
                            <input name="relevance" id="relevance" type="number" min=0 max=10 value=5>
                            <label for="language">Jazyk</label>
                            <input name="language" id="language" type="number" min=0 max=10 value=5>
                        </div>
                        <div class="comment col-12 col-sm-6 col-md-4 mt-2 mt-md-0">
                            <label for="comment">Komentář</label><br>
                            <textarea name="comment" id="comment"></textarea>
                        </div>
                        <div class="d-flex justify-content-center mt-2">
                            <button type="submit" name="submit" class="submit" id="review-<?=$review['article']['id']?>"><i class="fa fa-check"></i> Potvrdit</button>
                        </div>
                    </div>
                </form>
                <?php if (!$is_banned) : ?>
                    <div class="d-flex article-controls">
                        <a class="button open-review unfinished" id="<?=$review['article']['id']?>"><i class="fa fa-star-o open-review unfinished" id=<?=$review['article']['id']?>></i> Ohodnotit</a>
                        <a class="button download-article" href="<?=$review['article']['pdf_path']?>"><i class="fa fa-download"></i> PDF</a>
                    </div>
                <?php endif ?>
            </div>
        <?php endforeach ?>
    <?php endif ?>

    <?php if (!isset($finished_reviews) || count($finished_reviews) <= 0) : ?>
        <h3 class="d-flex justify-content-center border-top border-dark mt-4">Nic k upravení</h3>
    <?php else : ?>
        <h3 class="d-flex justify-content-center border-top border-dark mt-4">Lze upravit</h3>
        <?php foreach ($finished_reviews as $review) : ?>
            <div class="article">
                <div class="article-header">
                    <em><?=$review['article']['authors']?></em>
                    <h4><?=$review['article']['name']?></h4>
                </div>
                <p class="article-content"><?=nl2br($review['article']['abstract'])?></p>
                <em class="article-timestamp"><?=$review['article']['timestamp']?></em>
                <div class="row justify-content-center review-area d-none" id="finished-review-<?=$review['article']['id']?>">
                    <input type="number" id="article-id-finished-review-<?=$review['article']['id']?>" value=<?=$review['article']['id']?> hidden>
                    <div class="scores col-12 col-sm-6 col-md-4">
                        <label for="content-finished-review-<?=$review['article']['id']?>">Obsah</label>
                        <input id="content-finished-review-<?=$review['article']['id']?>" type="number" min=0 max=10 value=<?=$review['content_score']?>>
                        <label for="relevance-finished-review-<?=$review['article']['id']?>">Relevance</label>
                        <input id="relevance-finished-review-<?=$review['article']['id']?>" type="number" min=0 max=10 value=<?=$review['relevance_score']?>>
                        <label for="language-finished-review-<?=$review['article']['id']?>">Jazyk</label>
                        <input id="language-finished-review-<?=$review['article']['id']?>" type="number" min=0 max=10 value=<?=$review['language_score']?>>
                    </div>
                    <div class="comment col-12 col-sm-6 col-md-4 mt-2 mt-md-0">
                        <label for="comment-finished-review-<?=$review['article']['id']?>">Komentář</label><br>
                        <textarea id="comment-finished-review-<?=$review['article']['id']?>"><?=$review['comment']?></textarea>
                    </div>
                    <div class="edit-success d-flex justify-content-center mt-2">
                        <i class="fa fa-check-circle-o review-edit-success text-success d-none"></i>
                        <i class="fa fa-times-circle-o review-edit-failed text-danger d-none"></i>
                    </div>
                    <div class="d-flex justify-content-center mt-2">
                        <button class="submit edit-review" id="finished-review-<?=$review['article']['id']?>"><i class="fa fa-check"></i> Potvrdit</button>
                    </div>
                </div>
                <?php if (!$is_banned) : ?>
                    <div class="d-flex article-controls">
                        <a class="button open-review finished" id="<?=$review['article']['id']?>"><i class="fa fa-star-o open-review finished" id=<?=$review['article']['id']?>></i> Ohodnotit</a>
                        <a class="button download-article" href="<?=$review['article']['pdf_path']?>"><i class="fa fa-download"></i> PDF</a>
                    </div>
                <?php endif ?>
            </div>
        <?php endforeach ?>
    <?php endif ?>
</div>
<script>
    document.getElementById("navbar-collapsed-text").innerText = "Moje recenze";
    if (window.history.replaceState) window.history.replaceState(null, null, window.location.href);

    document.addEventListener("click", function(event) {
        let target = event.target;
        if (target.classList.contains("open-review")) {
            let finished = target.classList.contains("finished");
            let reviewArea;
            if (finished) reviewArea = document.querySelector(".review-area#finished-review-"+target.id);
            else reviewArea = document.querySelector(".review-area#unfinished-review-"+target.id);

            if (reviewArea.classList.contains("d-none")) reviewArea.classList.remove("d-none");
            else reviewArea.classList.add("d-none");
        }

        if (target.classList.contains("edit-review")) {
            let articleId = document.querySelector("div#"+target.id+" input#article-id-"+target.id).value;
            let contentScore = document.querySelector("div#"+target.id+" div.scores input#content-"+target.id).value;
            let relevanceScore = document.querySelector("div#"+target.id+" div.scores input#relevance-"+target.id).value;
            let languageScore = document.querySelector("div#"+target.id+" div.scores input#language-"+target.id).value;
            let comment = document.querySelector("div#"+target.id+" div.comment textarea#comment-"+target.id).value;

            $.ajax({
                url: "ajax/edit_review.php",
                data: {
                    user_id: <?=$user_id?>,
                    article_id: articleId,
                    content_score: contentScore,
                    relevance_score: relevanceScore,
                    language_score: languageScore,
                    comment: comment
                },
                success: function(result) {
                    let successSign = document.querySelector("div#"+target.id+" div.edit-success i.review-edit-success");
                    let failedSign = document.querySelector("div#"+target.id+" div.edit-success i.review-edit-failed");

                    successSign.classList.add("d-none");
                    failedSign.classList.add("d-none");

                    if (result == true) successSign.classList.remove("d-none");
                    else failedSign.classList.remove("d-none");
                }
            })
        }
    });
</script>