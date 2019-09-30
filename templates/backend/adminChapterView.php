<?php

$form = "
        <div class='col-12 col-md-12 d-flex justify-content-center mb-3'>
        <img class='img' src='img/chapter/" . $chapters->image_posts . "' alt='" . $chapters->title .
"'>
    </div>
    <form method='POST' class='col-12 col-md-12 postF'
        action='index.php?page=adminChapter&action=adminEdit&id=" . $chapters->id . "'
        enctype='multipart/form-data'>
        <p>
            <label for='image'>Image:
                <input type='file' name='image'>
            </label>
        </p>
        <p><label for='title'>Titre du chapitre:<input type='text' id='title' name='title'
                    value='" . $chapters->title . "'></label></p>
        <p><label for='text' class='col-12'>Text du chapitre:<textarea type='text' id='mytextarea' name='content'
                    class='col-12'>" . $chapters->content . "</textarea></p>
        <div class='form-check'>
            <input type='checkbox' name='public' class='form-check-input' id='Check1'
                " . ($chapters->posted == 1) ? 'checked' : '' . " >
        <label class='form-check-label' for='Check1'>Public</label>
    </div>
    <div class='d-flex justify-content-center'>
        <input type='submit' name='modified' class='btn btn-primary' value='Modifier'>
    </div>
    </form>
    ";
?>
<div class="container">
    <div class="row">
        <?php if (!empty($datas['errors'])): ?>
        <div class="alert alert-danger col-12 col-md-12" role="alert">
            <?php foreach ($datas['errors'] as $error): ?>
            <p><?=$error?></p>
            <?php endforeach?>
        </div>
        <?php endif?>
        <p class="alert alert-info">Notes: <i class="fas fa-exclamation-triangle"></i> -> obligatoire </p>
        <?php if (isset($datas['chapter'])): ?>
        <?php foreach ($datas['chapter'] as $chapters): ?>
        <?=$form;?>
        <?php endforeach?>
        <?php else: ?>
        <?php endif?>
        <a href="index.php?page=adminChapters" class="btn btn-primary">Retour liste Chapitre</a>
    </div>
</div>