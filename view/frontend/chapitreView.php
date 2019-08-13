<?php $title = 'Chapitres - Jean Forteroche';?>
<section class="blog-me pt-100 pb-100" id="blog">
    <div class="container">
        <div id="styleBloc">
            <?php foreach ($posts as $chapitre): ?>
            <div class="col-md-6 col-12 blogShort">
                <a href="index.php?page=post&id=<?=$chapitre->id?>" id="lien">
                    <h1><?=$chapitre->title?></h1>
                    <img src="public/img/post/<?=$chapitre->image_posts?>" alt="<?=$chapitre->title?>"
                        class="pull-left img-responsive thumb margin10 img-thumbnail">
                    <p>
                        <?=date("d/m/Y à H:i", strtotime($chapitre->date_posts))?>
                        <br>
                        <?=substr(nl2br($chapitre->content), 0, 250)?>
                    </p>
                    <p class=" btn btn-primary">Continuer à lire</p>
                </a>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</section>