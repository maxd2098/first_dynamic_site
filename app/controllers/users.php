<?php

include SITE_ROOT . "/app/database/db.php";

function userAuth($user) {
    $_SESSION['id'] = $user['id'];
    $_SESSION['login'] = $user['username'];
    $_SESSION['admin'] = $user['admin'];
    
    if($_SESSION['admin']) {
        header('location: ' . BASE_URL . 'admin/posts/index.php');
    } else {
        header('location: ' . BASE_URL);
    }
}

$users = selectAll('users');

$isSubmit = false;
$errMsg = [];

// код для формы регистрации
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-reg'])) {
    $admin = 0;
    $login = trim($_POST['login']);
    $email = trim($_POST['mail']);
    $passF = trim($_POST['pass-first']);
    $passS = trim($_POST['pass-second']);
    
    if($login === '' || $email === '' || $passF === '') {
        $errMsg []= 'Не все поля заполнены!';
    } elseif (mb_strlen($login, 'UTF8') < 2) {
        $errMsg []= "Логин должен быть более 2-х символов";
    } elseif ($passF !== $passS) {
        $errMsg []= "Пароли в обоих полях должны соотвествовать";
    }
    else {
        $existence = selectOne('users', ['email' => $email]);
        if (!empty($existence['email']) && $existence['email'] === $email) {
            $errMsg []= "Пользователь с такой почтой уже зарегистрирован";
        } else {
            $pass = password_hash($passF, PASSWORD_DEFAULT);
            $post = [
                'admin' => $admin,
                'username' => $login,
                'email' => $email,
                'password' => $pass,
            ];
            $id = insert('users', $post);
            $user = selectOne('users', ['id' => $id]);
            
            userAuth($user);
        }
        
    }
} else {
    $login = '';
    $email = '';
}

if (isset($_SESSION['count']) && $_SESSION['count'] >= 2) {
    if ((time() - $_SESSION['time']) < 5) {
        header('location: ' . BASE_URL);
    } else {
        unset($_SESSION['count']);
    }
    
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-log'])) {
        $email = trim($_POST['mail']);
        $pass = trim($_POST['password']);
        
        if($email === '' || $pass === '') {
            $errMsg []= 'Не все поля заполнены!';
        } else {
            $existence = selectOne('users', ['email' => $email]);
            if ($existence && password_verify($pass, $existence['password'])) {
                unset($_SESSION['count']);
                unset($_SESSION['time']);
                userAuth($existence);
            } else {
                $errMsg []= "Почта либо пароль введены неверно!";
                if (!isset($_SESSION['count'])) {
                    $_SESSION['count'] = 1;
                } else {
                    $_SESSION['count']++;
                    $_SESSION['time'] = time();
                }
            }
        }
    } else {
        $email = '';
    }
}

// код для добавления пользователя в админке
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create-user'])) {
    
    $admin = 0;
    $login = trim($_POST['login']);
    $email = trim($_POST['mail']);
    $passF = trim($_POST['pass-first']);
    $passS = trim($_POST['pass-second']);
    
    if($login === '' || $email === '' || $passF === '') {
        $errMsg []= 'Не все поля заполнены!';
    } elseif (mb_strlen($login, 'UTF8') < 2) {
        $errMsg []= "Логин должен быть более 2-х символов";
    } elseif ($passF !== $passS) {
        $errMsg []= "Пароли в обоих полях должны соотвествовать";
    }
    else {
        $existence = selectOne('users', ['email' => $email]);
        if (!empty($existence['email']) && $existence['email'] === $email) {
            $errMsg []= "Пользователь с такой почтой уже зарегистрирован";
        } else {
            $pass = password_hash($passF, PASSWORD_DEFAULT);
            if (isset($_POST['admin'])) {
                $admin = 1;
            }
            $user = [
                'admin' => $admin,
                'username' => $login,
                'email' => $email,
                'password' => $pass,
            ];
            $id = insert('users', $user);
            $user = selectOne('users', ['id' => $id]);
            
            userAuth($user);
        }
        
    }
} else {
    $login = '';
    $email = '';
}

// удаление пользователя в админке
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    delete('users', $id);
    header('location: ' . BASE_URL . 'admin/users/index.php');
}

// редактирование пользователя через админку
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['edit_id'])) {
    $user = selectOne('users', ['id' => $_GET['edit_id']]);
    
    $id = $user['id'];
    $admin = $user['admin'];
    $username = $user['username'];
    $email = $user['email'];
    
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-user'])) {
    
    $id = $_POST['id'];
    $mail = trim($_POST['mail']);
    $login = trim($_POST['login']);
    $passF = trim($_POST['pass-first']);
    $passS = trim($_POST['pass-second']);
    
    $admin = isset($_POST['admin']) ? 1 : 0;
    
    if($login === '') {
        $errMsg []= 'Не все поля заполнены!';
    } elseif (mb_strlen($login, 'UTF8') < 2) {
        $errMsg []= "Логин должен быть более 2-х символов";
    } elseif ($passF !== $passS) {
        $errMsg []= "Пароли в обоих полях должны соотвествовать";
    }
    else {
        $pass = password_hash($passF, PASSWORD_DEFAULT);
        if (isset($_POST['admin'])) {
            $admin = 1;
        }
        $user = [
            'admin' => $admin,
            'username' => $login,
            //'email' => $mail,
            'password' => $pass,
        ];
        $user = update('users', $id, $user);
        header('location: ' . BASE_URL . 'admin/users/index.php');
    }
} else {
    if (isset($user)) {
        $id = $user['id'];
        $admin = $user['admin'];
        $username = $user['username'];
        $email = $user['email'];
    }
    
//    $id ='';
//    $admin = '';
//    $username = '';
//    $email = '';
}

//if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pub_id'])) {
//    $id = $_GET['pub_id'];
//    $publish = $_GET['publish'];
//
//    $postId = update('posts', $id, ['status' => $publish] );
//
//    header('location: ' . BASE_URL . 'admin/posts/index.php');
//    exit();
//}





    
