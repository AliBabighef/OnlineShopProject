<?php
ob_start();
include "../include/connectDB.php";
class insertAppData
{

    public function __construct($NameStr, $E_Mail, $PassWord, $StatusUser)
    {
        global $con;
        $statment = $con->prepare("INSERT INTO usersinfo(NameStr, E_Mail, `PassWord`, StatusUser) VALUES(?,?,?,?)");
        $statment->execute(array($NameStr, $E_Mail, $PassWord, $StatusUser));
        $count = $statment->rowCount();
    }
}
class getColumn
{

    public function columnFx($column, $table, $where, $valWhere)
    {
        global $con;
        $statment = $con->prepare("SELECT $column from $table WHERE $where = ?");
        $statment->execute(array($valWhere));
        $columnId = $statment->fetchColumn();
        return $columnId;
    }
}
class getAllAppData
{

    public function allFx($table)
    {
        global $con;
        $statment = $con->prepare("SELECT * from $table");
        $statment->execute();
        $all = $statment->fetchAll();
        return $all;
    }
}
class checkColomn
{

    public function checkRowCount($select, $table, $where, $valWhere)
    {
        global $con;
        $statment = $con->prepare("SELECT $select from $table WHERE $where = ?");
        $statment->execute(array($valWhere));
        $count = $statment->rowCount();
        return $count;
    }
}

function getCountColumn($select, $table, $where, $valWhere)
{
    global $con;
    $statment = $con->prepare("SELECT COUNT($select) from $table WHERE $where = ?");
    $statment->execute(array($valWhere));
    $count = $statment->fetchColumn();
    return $count;
}

function getAllData($select, $table, $where, $valWhere)
{
    global $con;
    if ($where == null || $where == '' && $valWhere == null || $valWhere == '') {
        $statment = $con->prepare("SELECT $select from $table");
        $statment->execute();
        $data = $statment->fetch();
        return $data;
    } else {
        $statment = $con->prepare("SELECT $select from $table WHERE $where = ?");
        $statment->execute(array($valWhere));
        $data = $statment->fetch();
        return $data;
    }
}
function innerJoinData($select, $pageID)
{
    global $con;
    $statment = $con->prepare("SELECT $select from comments
            INNER JOIN usersinfo ON comments.namdID = usersinfo.ID
            INNER JOIN product ON comments.cateID = product.ID
            WHERE cateID = ?");
    $statment->execute(array($pageID));
    $columns = $statment->fetchAll();
    return $columns;
}

function innerJoinTable($select, $cmtID, $productID)
{
    global $con;
    $statment = $con->prepare("SELECT $select from replies
            INNER JOIN comments ON comments.ID = replies.cmtID
            WHERE cmtID = ?
            AND productID = ?");
    $statment->execute(array($cmtID, $productID));
    $columns = $statment->fetchAll();
    return $columns;
}
function replyCount($number)
{
    global $con;
    $statment = $con->prepare("SELECT COUNT(comments.ID) FROM comments 
    INNER JOIN replies ON replies.cmtID = comments.ID 
    INNER JOIN usersinfo ON usersinfo.ID = comments.namdID 
    WHERE replies.cmtID = ?;");
    $statment->execute(array($number));
    $columnReplyCount = $statment->fetchColumn();
    return $columnReplyCount;
}

function timeAgo($date, $str = "ago")
{
    $periods = array('year', 'month', 'day', 'hour', 'minute', 'second');
    if (!strtotime($date) > 0) {
        return trigger_error("wrong time format", E_USER_ERROR);
    }
    $now = new DateTime("now");
    $time = new DateTime($date);
    $difBltFx = $now->diff($time)->format("%y %m %d %h %min %s");
    $difBltFx = explode(' ', $difBltFx);
    $difBltFx = array_combine($periods, $difBltFx);
    $difBltFx = array_filter($difBltFx);
    $periods = key($difBltFx);
    $value = current($difBltFx);
    if (!$value) {
        $periods = '';
        $str = '';
        $value = 'just now';
    } else {
        if ($periods == 'day' && $value >= 7) {
            $periods = 'week';
            $value = floor($value / 7);
        }
        if ($value > 1) {
            $periods .= 's';
        }
        return $value . " " . $periods . " " . $str;
    }
    // return $value . " " . $periods . " " . $str;
}
ob_end_flush();
