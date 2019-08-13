<?php $title = "Accueil - Livre Jean Forteroche";?>
<main role="main" class="container">
    <div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
        <div class="col-md-9 px-0">
            <h1 class="display-4 font-italic">"Un billet simple pour l'Alaska"</h1>
            <p class="lead my-3">Dernier ouvrage écrit par Jean Forteroche seulement en ligne !</p>
            <p class="lead my-3">----------------------Extrait----------------------</p>
            <p class="lead my-3">
                Je griffonne ces quelques lignes sur le calpin que tu m’as offert avant mon départ.
                Ce livre est l'histoire de Pierre explorateur, imaginée par sa fille Maud.
                Jour aprés jour elle raconte le voyage de son père, parti pour l'Alaska.Sera-t-il de retour pour son
                anniversaire ? ou reviendra-t-il ?</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 blog-main">
            <h3 class="pb-4 mb-4 font-italic border-bottom">
                chapitres:
            </h3>
            <?php foreach ($posts as $chapitre): ?>
            <!-- chapitre -->
            <div class="col-md-12">
                <div
                    class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <h3 class="mb-0"><?=$chapitre->title?></h3>
                        <div class="mb-1 text-muted"><?=date("d/m/Y à H:i", strtotime($chapitre->date_posts))?>
                        </div>
                        <p class="card-text mb-auto">Auteur: <?=$chapitre->name?></p>
                        <a href="index.php?page=post&id=<?=$chapitre->id?>" class="stretched-link">Continuer à
                            lire</a>
                    </div>
                    <div class="col-auto d-none d-lg-block">
                        <img src="public/img/post/<?=$chapitre->image_posts?>" width='250px' class="pt-4"
                            alt="<?=$chapitre->title?>">
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
        <!-- Aside -> Infos -->
        <aside class="col-md-4 blog-sidebar">
            <div class="p-4 mb-3 bg-light rounded">
                <h4 class="font-italic">A Propos</h4>
                <p class="mb-0">Je m'appelle Jean Forteroche,<br /> auteur de Roman ma passion.</p>
                Vous trouverez sur ce site :<br />
                - mon Blog avec les chapitres de mon nouveau roman.<br />
                - ma bibliographie<br />
                - une page contact<br />
                Bonne visite !!</p>
            </div>
        </aside>
    </div>
</main><!-- /.container -->