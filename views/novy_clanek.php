<div class="p-3">
    <div class="d-flex justify-content-center">
        <h3>Nový článek</h3>
    </div>
    <div class="">
        <?php if (isset($authors)) : ?>
            <div class="new-author-selection">
                <label>Přidat autora</label><br>
                <select id="extra-author">
                <?php foreach ($authors as $author) : ?>
                    <option id="author-<?=$author['id']?>" value=<?=$author['id']?>><?=$author['full_name']?></option>
                <?php endforeach ?>
                </select>
                <button class="add-author"><i class="fa fa-plus add-author"></i></button>
            </div>
        <?php endif ?>
        <form method="post" enctype="multipart/form-data">
            <div class="new-authors overflow-auto">
                <table class="extra-authors">

                </table>
            </div>
            <div class="mt-3 mb-3">
                <label for="title">Název článku</label>
                <input type="text" name="title" id="title" placeholder="..." required>
                <label for="abstract">Abstrakt článku</label>
                <textarea class="w-100" name="abstract" id="abstract" rows="10" required></textarea>
                <label for="pdf_file">Soubor PDF</label>
                <input type="file" name="pdf_file" id="pdf_file" accept=".pdf" required>
            </div>
            <div class="d-flex justify-content-center">
                <button name="submit" type="submit" id="submit" class="submit"><i class="fa fa-check"></i> Potvrdit</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.getElementById("navbar-collapsed-text").innerText = "Nový článek";
    if (window.history.replaceState) window.history.replaceState(null, null, window.location.href);

    document.addEventListener("click", function(event) {
        let target = event.target;

        if (target.classList.contains("add-author")) {
            let authorsSelection = document.querySelector("select#extra-author");
            let authorsTable = document.querySelector("table.extra-authors");
            let selectedAuthorId = authorsSelection.value;
            let authorsSelectedOption = document.querySelector("select#extra-author #author-"+selectedAuthorId);

            if (!authorsSelectedOption) return;
            let selectedAuthorName = authorsSelectedOption.innerHTML;
            authorsSelectedOption.remove();

            authorsTable.insertAdjacentHTML("beforeend", '<tr id="extra-author-'+selectedAuthorId+'"> <td><i id='+selectedAuthorId+' class="fa fa-times-circle remove-author"></i></td> <td id="author-name-'+selectedAuthorId+'">'+selectedAuthorName+'</td> <td hidden><input type="number" name="extra-authors[]" value='+selectedAuthorId+'></td> </tr>');
        }

        if (target.classList.contains("remove-author")) {
            let authorId = target.id;
            let authorsSelection = document.querySelector("select#extra-author");
            let authorName = document.querySelector("td#author-name-"+authorId).innerHTML;
            authorsSelection.insertAdjacentHTML("beforeend", '<option id="author-'+authorId+'" value='+authorId+'>'+authorName+'</option>');
            document.querySelector("tr#extra-author-"+authorId).remove();
            authorsSelection.value = authorId;
        }
    });
</script>