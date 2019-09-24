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
            <h4>Commentaires:</h4>
            <br><br>
            <?php if (!empty($datas['errors'])): ?>
            <div class="alert alert-danger col-12 col-md-12" role="alert">
                <?php foreach ($datas['errors'] as $error): ?>
                <p><?=$error?></p>
                <?php endforeach?>
            </div>
            <?php endif?>
            <form class="col-md-8 col-12" method="POST"
                action="index.php?page=chapter&id=<?php foreach ($datas['chapter'] as $table): echo $table->id;endforeach?>&action=submitComment">
                <h4>Laisser un commentaires:</h4>
                <div class="form-group">
                    <input id="name" name="name" type="text" class="form-control" require>
                    <label for="name">Votre pseudo</label>
                </div>
                <div class="form-group">
                    <textarea id="message " name="comment" class="form-control" require></textarea>
                    <label for="message">Message</label>
                </div>
                <input type="submit" name="submitComment" class="btn btn-primary" placeholder="Envoyer">

            </form>

            <div class="col-12 com">
                <?php foreach ($datas['comments'] as $comment): ?>
                <div class="blockquote col-12">
                    <?=$comment->name?> le <?=date("d/m/Y", strtotime($comment->date_comment))?> :
                    <?=nl2br($comment->comment)?>
                    <?php if (isset($datas['chapter'])): ?>
                    <?php foreach ($datas['chapter'] as $table): ?>
                    <?php if ($comment->seen === "1"): ?>
                    <span class=" col-md-3 alert alert-danger">Commentaire signalé</span>
                    <?php else: ?>
                    <a
                        href="index.php?page=chapter&action=signalComment&id=<?=$table->id?>&idComment=<?=$comment->id?>">(Signaler)</a>
                    <?php endif?>
                    <?php endforeach?>
                    <?php endif?>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
    </div>
</section>