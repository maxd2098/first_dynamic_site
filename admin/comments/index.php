<?php

include "../../path.php";
include "../../app/controllers/commentaries.php";

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My site</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/90241b67b0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/css/admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<!--header-->
<?php include "../../app/include/header_admin.php"; ?>

<div class="container">
    <?php include "../../app/include/sidebar_admin.php"; ?>
        <div class="posts col-9">
            <div class="row title-table">
                <h2>Управление комментариями</h2>
                <div class="mb-12 col-12 col-md-12 err">
                    <p></p>
                </div>
                <div class="col-1">ID</div>
                <div class="col-5">Текст</div>
                <div class="col-2">Автор</div>
                <div class="col-4">Управление</div>
            </div>
            
            <?php foreach($commentsForAdm as $key => $comment): ?>
            <div class="row post">
                <div class="id col-1"><?=$comment['id']; ?></div>
                <div class="title col-5">
                    <?php if (strlen($comment['comment']) > 40): ?>
                        <?=mb_substr($comment['comment'], 0, 40, 'UTF-8') . '...'; ?>
                    <?php else: ?>
                        <?=$comment['comment']; ?>
                    <?php endif; ?>
                </div>
                <?php
                    
                    $user = $comment['email'];
                    $user = explode('@', $user);
                    $user = $user[0];
                
                ?>
                <div class="author col-3"><?=$user . '@'; ?></div>
                <div class="red col-1"><a href="edit.php?id=<?=$comment['id']; ?>">edit</a></div>
                <div class="del col-1"><a href="edit.php?delete_id=<?=$comment['id']; ?>">delete</a></div>
                <?php if($comment['status']): ?>
                    <div class="status col-1"><a href="edit.php?publish=0&pub_id=<?=$comment['id']; ?>">unpublish</a></div>
                <?php else: ?>
                    <div class="status col-1"><a href="edit.php?publish=1&pub_id=<?=$comment['id']; ?>">publish</a></div>
                <?php endif; ?>
                
            </div>
            <?php endforeach; ?>
            
        </div>
    </div>
</div>


<!--footer-->
<?php include "../../app/include/footer.php"; ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>

</body>
</html>
