<section class="post-content-section">
    <div class="container">
        <div class="row">
            <!-- View chapter -->
            <?php if (isset($datas['chapter'])): ?>
            <?php foreach ($datas['chapter'] as $table): ?>
            <?php $title = $table->title . ' - Jean Forteroche';?>
            <div class="col-lg-12 col-md-12 col-sm-12 post-title-block"
                style="background-image:url('public/img/chapter/<?=$table->image_posts?>'); background-repeat: no-repeat;background-size: cover;">
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
            <form class="col-md-8 col-12" method="POST"
                action="index.php?page=chapter&id=<?php foreach ($datas['chapter'] as $table): echo $table->id;endforeach?>&action=submit">
                <h4>Laisser un commentaires:</h4>
                <div class="form-group">
                    <input id="name" name="name" type="text" class="form-control" require>
                    <label for="name">Votre pseudo</label>
                </div>
                <div class="form-group">
                    <textarea id="message " name="comment" class="form-control" require></textarea>
                    <label for="message">Message</label>
                </div>
                <!-- Bug pour avoir l'id ? Comment faire ?  -->
                <input type="submit" name="submit" class="btn btn-primary" placeholder="Envoyer">

            </form>
            <!-- Errors -->

            <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
            <div class="alert alert-danger col-12 col-md-6" role="alert">
                <p><?=$error?></p>
            </div>
            <?php endforeach?>
            <?php endif?>
            <!-- End Errors -->
            <?php foreach ($datas['comments'] as $comment): ?>
            <div class="col-12 com">
                <div class="blockquote col-12">
                    <?=$comment->name?> le <?=date("d/m/Y", strtotime($comment->date_comment))?> :
                    <?=nl2br($comment->comment)?>
                    <?php if (isset($datas['chapter'])): ?>
                    <?php foreach ($datas['chapter'] as $table): ?>
                    <a
                        href="index.php?page=chapter&action=signalComment&id=<?=$table->id?>&idComment=<?=$comment->id?>">(Signaler)</a>
                    <?php endforeach?>
                    <?php endif?>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
    </div>
</section>