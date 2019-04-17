<?php $title = 'Administration des articles - Mon premier blog !'; ?>
<?php ob_start(); ?>
    <body class="index-body">
        <div class="container-fluid">
            <?php require '././partials/backend/header.php'; ?>
            <div class="row my-3 index-content">
                <?php require '././partials/backend/nav.php'; ?>
                <section class="col-9">
                    <header class="pb-4 d-flex justify-content-between">
                        <h4>Liste des articles</h4>
                        <a class="btn btn-primary" href="index.php?page=admin_article_form">Ajouter un article</a>
                    </header>
                    <!-- si on a recu le parametre action en url-->
                    <?php if ( isset($_GET['action'])): ?>
                        <?php $_SESSION['message']['deleted'] = 'Suppression efféctuée.' ;?>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['message'])) :?>
                        <?php foreach($_SESSION['message'] as $message): ?>
                            <div class="bg-success text-white p-2 mb-4">
                                <?= $message; ?>
                            </div>
<!--                            --><?php //unset($message) ;?>
                        <?php endforeach; ?>
                        <?php unset($_SESSION['message']) ;?>
                    <?php endif ;?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Titre</th>
                                <th>Publié</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($articles as $key => $article): ?>
                                <tr>
                                    <th><?= $article['id']; ?></th>
                                    <td><?= $article['title']; ?></td>
                                    <td><?= ($article['is_published'] == 0) ? 'non' : 'oui' ;?></td>
                                    <td>
                                        <a href="index.php?page=admin_article_form&article_id=<?= $article['id']; ?>&action=edit" class="btn btn-warning">Modifier</a>
                                        <a onclick="return confirm('Are you sure?')" href="index.php?page=admin_articles_list&article_id=<?= $article['id']; ?>&action=delete" class="btn btn-danger">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </body>
<?php $content = ob_get_clean(); ?>
<?php require 'template.php'; ?>