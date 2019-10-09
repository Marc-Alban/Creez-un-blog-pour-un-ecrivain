<?php if (isset($datas['chapter'])): ?>
<div class="col-12 col-md-12 d-flex justify-content-center mb-3">
    <img class='img' src='img/chapter/<?=$datas['chapter'][0]->image_posts?>' alt='<?=$datas['chapter'][0]->title?>'>
</div>

<?php else: ?>
<p class="alert alert-info">Notes obligatoire: <i class="fas fa-exclamation-triangle"></i> </p>
<?php endif?>

<form method="POST" class="col-12 col-md-12 postF"
    action="index.php?page=adminChapter&action=<?=isset($datas['chapter'][0]->id) ? 'adminEdit&id=' . $datas['chapter'][0]->id : 'newChapter'?>"
    enctype="multipart/form-data">
    <p><label for="title">Titre du chapitre: <i class="fas fa-exclamation-triangle"></i><input type=" text" id="title"
                name="title" value="<?=isset($datas['chapter'][0]->title) ? $datas['chapter'][0]->title : ''?>"></label>
    </p>
    <p><label for="text" class="col-12">Text du chapitre: <i class="fas fa-exclamation-triangle"></i><textarea
                type="text" id="mytextarea" name="content"
                class="col-12"><?=isset($datas['chapter'][0]->content) ? $datas['chapter'][0]->content : ''?></textarea>
    </p>
    <p>
        <label for="image">Image: <i class="fas fa-exclamation-triangle"></i>
            <input type="file" name="image">
        </label>
    </p>
    <div class="form-check">
        <input type="checkbox" name="public" class="form-check-input" id="Check1"
            <?=(isset($datas['chapter'][0]->posted) and $datas['chapter'][0]->posted == 1) ? 'checked' : ''?>>
        <label class="form-check-label" for="Check1">Public</label>
    </div>
    <div class="form-group row">
        <div class="col-md-6">
            <input type="hidden" name="token" id="token"
                value="<?php foreach ($datas["session"] as $session => $value): echo $value;endforeach?>" />
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <input type="submit" name="modified" class="btn btn-primary"
            value="<?=isset($datas['chapter'][0]->id) ? 'Modifier' : 'Créer'?>">
    </div>
</form>