<section class="post-content-section">
    <div class="container">
        <div class="row">
            <!-- View chapter -->
            <?php if (isset($datas['chapter'])): ?>
            <?php foreach ($datas['chapter'] as $table): ?>
            <div class="col-lg-12 col-md-12 col-sm-12 post-title-block"
                style="background-image:url('img/chapter/<?=$table->image_posts?>'); background-repeat: no-repeat;background-size: cover;">
                <h1 class="text-center"><?=$table->title?></h1>
                <ul class="list-inline text-center">
                    <li><?=$table->name?> |</li>
                    <li><?=$table->date_posts?></li>
                </ul>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-12">
                <blockquote class="mg-4"><?=nl2br($table->content)?></blockquote>
            </div>
            <?php endforeach?>
            <?php else:var_dump($datas['chapter']);?>
            <?php endif?>
            <!-- End chapter -->
        </div>
        <hr>
        <div class="row">
            <span class="alert alert-primary">Notes: <i class="fas fa-exclamation-triangle"></i> ->
                obligatoire </span>
            <div class="container">
                <h4>Laisser un commentaires: </h4>
            </div>
            <?php if (!empty($datas['errors'])): ?>
            <div class="alert alert-danger col-12 col-md-12" role="alert">
                <?php foreach ($datas['errors'] as $error): ?>
                <p><?=$error?></p>
                <?php endforeach?>
            </div>
            <?php endif?>
            <form id="myForm" class="col-md-8 col-12 dp-" method="POST"
                action="index.php?page=chapter&id=<?php foreach ($datas['chapter'] as $table): echo $table->id;endforeach?>&action=submitComment&#ancre">
                <div class="form-group">
                    <label for="name">Votre pseudo <i class="fas fa-exclamation-triangle"></i></label>
                    <input id="name" name="name" type="text" class="form-control" require>
                    <div id="aideName"></div>
                </div>
                <div class="form-group">
                    <label for="message">Message <i class=" fas fa-exclamation-triangle"></i></label>
                    <textarea id="message " name="comment" class="form-control" require></textarea>
                    <div id="aideMessage"></div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <input type="hidden" name="token" id="token" value="<?=$datas["session"]['token']?>" />
                    </div>
                </div>
                <div class="d-flex flex-row-reverse">
                    <input type="submit" class="btn btn-primary" placeholder="Envoyer" value="Envoyer">
                </div>
            </form>

            <div class="col-12 ">
                <?php foreach ($datas['comments'] as $comment): ?>
                <div class="blockquote col-12 com">
                    <?=$comment->name?> le <?=date("d/m/Y", strtotime($comment->date_comment))?> :
                    <?=nl2br($comment->comment)?>
                    <?php if (isset($datas['chapter'])): ?>
                    <?php foreach ($datas['chapter'] as $table): ?>
                    <?php if ($comment->seen === "1"): ?>
                    <span class=" col-md-3  ml-3 alert alert-danger" id="ancre">Commentaire signalé</span>
                    <?php else: ?>
                    <a
                        href="index.php?page=chapter&action=signalComment&id=<?=$table->id?>&idComment=<?=$comment->id?>&#ancre">
                        (Signaler)</a>
                    <?php endif?>
                    <?php endforeach?>
                    <?php endif?>
                </div>
                <?php endforeach;?>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <a href="index.php?page=home" class="btn btn-primary">Retour Accueil</a>
            <a href="index.php?page=chapters" class="btn btn-primary">Liste des chapitre</a>
        </div>
    </div>
    </div>
</section>