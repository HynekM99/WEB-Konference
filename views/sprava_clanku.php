<div class="p-2">
    <?php if (!isset($undecided_articles) || count($undecided_articles) <= 0) : ?>
        <h3 class="d-flex justify-content-center">Žádné články k posouzení</h3>
    <?php else : ?>
        <h3 class="d-flex justify-content-center">Neposouzené články</h3>
        <?php foreach ($undecided_articles as $article) : ?>
            <div id="article-<?=$article['id']?>" class="article">
                <div class="article-header">
                    <em><?=$article['authors']?></em>
                    <h4><?=$article['name']?></h4>
                </div>
                <p class="article-content"><?=nl2br($article['abstract'])?></p>
                <em class="article-timestamp"><?=$article['timestamp']?></em>

                <?php if (!$is_banned) : ?>
                    <div class="article-admin-area overflow-auto">
                        <div id="new-reviewer-article-<?=$article['id']?>" class="<?php if (count($article['available_reviewers']) <= 0) echo "d-none"; ?>">
                            <label for="new-reviewer-article-<?=$article['id']?>">Nový recenzent</label><br>
                            <select id="new-reviewer-article-<?=$article['id']?>">
                                <?php foreach ($article['available_reviewers'] as $reviewer) : ?>
                                    <option id="reviewer-<?=$reviewer['id']?>" value=<?=$reviewer['id']?>><?=$reviewer['full_name']?></option>
                                <?php endforeach ?>
                            </select>
                            <button id=<?=$article['id']?> class="add-reviewer"><i id=<?=$article['id']?> class="fa fa-plus add-reviewer"></i></button>
                        </div>
                        <table id="article-table-<?=$article['id']?>" class="article-management-table mt-2">
                            <thead>
                                <th>Odebrat</th>
                                <th>Recenzent</th>
                                <th>Celkem</th>
                                <th>Obsah</th>
                                <th>Relevance</th>
                                <th>Jazyk</th>
                            </thead>
                            <tbody>
                            <?php if (isset($article['reviews']) && count($article['reviews']) > 0) : ?>
                            <?php foreach ($article['reviews'] as $review) : ?>
                                <tr id="review-<?=$review['id_review']?>">
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <button id=<?=$review['id_review']?> class="remove-review"><i id=<?=$review['id_review']?> class="fa fa-times-circle remove-review"></i></button>
                                        </div>
                                    </td>
                                    <td><?=$review['full_name']?></td>
                                    <td><?php if (isset($review['overall_score'])) echo scoreInStars($review['overall_score']);?></td>
                                    <td><?php if (isset($review['content_score'])) echo scoreInStars($review['content_score']);?></td>
                                    <td><?php if (isset($review['relevance_score'])) echo scoreInStars($review['relevance_score']);?></td>
                                    <td><?php if (isset($review['language_score'])) echo scoreInStars($review['language_score']);?></td>
                                </tr>
                            <?php endforeach ?>
                            <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between article-controls">
                        <div class="d-flex">
                            <form id="article-verdict-<?=$article['id']?>" class="d-flex article-verdict <?php if (!$article['required_reviews']) echo "d-none"; ?>" method="post">
                                <button type="submit" name="accept-article" value=<?=$article['id']?> class="accept-article"><i class="fa fa-check-circle-o accept-article"></i> Schválit</button>
                                <button type="submit" name="dismiss-article" value=<?=$article['id']?> class="dismiss-article"><i class="fa fa-times-circle-o dismiss-article"></i> Zamítnout</button>
                            </form>
                            <a class="button download-article text-center" href="<?=$article['pdf_path']?>"><i class="fa fa-download"></i> PDF</a>
                        </div>
                        <?php if ($is_super) : ?>
                            <div>
                                <a id=<?=$article['id']?> class="button delete-article"><i id=<?=$article['id']?> class="fa fa-trash delete-article"></i></a>
                            </div>
                        <?php endif ?>
                    </div>
                <?php endif ?>
            </div>
        <?php endforeach ?>
    <?php endif ?>

    <?php if (!isset($decided_articles) || count($decided_articles) <= 0) : ?>
        <h3 class="d-flex justify-content-center border-top border-dark mt-4 pt-3">Žádné články k opětovnému posouzení</h3>
    <?php else : ?>
        <h3 class="d-flex justify-content-center border-top border-dark mt-4 pt-3">Články k opětovnému posouzení</h3>
        <?php foreach ($decided_articles as $article) : ?>
            <div id="article-<?=$article['id']?>" class="article">
                <div class="article-header <?php echo $article['published'] ? "article-accepted": "article-dismissed"; ?>">
                    <em><?=$article['authors']?></em>
                    <h4><i class="fa <?php echo $article['published'] ? "fa-check-circle-o": "fa-times-circle-o"; ?>"></i> <?=$article['name']?></h4>
                </div>
                <p class="article-content"><?=nl2br($article['abstract'])?></p>
                <em class="article-timestamp"><?=$article['timestamp']?></em>
                <?php if (!$is_banned) : ?>
                    <div class="article-admin-area overflow-auto">
                        <table id="article-table-<?=$article['id']?>" class="article-management-table mt-2">
                            <thead>
                                <th>Recenzent</th>
                                <th>Celkem</th>
                                <th>Obsah</th>
                                <th>Relevance</th>
                                <th>Jazyk</th>
                            </thead>
                            <tbody>
                            <?php if (isset($article['reviews']) && count($article['reviews']) > 0) : ?>
                            <?php foreach ($article['reviews'] as $review) : ?>
                                <tr id="review-<?=$review['id_review']?>">
                                    <td><?=$review['full_name']?></td>
                                    <td><?php if (isset($review['overall_score'])) echo scoreInStars($review['overall_score']);?></td>
                                    <td><?php if (isset($review['content_score'])) echo scoreInStars($review['content_score']);?></td>
                                    <td><?php if (isset($review['relevance_score'])) echo scoreInStars($review['relevance_score']);?></td>
                                    <td><?php if (isset($review['language_score'])) echo scoreInStars($review['language_score']);?></td>
                                </tr>
                            <?php endforeach ?>
                            <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between article-controls">
                        <div class="d-flex">
                            <form class="d-flex article-verdict" method="post">
                                <button type="submit" name="reevaluate-article" value=<?=$article['id']?> class="reevaluate-article"><i class="fa fa-undo reevaluate-article"></i> Znovu posoudit</button>
                            </form>
                            <a class="button download-article text-center" href="<?=$article['pdf_path']?>"><i class="fa fa-download"></i> PDF</a>
                        </div>
                        <?php if ($is_super) : ?>
                            <div>
                                <a id=<?=$article['id']?> class="button delete-article"><i id=<?=$article['id']?> class="fa fa-trash delete-article"></i></a>
                            </div>
                        <?php endif ?>
                    </div>
                <?php endif ?>
            </div>
        <?php endforeach ?>
    <?php endif ?>
</div>
<script>
    document.getElementById("navbar-collapsed-text").innerText = "Správa článků";
    if (window.history.replaceState) window.history.replaceState(null, null, window.location.href);

    document.addEventListener("click", function(event) {
        let target = event.target;

        if (target.classList.contains("add-reviewer")) {
            let reviewerSelect = document.querySelector("select#new-reviewer-article-"+target.id);
            let newReviewerId = reviewerSelect.value;

            $.ajax({
                url: "ajax/admin_edit_review.php",
                data: {
                    admin_id: <?=$user_id?>,
                    reviewer_id: newReviewerId,
                    article_id: target.id
                },
                success: function(result) {
                    if (result) {
                        let option = document.querySelector("select#new-reviewer-article-"+target.id+" option#reviewer-"+newReviewerId);
                        let newReviewerName = option.innerHTML;
                        option.remove();

                        let reviewerSelectionDiv = document.querySelector("div#new-reviewer-article-"+target.id);
                        let reviewerSelect = document.querySelector("select#new-reviewer-article-"+target.id);
                        
                        if (reviewerSelect.childElementCount <= 0) {
                            reviewerSelectionDiv.classList.add('d-none');
                        } else {
                            reviewerSelectionDiv.classList.remove('d-none');
                        }

                        let reviewerTable = document.querySelector("table.article-management-table#article-table-"+target.id+" tbody");
                        let newReviewerHtml = '<tr id="review-'+result+'"> <td><div class="d-flex justify-content-center"><button id='+result+' class="remove-review"><i id='+result+' class="fa fa-times-circle remove-review"></i></button></div></td> <td>'+newReviewerName+'</td> <td></td> <td></td> <td></td> <td></td> </tr>'
                        reviewerTable.insertAdjacentHTML("beforeend", newReviewerHtml);
                    }
                }
            })
        }

        if (target.classList.contains("remove-review")) {
            let reviewId = target.id;

            $.ajax({
                url: "ajax/admin_edit_review.php",
                data: {
                    admin_id: <?=$user_id?>,
                    review_id: reviewId
                },
                success: function(json) {
                    if (json) {
                        result = JSON.parse(json);

                        document.querySelector("tr#review-"+target.id).remove();

                        if (result['id_reviewer']) {
                            let reviewerSelectionDiv = document.querySelector("div#new-reviewer-article-"+result['id_article']);
                            let reviewerSelect = document.querySelector("select#new-reviewer-article-"+result['id_article']);
                            reviewerSelect.innerHTML += '<option id="reviewer-'+result['id_reviewer']+'" value='+result['id_reviewer']+'>'+result['reviewer_name']+'</option>';
                            reviewerSelectionDiv.classList.remove("d-none");
                        }

                        let reviewerTable = document.querySelector("table.article-management-table#article-table-"+result['id_article']+" tbody");
                        
                        if (reviewerTable.childElementCount < 3) {
                            let articleVerdictForm = document.querySelector("form#article-verdict-"+result['id_article']);
                            articleVerdictForm.remove();
                        }
                    }
                }
            })
        }

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
    })
</script>

<?php
function scoreInStars(int $score) {
    $html = "";
    $fullStars = (int)($score / 2);
    $halfStar = $score % 2;
    for ($i=0; $i < $fullStars; $i++) { 
        $html .= '<i class="fa fa-star me-1"></i>';
    }
    if ($halfStar == 1) {
        $html .= '<i class="fa fa-star-half-empty me-1"></i>';
    }
    for ($i=0; $i < 5 - $fullStars - $halfStar; $i++) { 
        $html .= '<i class="fa fa-star-o me-1"></i>';
    }
    return $html;
}
?>