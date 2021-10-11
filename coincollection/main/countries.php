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
    $countryiso = $db->getCountryIso();
    $countryname = $db->getCountryNames();
    $countryimages = $db->getCountryImages();
    $coinnames =  $db->getCoinNames();
?>

<div class="main">
    <?php
        for ($i=0; $i < count($countryname); $i++) {
    ?>
    <div class="collection">
        <div onclick="window.location='http://localhost/main/countrycoin.php?country=<?php echo $countryiso[$i] ?>&countryname=<?php echo $countryname[$i] ?>&countryimage=<?php echo $countryimages[$i] ?>';" class="coin">
            <div class="countryimage">
                <img src="<?php echo $countryimages[$i]?>">
            </div>
            <div class="coinextra">
                <div class="coinpercent"><span><?php echo round($db->getNumberOfCoinsCollectedByCountry($countryiso[$i]) * 100 / $db->getTotalNumberOfCoinsByCountry($countryiso[$i]), 2) . "%"; ?></span></div>
                <div class="coinamount"><span><?php echo $db->getNumberOfCoinsCollectedByCountry($countryiso[$i]) . "/" . $db->getTotalNumberOfCoinsByCountry($countryiso[$i]) ?></span></div>
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
