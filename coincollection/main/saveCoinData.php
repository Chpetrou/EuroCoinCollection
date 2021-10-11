<<?php
    $coindate = isset($_POST['date']) ? $_POST['date'] : null;
    $coinid = isset($_POST['coinid']) ? $_POST['coinid'] : null;
    include "../includes/dboperation.php";
    $db = new DbOperation();

    $result = $db->addCoinToTheCollection($coinid, $coindate);

    echo $result;
 ?>
