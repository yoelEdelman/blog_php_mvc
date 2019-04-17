<?php $title = 'Administration des catégories - Mon premier blog !'; ?>
<?php ob_start(); ?>
    <body class="index-body">
        <div class="container-fluid">
            <?php require '././partials/backend/header.php'; ?>
            <div class="row my-3 index-content">
                <?php require '././partials/backend/nav.php'; ?>
                <section class="col-9">
                    <header class="pb-4 d-flex justify-content-between">
                        <h4>Liste des catégories</h4>
                        <a class="btn btn-primary" href="index.php?page=admin_category_form">Ajouter une catégorie</a>
                    </header>
                    <!-- si on a recu le parametre action en url-->
                    <?php if ( isset($_GET['action'])): ?>
                        <div class="bg-success text-white p-2 mb-4">Suppression efféctuée.</div>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['message'])) :?>
                        <?php foreach($_SESSION['message'] as $message): ?>
                            <div class="bg-success text-white p-2 mb-4">
                                <?= $message; ?>
                            </div>
                        <?php endforeach; ?>
                        <?php unset($_SESSION['message']) ;?>
                    <?php endif ;?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($categories as $key => $category): ?>
                                <tr>
                                    <th><?= $category['id']; ?></th>
                                    <td><?= $category['name']; ?></td>
                                    <td><?= $category['description']; ?></td>
                                    <td>
                                        <a href="index.php?page=admin_category_form&category_id=<?= $category['id']; ?>&action=edit" class="btn btn-warning">Modifier</a>
                                        <a onclick="return confirm('Are you sure?')" href="index.php?page=admin_categories_list&category_id=<?= $category['id']; ?>&action=delete" class="btn btn-danger">Supprimer</a>
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