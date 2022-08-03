<?php
include "path.php";
include "app/database/db.php";
?>

<!doctype html>
<html lang="en">
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

<!--блок карусели END-->
<!--блок main-->
<div class="container">
    <div class="content row">
        <div class="main-content col-md-9 col-12">
            <h2>Последние публикации asssssssssssssssssssssss
            asssssssssssssssssssssssssssssssssssssssssssssssss
            sssssssssssssssssssssssssssssssssssssssssssssss</h2>

            <div class="single_post row">
                <div class="img col-12">
                    <img src="assets/images/1.jpg" als="" class="img-thumbnail">
                </div>
                <div class="info">
                    <i class="far fa-user"> Имя Автора </i>
                    <i class="far fa-calendar"> Mar 11, 2019 </i>
                </div>
                <div class="single_post_text col-12">
                    <h3>Заголовок третьего уровня</h3>
                    <p>
                        Текст, в своем роде, состоит из некоторого количества предложений. Одно предложение, даже очень распространённое, сложное, текстом назвать нельзя, поскольку текст можно разделить на самостоятельные предложения, а части предложения сочетаются по законам синтаксиса сложного предложения, но не текста.
                    </p>
                    <p>Главный тезис — текст состоит из двух или более предложений.</p>
                    <p>
                        Смысловая цельность текста
                        Основные статьи: <a href="#">Когерентность</a> (лингвистика) и Когезия (лингвистика)
                        В смысловой цельности текста отражаются те связи и зависимости, которые имеются в самой действительности (общественные события, явления природы, человек, его внешний облик и внутренний мир, предметы неживой природы и т. д.).
                    </p>
                    <p>
                        Единство предмета речи — это тема высказывания. Тема — это смысловое ядро текста, конденсированное и обобщённое содержание текста.
                    <p>
                        Понятие «содержание высказывания» связано с категорией информативности речи и присуще только тексту. Оно сообщает читателю индивидуально-авторское понимание отношений между явлениями, их значимости во всех сферах придают ему смысловую цельность.
                    </p>
                    <p>
                        В большом тексте ведущая тема распадается на ряд составляющих подтем; подтемы членятся на более дробные, на абзацы (микротемы).
                    </p>
                    Завершённость высказывания связана со смысловой цельностью текста. Показателем законченности текста является возможность подобрать к нему заголовок, отражающий его содержание.
                    <p>
                        Таким образом, из смысловой цельности текста вытекают следующие признаки текста:
                    </p>
                </div>

            </div>

        </div>
        <!-- sidebar -->
        <div class="sidebar col-md-3 col-12">
            <div class="section search">
                <h3>Поиск</h3>
                <form action="/" method="post">
                    <input type="text" name="search-term" class="text-input" placeholder="Введите слово...">
                </form>
            </div>

            <div class="section topics">
                <h3>Категории</h3>
                <ul>
                    <li><a href="#">Программирование</a></li>
                    <li><a href="#">Дизайн</a></li>
                    <li><a href="#">Визуализаци</a></li>
                    <li><a href="#">Кейсы</a></li>
                    <li><a href="#">Мотивация</a></li>
                </ul>
            </div>

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