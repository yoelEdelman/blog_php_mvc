<?php $title = $article['title'] . ' - Mon premier blog !'; ?>
<?php ob_start(); ?>
<body class="article-body">
    <div class="container-fluid">
        <?php require '././partials/frontend/header.php'; ?>
        <div class="row my-3 article-content">
            <?php require '././partials/frontend/nav.php'; ?>
            <main class="col-9">
                <article>
                    <?php if( !empty($article['image'])): ?>
                        <img class="pb-4 img-fluid" src="../assets/img/<?= $article['image']; ?>" alt="" />
                    <?php endif; ?>
                    <h1><?= $article['title']; ?></h1>
                    <b class="article-category">[<?= $article['category_name']; ?>]</b>
                    <span class="article-date">
                        <!-- affichage de la date de l'article selon le format %A %e %B %Y -->
                        <?= strftime("%A %e %B %Y", strtotime($article['published_at'])); ?>
                    </span>
                    <div class="article-content">
                        <?= $article['content']; ?>
                    </div>
                </article>
            </main>
        </div>
        <?php require '././partials/frontend/footer.php'; ?>
    </div>
</body>
<?php $content = ob_get_clean(); ?>
<?php require 'template.php'; ?>