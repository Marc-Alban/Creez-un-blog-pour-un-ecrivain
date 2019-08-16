<section class="post-content-section">
    <div class="container">
        <div class="row">
            <?php foreach ($post as $posts): ?>
            <?php $title = $posts->title . ' - Jean Forteroche';?>
            <div class="col-lg-12 col-md-12 col-sm-12 post-title-block"
                style="background-image:url('public/img/post/<?=$posts->image_posts?>'); background-repeat: no-repeat;background-size: cover;">
                <h1 class="text-center"><?=$posts->title?></h1>
                <ul class="list-inline text-center">
                    <li><?=$posts->name?> |</li>
                    <li><?=$posts->date_posts?></li>
                </ul>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-12">
                <blockquote class="mg-4"><?=nl2br($posts->content)?></blockquote>
            </div>
            <?php endforeach?>
        </div>
        <hr>
        <div class="row">
            <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
            <div class="alert alert-danger col-12 col-md-6" role="alert">
                <p><?=$error?></p>
            </div>
            <?php endforeach?>
            <?php endif?>
            <br><br>
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
                <button type="submit" name="envoie" class="btn btn-primary">Envoyer</button>
            </form>

            <div class="col-12 com">
                <?php foreach ($responses as $response): ?>

                <div class="blockquote col-12">
                    <?=$response->name?> le <?=date("d/m/Y", strtotime($response->date_comment))?> :
                    <?=nl2br($response->comment)?>.
                    <a href="index.php?page=post&id=<?=$_GET['id'] . '&comment_id=' . $response->id?>">(Signaler)</a>
                </div>
                <?php endforeach;?>
                <?=(isset($responses) && $responses == null) ? 'Aucun commentaires publié... Soyer le premier ! ' : '';?>
            </div>
        </div>
    </div>
    </div>
</section>