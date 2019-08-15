<div class="container">
    <div class="row">
        <?php $title = 'Liste des chapitres'?>
        <h2>Listes des Chapitres: </h2>
        <hr>
        <section class="blog-me pt-100 pb-100" id="blog">
            <div class="container">
                <div id="styleBloc">
                    <?php foreach ($posts as $chapitre): ?>
                    <div class="col-md-12 col-12 blogShort">
                        <a href="index.php?page=postEdit&id=<?=$chapitre->id?>" id="lien">
                            <h1><?=$chapitre->title?>
                                <?php echo ($chapitre->posted == '0') ? '<span class="fas fa-lock"></span>' : '' ?>
                            </h1>
                            <img src="public/img/post/<?=$chapitre->image_posts?>" alt="<?=$chapitre->title?>"
                                class="pull-left timg img-responsive thumb margin10 img-thumbnail">
                            <p>
                                <?=date("d/m/Y à H:i", strtotime($chapitre->date_posts))?>
                                <br>
                                <?=substr(nl2br($chapitre->content), 0, 250)?>
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