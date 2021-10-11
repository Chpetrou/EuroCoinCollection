<?php
    session_start();
    if (isset($_SESSION['token'])) {
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="main.css">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php
    include "../includes/dboperation.php";
    $db = new DbOperation();
 ?>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <script src="main.js"></script>

</head>
<body>

<?php

    include_once "sidenav.php";

    $images = $db->getCommonCoinImages();
    $cointypes = $db->getCoinTypes();
    $coinnames = $db->getCoinNames();
?>

<div class="main">
    <?php
        for ($i=0; $i < count($cointypes); $i++) {
    ?>
    <div class="collection">
        <div onclick="window.location='http://localhost/main/coin.php?coin=<?php echo $cointypes[$i] ?>&coinname=<?php echo $coinnames[$i] ?>';" class="coin">
            <div class="coinimage">
                <img src="<?php echo $images[$i]?>">
            </div>
            <div class="coinextra">
                <div class="coinpercent"><span><?php echo round($db->getNumberOfCoinsCollectedByType($cointypes[$i]) * 100 / $db->getTotalNumberOfCoinsByType($cointypes[$i]), 2) . "%"; ?></span></div>
                <div class="coinamount"><span><?php echo $db->getNumberOfCoinsCollectedByType($cointypes[$i]) . "/" . $db->getTotalNumberOfCoinsByType($cointypes[$i]) ?></span></div>
            </div>
        </div>
    </div>
    <?php
        }
    ?>
 </div>

<?php include_once "footer.php" ?>

</body>
</html>
<?php
    } else {
        header('Location: index.php');
    }
?>
