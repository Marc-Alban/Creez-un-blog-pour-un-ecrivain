<?php
declare (strict_types = 1);
ob_start();
$title = 'Chapitre ' . $post->title . ' - Jean Forteroche';
?>

<section class="post-content-section">
    <div class="container">

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 post-title-block"
                style="background-image:url('public/img/post/<?=$post->image_posts?>'); background-repeat: no-repeat;background-size: cover;">

                <h1 class="text-center"><?=$post->title?></h1>

                <ul class="list-inline text-center">
                    <li><?=$post->name?> |</li>
                    <li><?=$post->date_posts?></li>
                </ul>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-12">
                <blockquote class="mg-4"><?=nl2br($post->content)?></blockquote>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="alert alert-danger col-12 col-md-6" role="alert">
                <?php
foreach ($errors as $error) {
    echo $error . '<br>';
}
?>
            </div>

            <h4>Commentaires:</h4>
            <br><br>
            <form class="col-md-8 col-12" method="POST">
                <h4>Laisser un commentaires:</h4>
                <div class="form-group">
                    <input id="name" name="pseudo" type="text" class="form-control" require>
                    <label for="name">Votre pseudo</label>
                </div>
                <div class="form-group">
                    <textarea id="message" name="comment" class="form-control" require></textarea>
                    <label for="message">Message</label>
                </div>
                <button type="submit" name="envoie" class="btn btn-primary">Envoyer</button>
            </form>

            <div class="col-12 com">
                <?php
if ($responses != false) {
    foreach ($responses as $response) {
        ?>
                <div class="blockquote col-12">
                    <?=$response->name?> le <?=date("d/m/Y", strtotime($response->date_comment))?> :
                    <?=nl2br($response->comment)?>.
                    <a href="index.php?page=see_comment&id=<?=$response->id?>">(Signaler)</a>
                </div>
                <?php
}
} else {
    echo 'Aucun commentaires publié... Soyer le premier ! ';
}
?>
            </div>
        </div>
    </div>
    </div> <!-- /container -->
</section>

<?php
$content = ob_get_clean();
require 'template.php';
?>