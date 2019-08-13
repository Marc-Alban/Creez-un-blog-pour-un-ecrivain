<?php $title = 'Mettre à jour un chapitre'?>
<div class="container">
    <div class="row">
        <div class="col-12 col-md-12 d-flex justify-content-center mb-3">
            <img class='img' src='public/img/post/<?=$post->image_posts?>' alt='<?=$post->title?>'>
        </div>
        <?php if (!empty($errors)): ?>
        <div class="alert alert-danger col-12 col-md-12" role="alert">
            <?php foreach ($errors as $error): ?>

            <p><?=$error?></p>
            <?php endforeach?>
        </div>
        <?php endif?>
        <form method="POST" class="col-12 col-md-9 postF" enctype="multipart/form-data">
            <p><label for="title">Changer d'image:
                    <input type="file" name="image">
                </label>
            </p>
            <p><label for="title">Titre du chapitre:<input type="text" id="title" name="title"
                        value="<?=$post->title?>"></label></p>
            <p><label for="text">Text du chapitre:<textarea type="text" id="mytextarea"
                        name="content"><?=$post->content?></textarea></p>
            <div class="form-check">
                <input type="checkbox" name="public" class="form-check-input" id="Check1"
                    <?=($post->posted == '1') ? 'checked' : ''?>>
                <label class="form-check-label" for="Check1">Public</label>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" name="modified" class="btn btn-primary">Modifier</button>
                <button name="deleted" class="btn btn-warning">Suprimer</button>

            </div>
        </form>
    </div>
</div>