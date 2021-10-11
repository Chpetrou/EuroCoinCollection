<?php
    include "../includes/dboperation.php";
    $db = new DbOperation();

    $result = $db->getCoinsFromTheCollection();

    echo json_encode($result);
 ?>
