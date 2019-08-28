<div class="container">
    <div class="row">
        <?php if (isset($datas['chapter'])): ?>
        <?php foreach ($datas['chapter'] as $chapters): ?>
        <div class="col-12 col-md-12 d-flex justify-content-center mb-3">
            <img class='img' src='public/img/chapter/<?=$chapters->image_posts?>' alt='<?=$chapters->title?>'>
        </div>
        <?php if (!empty($errors)): ?>
        <div class="alert alert-danger col-12 col-md-12" role="alert">
            <?php foreach ($errors as $error): ?>
            <p><?=$error?></p>
            <?php endforeach?>
        </div>
        <?php endif?>
        <form method="POST" class="col-12 col-md-9 postF"
            action="index.php?page=adminEdit&action=modified&id=<?=$chapters->id?>" enctype="multipart/form-data">
            <p><label for="image">Changer d'image:
                    <input type="file" name="image">
                </label>
            </p>
            <p><label for="title">Titre du chapitre:<input type="text" id="title" name="title"
                        value="<?=$chapters->title?>"></label></p>
            <p><label for="text">Text du chapitre:<textarea type="text" id="mytextarea"
                        name="content"><?=$chapters->content?></textarea></p>
            <div class="form-check">
                <input type="checkbox" name="public" class="form-check-input" id="Check1"
                    <?=($chapters->posted == 1) ? 'checked' : ''?>>
                <label class="form-check-label" for="Check1">Public</label>
            </div>
            <div class="d-flex justify-content-center">
                <input type="submit" name="modified" class="btn btn-primary" value="Modifier">
            </div>
        </form>
        <?php endforeach?>
        <?php else:var_dump($datas['chapter']);?>
        <?php endif?>
    </div>
</div>