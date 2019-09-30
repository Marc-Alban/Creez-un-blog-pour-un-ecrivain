<div class="container">
    <div class="row">
        <div class="headerTab col-12 col-md-12 col-lg-12">
            <h2>La listes des Chapitres: </h2>
        </div>
        <hr>
        <section class="blog-me pt-100 pb-100" id="blog">
            <div class="container">
                <div id="styleBloc">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Titre</th>
                                <th scope="col">Description</th>
                                <th scope="col">Date</th>
                                <th scope="col">Commentaire signaler</th>
                                <th scope="col">Modifier</th>
                                <th scope="col">Supprimer</th>
                                <th scope="col">Visible</th>
                            </tr>
                        </thead>
                        <?php if (isset($datas['chapters'])): ?>
                        <?php foreach ($datas['chapters'] as $chapter): ?>
                        <tbody>
                            <tr>
                                <td><?=$chapter->title?></td>
                                <td><?=substr(nl2br($chapter->content), 0, 250)?></td>
                                <td><?=date("d/m/Y à H:i", strtotime($chapter->date_posts))?></td>
                                <td>
                                    <?php if (!empty($datas['nbComments']) and !empty($datas['nbComments'][$chapter->id])): ?>
                                    <a href="index.php?page=adminComments&id=<?=$chapter->id?>">
                                        <button class="btn btn-warning"><?=$datas['nbComments'][$chapter->id]?></button>
                                    </a>
                                    <?php else: ?>
                                    <?='Aucun commentaire signalé'?>
                                    <?php endif;?>

                                </td>
                                <td><a href="index.php?page=adminChapter&id=<?=$chapter->id?>" id="lien"><i
                                            class="far fa-edit"></i></a></td>
                                <td><a href="index.php?page=adminChapters&action=delete&id=<?=$chapter->id?>"><i
                                            class="fas fa-trash"></i></a>
                                </td>
                                <td>
                                    <?=($chapter->posted == '0') ? '<span class="fas fa-lock"></span>' : '<i class="fas fa-eye"></i>'?>
                                </td>
                            </tr>
                        </tbody>
                        <?php endforeach?>
                        <?php else:var_dump($datas['chapters']);?>
                        <?php endif;?>
                    </table>
                    <a href="index.php?page=adminChapter" class="btn btn-primary">Ajouter article</a>
                </div>
            </div>
        </section>
    </div>
</div>