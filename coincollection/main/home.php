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

<?php include_once "sidenav.php" ?>

<div class="main">
    <div class="hometitle">
        <h1>Welcome to my Coin Collection</h1>
    </div>
    <div class="totalcoinborder">
        <span id="cointitle">Coins Collected Until Now:</span>
        <div class="coinextra">
            <div class="coinpercent"><span><?php echo round($db->getNumberOfCoinsCollectedByTotal() * 100 / $db->getTotalNumberOfCoinsByTotal(), 2) . "%"; ?></span></div>
            <div class="coinamount"><span><?php echo $db->getNumberOfCoinsCollectedByTotal() . "/" . $db->getTotalNumberOfCoinsByTotal() ?></span></div>
        </div>
    </div>
</div>

<?php include_once "footer.php" ?>

</body>
</html>

<?php
    } else {
        header('Location: index.php');
    }
?>
