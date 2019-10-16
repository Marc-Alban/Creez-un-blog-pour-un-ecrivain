<main class="container">
    <div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
        <div class="col-md-9 px-0">
            <h1 class="display-4 font-italic">A Propos de l'auteur</h1>
            <p class="lead my-2">Je m'appelle Jean Forteroche, je suis auteur de Roman ce qui est ma passion.</p>
            <p class="lead my-2">Vous trouverez sur ce site :</p>
            <p class="lead my-2">Mon Blog avec les chapitres de mon nouveau roman.</p>
            <p class="lead my-2 float-right">Bonne lecture !!</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 blog-main">
            <h3 class="pb-4 mb-4 font-italic border-bottom">
                Nouveau lecteur:
            </h3>
            <?php if (isset($datas['oldChapter'])): ?>
            <?php foreach ($datas['oldChapter'] as $oldChapter): ?>
            <!-- chapter -->
            <div class="col-md-12">
                <div
                    class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <h3 class="mb-0"><?=$oldChapter->title?></h3>
                        <div class="mb-1 text-muted"><?=date("d/m/Y à H:i", strtotime($oldChapter->date_posts))?>
                        </div>
                        <p class="card-text mb-auto">Auteur: <?=$oldChapter->name?></p>
                        <a href="index.php?page=chapter&id=<?=$oldChapter->id?>" class="stretched-link">Continuer à
                            lire</a>
                    </div>
                    <div class="col-auto d-none d-lg-block">
                        <img src="img/chapter/<?=$oldChapter->image_posts?>" class="pt-4" alt="<?=$oldChapter->title?>">
                    </div>
                </div>
            </div>
            <?php endforeach;?>
            <?php endif?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 blog-main">
            <h3 class="pb-4 mb-4 font-italic border-bottom">
                Dernier chapitre:
            </h3>
            <?php if (isset($datas['chapters'])): ?>
            <?php foreach ($datas['chapters'] as $chapter): ?>
            <!-- chapter -->
            <div class="col-md-12">
                <div
                    class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <h3 class="mb-0"><?=$chapter->title?></h3>
                        <div class="mb-1 text-muted"><?=date("d/m/Y à H:i", strtotime($chapter->date_posts))?>
                        </div>
                        <p class="card-text mb-auto">Auteur: <?=$chapter->name?></p>
                        <a href="index.php?page=chapter&id=<?=$chapter->id?>" class="stretched-link">Continuer à
                            lire</a>
                    </div>
                    <div class="col-auto d-none d-lg-block">
                        <img src="img/chapter/<?=$chapter->image_posts?>" width='250px' class="pt-4"
                            alt="<?=$chapter->title?>">
                    </div>
                </div>
            </div>
            <?php endforeach;?>
            <?php endif?>
        </div>
    </div>

</main><!-- /.container -->