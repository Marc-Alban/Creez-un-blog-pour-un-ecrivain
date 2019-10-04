<section class="blog-me pt-100 pb-100" id="blog">
    <div class="container">
        <div id="styleBloc">
            <?php if (isset($datas['chapters'])): ?>
            <?php foreach ($datas['chapters'] as $chapter): ?>
            <div class="col-md-6 col-6 col-lg-6 blogShort">
                <a href="index.php?page=chapter&id=<?=$chapter->id?>" id="lien">
                    <h1><?=$chapter->title?></h1>
                    <img src="img/chapter/<?=$chapter->image_posts?>" alt="<?=$chapter->title?>"
                        class="pull-left img-responsive thumb margin10 img-thumbnail">
                    <p>
                        <?=date("d/m/Y à H:i", strtotime($chapter->date_posts))?>
                        <br>
                        <?=substr(nl2br($chapter->content), 0, 250)?>
                    </p>
                    <p class=" btn btn-primary">Continuer à lire</p>
                </a>
            </div>
            <?php endforeach;?>
            <?php else:var_dump($datas['chapters']);?>
            <?php endif?>

        </div>
    </div>
</section>