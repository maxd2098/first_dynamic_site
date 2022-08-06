<?php

include "path.php";
include SITE_ROOT . "/app/database/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search-term'])) {
    $posts = searchInTitleAndContent($_POST['search-term'], 'posts', 'users');
}

//tt($topTopic);

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My site</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/90241b67b0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<?php include "app/include/header.php"; ?>

<!--блок main-->
<div class="container">
    <div class="content row">
        <div class="main-content col-12">
            <h2>Результаты поиска публикации</h2>
            
            <?php foreach ($posts as $post): ?>

            <div class="post row">
                <div class="img col-12 col-md-4">
                    <img src="<?=BASE_URL . 'assets/images/posts/' . $post['img']; ?>" alt="<?=$post['title']?>" class="img-thumbnail">
                </div>
                <div class="post_text col-12 col-md-8">
                    <h3>
                        <?php if (strlen($post['title']) > 60): ?>
                            <a href="<?=BASE_URL . 'single.php?post=' . $post['id']; ?>"><?=mb_substr($post['title'], 0, 60, 'UTF-8') . '...'; ?></a>
                        <?php else: ?>
                            <a href="<?=BASE_URL . 'single.php?post=' . $post['id']; ?>"><?=$post['title']; ?></a>
                        <?php endif; ?>
                    </h3>
                    <i class="far fa-user"><?=$post['username']; ?></i>
                    <i class="far fa-calendar"><?=$post['created_date']; ?></i>
                    <p class="preview-text">
                        <?=mb_substr($post['content'], 0, 60, 'UTF-8') . '...'; ?>
                    </p>
                </div>
            </div>
            
            <?php endforeach; ?>
            

        </div>
        
    </div>
</div>

<!--footer-->
<?php include "app/include/footer.php"; ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>

</body>
</html>