<?php $title = 'Homepage - Mon premier blog !'; ?>
<?php ob_start(); ?>
<body class="index-body">
    <div class="container-fluid">
        <?php require '././partials/frontend/header.php'; ?>
        <div class="row my-3 index-content">
            <?php require '././partials/frontend/nav.php'; ?>
            <main class="col-9">
                <?php if(isset($_SESSION['message'])) :?>
                    <?php foreach($_SESSION['message'] as $message): ?>
                        <div class="bg-success text-white p-2 mb-4">
                            <?= $message; ?>
                            <?php unset($_SESSION['message']) ;?>
                        </div>
                    <?php endforeach; ?>
                <?php endif ;?>
                <section class="latest_articles">
                    <header class="mb-4"><h1>Les 3 derniers articles :</h1></header>
                    <!-- les trois derniers articles -->
                    <?php foreach($articles as $key => $article): ?>
                    <article class="mb-4">
                        <h2><?php echo $article['title']; ?></h2>
                        <div class="row">
                            <?php if( !empty($article['image'])): ?>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <img class="img-fluid" src="../assets/img/<?= $article['image']; ?>" alt="" />
                                </div>
                            <?php endif; ?>
                            <div class="col-12 col-md-8 col-lg-9">
                                <b class="article-category">[<?= $article['GROUP_CONCAT(name)']; ?>]</b>
                                <span class="article-date">
                                    <!-- affichage de la date de l'article selon le format %A %e %B %Y -->
                                    <?= strftime("%A %e %B %Y", strtotime($article['published_at'])); ?>
                                </span>
                                <div class="article-content">
                                    <?= $article['summary']; ?>
                                </div>
                                <a href="../index.php?page=article&article_id=<?= $article['id']; ?>">> Lire l'article</a>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </section>
                <div class="text-right">
                    <a href="../index.php?page=article_list">> Tous les articles</a>
                </div>
            </main>
        </div>
        <?php require '././partials/frontend/footer.php'; ?>
    </div>
</body>
<?php $content = ob_get_clean(); ?>
<?php require 'template.php'; ?>