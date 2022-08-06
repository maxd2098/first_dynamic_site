<?php

session_start();
require 'connect.php';

function tt($value) {
    echo '<pre>';
    print_r($value);
    echo '</pre>';
    exit();
}

function tte($value) {
    echo '<pre>';
    print_r($value);
    echo '</pre>';
}

//проверка выполнения запроса к бд
function dbCheckError($query) {
    $errInfo = $query->errorInfo();
    if ($errInfo[0] !== PDO::ERR_NONE) {
        echo $errInfo[2];
        exit();
    }
    return true;
}

// запрос на получение данных одной таблицы
function selectAll($table, $params = []) {
    global $pdo;
    $sql = "SELECT * FROM dynamic_site.$table";
    if (!empty($params)) {
        $i = 0;
        foreach($params as $key => $value) {
            if (!is_numeric($value)) {
                $value = "'" . $value . "'";
            }
            if ($i === 0) {
                $sql = $sql . " WHERE $key = $value";
            } else {
                $sql = $sql . " AND $key = $value";
            }
            $i++;
        }
    }

    $query = $pdo->prepare($sql);
    $query->execute();

    dbCheckError($query);

    return $query->fetchAll();
}

// запрос на получение одной строки с выбранной таблицы
function selectOne($table, $params = []) {
    global $pdo;
    $sql = "SELECT * FROM dynamic_site.$table";
    if (!empty($params)) {
        $i = 0;
        foreach($params as $key => $value) {
            if (!is_numeric($value)) {
                $value = "'" . $value . "'";
            }
            if ($i === 0) {
                $sql = $sql . " WHERE $key = $value";
            } else {
                $sql = $sql . " AND $key = $value";
            }
            $i++;
        }
    }
    
    $query = $pdo->prepare($sql);
    $query->execute();
    
    dbCheckError($query);
    
    return $query->fetch();
}

//запись в таблицу БД

function insert($table, $params) {
    global $pdo;
    $i = 0;
    $coll = '';
    $mask = '';
    foreach($params as $key => $value) {
        if($i === 0) {
            $coll = $coll . "$key";
            $mask = $mask . "'$value'";
        } else {
            $coll = $coll . ", $key";
            $mask = $mask . ", '$value'";
        }
        $i++;
    }
    
    $sql = "INSERT INTO dynamic_site.$table ($coll) VALUES ($mask)";

    $query = $pdo->prepare($sql);
    $query->execute($params);
    
    dbCheckError($query);
    return $pdo->lastInsertId();
}

//обновление данных в таблице
function update($table, $id, $params) {
    global $pdo;
    $i = 0;
    $str = '';
    foreach($params as $key => $value) {
        if($i === 0) {
            $str = $str . $key . " = " . "'" . $value . "'";
        } else {
            $str = $str . ", " . $key . " = " . "'" . $value . "'";
        }
        $i++;
    }
    
    $sql = "UPDATE dynamic_site.$table SET $str WHERE id = $id";
    
    $query = $pdo->prepare($sql);
    $query->execute($params);
    
    dbCheckError($query);
}

function delete($table, $id) {
    global $pdo;
    
    $sql = "DELETE FROM dynamic_site.$table WHERE id = $id";
    
    $query = $pdo->prepare($sql);
    $query->execute();
    
    dbCheckError($query);
}

// выборка записей (posts) с автором в админку
function selectAllFromPostsWithUsers($table1, $table2) {
    global $pdo;
    
    $sql = "
    SELECT t1.id, t1.title, t1.img, t1.content, t1.status, t1.id_topic,
           t1.created_date, t2.username
    FROM dynamic_site.$table1 AS t1 JOIN dynamic_site.$table2 AS t2
        ON t1.id_user = t2.id";
    
    $query = $pdo->prepare($sql);
    $query->execute();
    
    dbCheckError($query);
    return $query->fetchAll();
}

// выборка записей (posts) с автором на главную
function selectAllFromPostsWithUsersOnIndex($table1, $table2, $limit, $offset) {
    global $pdo;
    
    $sql = "
    SELECT p.*, u.username
    FROM dynamic_site.$table1 AS p JOIN dynamic_site.$table2 AS u
        ON p.id_user = u.id
    WHERE p.status = 1 LIMIT $limit OFFSET $offset";
    
    $query = $pdo->prepare($sql);
    $query->execute();
    
    dbCheckError($query);
    return $query->fetchAll();
}

// выборка топовых записей
function selectTopTopicsFromPost($table) {
    global $pdo;
    
    $sql = "SELECT * FROM dynamic_site.$table WHERE id_topic = 12";
    
    $query = $pdo->prepare($sql);
    $query->execute();
    
    dbCheckError($query);
    return $query->fetchAll();
}

// поиск по заголовкам и содержимому (простой)
function searchInTitleAndContent($text, $table1, $table2) {
    global $pdo;
    $text = trim(strip_tags(stripcslashes(htmlspecialchars($text))));
    $sql = "
        SELECT p.*, u.username
        FROM dynamic_site.$table1 AS p
            JOIN dynamic_site.$table2 AS u
            ON p.id_user = u.id
        WHERE p.status = 1
        AND p.title LIKE '%$text%' OR p.content LIKE '%$text%'";
    
    $query = $pdo->prepare($sql);
    $query->execute();
    
    dbCheckError($query);
    return $query->fetchAll();
}

// выборка записей (posts) с автором для single
function selectPostFromPostsWithUsersOnSingle($table1, $table2, $id) {
    global $pdo;
    
    $sql = "
    SELECT p.*, u.username
    FROM dynamic_site.$table1 AS p JOIN dynamic_site.$table2 AS u
        ON p.id_user = u.id
    WHERE p.id = $id";
    
    $query = $pdo->prepare($sql);
    $query->execute();
    
    dbCheckError($query);
    return $query->fetch();
}

// выборка записей (posts) для пагинации на главной
function countRow($table) {
    global $pdo;
    
    $sql = "SELECT COUNT(*) FROM dynamic_site.$table WHERE status = 1";
    
    $query = $pdo->prepare($sql);
    $query->execute();
    
    dbCheckError($query);
    return $query->fetchColumn();
}

function selectAllFromPostsWithUsernameToCategory($table1, $table2, $params = [], $limit, $offset) {
    
    global $pdo;
    $sql = "SELECT t1.*, t2.username FROM dynamic_site.$table1 AS t1 JOIN dynamic_site.$table2 AS t2
        ON t1.id_user = t2.id";
    if (!empty($params)) {
        $i = 0;
        foreach($params as $key => $value) {
            if (!is_numeric($value)) {
                $value = "'" . $value . "'";
            }
            if ($i === 0) {
                $sql = $sql . " WHERE $key = $value";
            } else {
                $sql = $sql . " AND $key = $value";
            }
            $i++;
        }
    }
    $sql .= " LIMIT $limit OFFSET $offset";
    
    $query = $pdo->prepare($sql);
    $query->execute();
    
    dbCheckError($query);
    
    return $query->fetchAll();
}

// выборка записей (posts) для пагинации в категориях
function countRowPostsFromCategory($table, $id_topic) {
    global $pdo;
    
    $sql = "SELECT COUNT(*) FROM dynamic_site.$table WHERE status = 1 AND id_topic = $id_topic";
    
    $query = $pdo->prepare($sql);
    $query->execute();
    
    dbCheckError($query);
    return $query->fetchColumn();
}