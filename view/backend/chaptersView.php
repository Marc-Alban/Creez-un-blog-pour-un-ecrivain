<div class="container">
    <div class="row">
        <?php $title = 'Liste des chapitres'?>
        <h2>Listes des Chapitres: </h2>
        <hr>
        <section class="blog-me pt-100 pb-100" id="blog">
            <div class="container">
                <div id="styleBloc">
                    <?php foreach ($chapters as $chapter): ?>
                    <div class="col-md-12 col-12 blogShort">
                        <a href="index.php?page=adminEdit&id=<?=$chapter->id?>" id="lien">
                            <h1><?=$chapter->title?>
                                <?php echo ($chapter->posted == '0') ? '<span class="fas fa-lock"></span>' : '' ?>
                            </h1>
                            <img src="public/img/chapter/<?=$chapter->image_posts?>" alt="<?=$chapter->title?>"
                                class="pull-left timg img-responsive thumb margin10 img-thumbnail">
                            <p>
                                <?=date("d/m/Y à H:i", strtotime($chapter->date_posts))?>
                                <br>
                                <?=substr(nl2br($chapter->content), 0, 250)?>
                            </p>
                            <p class=" btn btn-primary">Modifier le chapitre</p>
                        </a>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>
        </section>
    </div>
</div>