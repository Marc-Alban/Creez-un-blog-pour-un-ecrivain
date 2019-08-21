<section class="post-content-section">
    <div class="container">
        <div class="row">
            <?php foreach ($chapter as $table): ?>
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
        </div>
        <hr>
        <div class="row">
            <h4>Commentaires:</h4>
            <br><br>
            <form class="col-md-8 col-12" method="POST">
                <h4>Laisser un commentaires:</h4>
                <div class="form-group">
                    <input id="name" name="name" type="text" class="form-control" require>
                    <label for="name">Votre pseudo</label>
                </div>
                <div class="form-group">
                    <textarea id="message " name="comment" class="form-control" require></textarea>
                    <label for="message">Message</label>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Envoyer</button>
            </form>
            <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
            <div class="alert alert-danger col-12 col-md-6" role="alert">
                <p><?=$error?></p>
            </div>
            <?php endforeach?>
            <?php endif?>
            <div class="col-12 com">
                <?php foreach ($responses as $response): ?>

                <div class="blockquote col-12">
                    <?=$response->name?> le <?=date("d/m/Y", strtotime($response->date_comment))?> :
                    <?=nl2br($response->comment)?>.
                    <a
                        href="index.php?page=chapter&id=<?=$_GET['id'] . '&comment_id=' . $response->id?>&action=signalComment">(Signaler)</a>
                </div>
                <?php endforeach;?>
                <?=(isset($responses) && $responses == null) ? 'Aucun commentaires publié... Soyer le premier ! ' : '';?>
            </div>
        </div>
    </div>
    </div>
</section>