<div class="p-3">
    <?php if (!isset($article) || !$article) : ?>
    <div class="d-flex justify-content-center">
        <h3>Článek nenalezen</h3>
    </div>
    <?php else : ?>
    <div class="d-flex justify-content-center">
        <h3>Úprava článku</h3>
    </div>
    <div>
        <form method="post" enctype="multipart/form-data">
            <div class="mt-3 mb-3">
                <label for="title">Název článku</label>
                <input type="text" name="title" id="title" placeholder="..." value="<?=$article['name']?>" required>
                <label for="abstract">Abstrakt článku</label>
                <textarea class="w-100" name="abstract" id="abstract" rows="10" required><?=$article['abstract']?></textarea>
                <label for="pdf_file">Soubor PDF</label>
                <input type="file" name="pdf_file" id="pdf_file" accept=".pdf">
            </div>
            <div class="d-flex justify-content-center">
                <button name="submit" type="submit" id="submit" class="submit"><i class="fa fa-check"></i> Potvrdit</button>
            </div>
        </form>
    </div>
    <?php endif ?>
</div>
<script>
    document.getElementById("navbar-collapsed-text").innerText = "Úprava článku";
</script>