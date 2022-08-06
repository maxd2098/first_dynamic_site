<?php

include SITE_ROOT . "/app/database/db.php";

if (!$_SESSION) {
    header("location: " . BASE_URL . 'log.php');
}

$errMsg = [];
$id = '';
$title = '';
$img = '';
$content = '';
$topic = '';

$topics = selectAll('topics');
$posts = selectAll('posts');
$postsAdm = selectAllFromPostsWithUsers('posts', 'users');

//tt($postsAdm);

// форма создания записи
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_post'])) {
    
    if (!empty($_FILES['img']['name'])) {
        $imgName = time() . "_" . $_FILES['img']['name'];
        $fileTmpName = $_FILES['img']['tmp_name'];
        $fileType = $_FILES['img']['type'];
        $fileSize = $_FILES['img']['size'];
        $destination = ROOT_PATH . "\assets\images\posts\\" . $imgName;
        
        if(strpos($fileType, 'image') !== false) {
            $result = move_uploaded_file($fileTmpName, $destination);
            if ($result) {
                $_POST['img'] = $imgName;
            } else {
                $errMsg []= "Ошибка загрузки изображения на сервер";
            }
        }
        
    } else {
        $errMsg []= "Ошибка получения картинки";
    }
    
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $topic = trim($_POST['topic']);
    
    $publish = isset($_POST['publish']) ? 1 : 0;

    if($title === '' || $content === '' || $topic === '') {
        $errMsg []= 'Не все поля заполнены!';
    } elseif (mb_strlen($title, 'UTF8') < 5) {
        $errMsg []= "Название статьи должно быть более 5 символов";
    } elseif(!empty($_FILES['img']['name']) && strpos($fileType, 'image') === false) {
        $errMsg []= "Можно загружать только изображения";
    } else {
        $post = [
            'id_user' => $_SESSION['id'],
            'title' => $title,
            'img' => $_POST['img'],
            'content' => $content,
            'status' => $publish,
            'id_topic' => $topic
            
        ];
        $post = insert('posts', $post);
        $post = selectOne('posts', ['id' => $id]);
        header('location: ' . BASE_URL . 'admin/posts/index.php');
    }
} else {
    $id = '';
    $title = '';
    $content = '';
    $publish = '';
    $topic = '';
}

// редактирование статьи
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $post = selectOne('posts', ['id' => $_GET['id']]);
    
    $id = $post['id'];
    $title = $post['title'];
    $content = $post['content'];
    $topic = $post['id_topic'];
    $publish = $post['status'];

}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_post'])) {
    $id = $_POST['id'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $topic = trim($_POST['topic']);
    
    $publish = isset($_POST['publish']) ? 1 : 0;
    
    if (!empty($_FILES['img']['name'])) {
        $imgName = time() . "_" . $_FILES['img']['name'];
        $fileTmpName = $_FILES['img']['tmp_name'];
        $fileType = $_FILES['img']['type'];
        $fileSize = $_FILES['img']['size'];
        $destination = ROOT_PATH . "\assets\images\posts\\" . $imgName;
        
        if(strpos($fileType, 'image') !== false) {
            $result = move_uploaded_file($fileTmpName, $destination);
            if ($result) {
                $_POST['img'] = $imgName;
            } else {
                $errMsg []= "Ошибка загрузки изображения на сервер";
            }
        }
        
    } else {
        $errMsg []= "Ошибка получения картинки";
    }
    
    if($title === '' || $content === '' || $topic === '') {
        $errMsg []= 'Не все поля заполнены!';
    } elseif (mb_strlen($title, 'UTF8') < 5) {
        $errMsg []= "Название статьи должно быть более 5 символов";
    } elseif(!empty($_FILES['img']['name']) && strpos($fileType, 'image') === false) {
        $errMsg []= "Можно загружать только изображения";
    } else {
        $post = [
            'id_user' => $_SESSION['id'],
            'title' => $title,
            'img' => $_POST['img'],
            'content' => $content,
            'status' => $publish,
            'id_topic' => $topic
        
        ];
        $post = update('posts', $id, $post);
        header('location: ' . BASE_URL . 'admin/posts/index.php');
    }
} else {
    $title = '';
    $content = '';
    $publish = '';
    $topic = '';
//    $title = $_POST['title'];
//    $content = $_POST['content'];
//    $publish = isset($_POST['publish']) ? 1 : 0;
//    $topic = $_POST['id_topic'];
}

// удаление статьи
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    delete('posts', $id);
    header('location: ' . BASE_URL . 'admin/posts/index.php');
}

// статус опубликовать или снять с публикации
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pub_id'])) {
    $id = $_GET['pub_id'];
    $publish = $_GET['publish'];
    
    $postId = update('posts', $id, ['status' => $publish] );
    
    header('location: ' . BASE_URL . 'admin/posts/index.php');
    exit();
}











