<?php
    $coinid = isset($_POST['coinid']) ? $_POST['coinid'] : null;
    include "../includes/dboperation.php";
    $db = new DbOperation();

    $result = $db->deleteCoinFromTheCollection($coinid);

    echo $result;
 ?>
