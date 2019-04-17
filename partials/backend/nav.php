<nav class="col-3 py-2 categories-nav">
    <p class="h2 text-center">Salut <?= $_SESSION['user']['first_name']; ?> !</p>
    <a class="d-block btn btn-danger mb-4 mt-2" href="././index.php?logout">Déconnexion</a>
    <a class="d-block btn btn-warning mb-4 mt-2" href="././index.php">Site</a>
    <ul>
        <li><a href="index.php?page=admin_user_list">Gestion des utilisateurs (<?= $users_quantity[0]; ?>)</a></li>
        <li><a href="index.php?page=admin_categories_list">Gestion des catégories (<?= $categories_quantity[0]; ?>)</a></li>
        <li><a href="index.php?page=admin_articles_list">Gestion des articles (<?= $articles_quantity[0]; ?>)</a></li>
    </ul>
</nav>