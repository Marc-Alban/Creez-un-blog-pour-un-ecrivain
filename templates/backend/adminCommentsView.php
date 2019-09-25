<div class="container">
    <div class="row">
        <h1>Commentaires signalés:</h1>
        <!-- Table - Listes commentaires -->
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Commentaires</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($datas['comments'])): ?>
                <?php foreach ($datas['comments'] as $comment): ?>
                <tr id="commentaire_<?=$comment->id?>">
                    <th scope="row"><?=$comment->title?></th>
                    <td><?=substr($comment->comment, 0, 100)?>...</td>
                    <td>
                        <a href="index.php?page=adminComments&id=<?=$comment->id?>&action=valideComment"
                            id="<?=$comment->id?>" class="see_comment"><button
                                class="btn btn-primary btn-circle btn-lg see_comment"><i
                                    class="fas fa-check-circle"></i></button></a>

                        <a href="index.php?page=adminComments&id=<?=$comment->id?>&action=removeComment"
                            id="<?=$comment->id?>" class="delete_comment"><button
                                class="btn btn-warning btn-circle btn-lg delete_comment"><i
                                    class="fas fa-trash-alt"></i></button></a>

                        <!-- modal -->
                        <!-- Button trigger modal -->
                        <div class="btn-group">

                            <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#commentaires_<?=$comment->id?>">
                                <i class="fas fa-window-restore"></i>
                            </button>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade-scale" id="commentaires_<?=$comment->id?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span data-dismiss="modal" aria-hidden="true">×</span>
                                        <h4 class="modal-title"><?=$comment->title?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Commentaire publié par <?=$comment->name?>,
                                                le
                                                <?php echo date("d/m/Y à H:i:s", strtotime($comment->date_comment)) ?></strong>
                                        </p>
                                        <p><?=nl2br($comment->comment)?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="index.php?page=adminComments&id=<?=$comment->id?>&action=valideComment"
                                            id="<?=$comment->id?>" class="see_comment"><button
                                                class="btn btn-primary btn-circle btn-lg see_comment"><i
                                                    class="fas fa-check-circle"></i></button></a>

                                        <a href="index.php?page=adminComments&id=<?=$comment->id?>&action=removeComment"
                                            id="<?=$comment->id?>" class="delete_comment"><button
                                                class="btn btn-warning btn-circle btn-lg delete_comment"><i
                                                    class="fas fa-trash-alt"></i></button></a>
                                    </div>

                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                        <!-- end modal -->
                    </td>
                </tr>
                <?php endforeach?>
                <?php else:echo '<tr><td><center>Aucun commentaires dans le tableau</center></td></tr>';?>
                <?php endif?>
            </tbody>
        </table>
        <!-- fin table -->
    </div>
</div>