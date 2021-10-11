<?php
    session_start();
    if (isset($_SESSION['token'])) {
?>

<?php
    $coinvalue = $_GET['coin'];
    $coinname = $_GET['coinname'];
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

            $countryiso = $db->getCountryIso();
            $countryname = $db->getCountryNames();
            $coinnames =  $db->getCoinNames();
            $cointypes = $db->getCoinTypes();
        ?>

        <div class="main">
            <div class="topheaderwrapper">
                <div class="topheader">
                    <?php for ($i=0; $i < count($coinnames); $i++) { ?>
                        <div onclick="window.location='http://localhost/main/coin.php?coin=<?php echo $cointypes[$i] ?>&coinname=<?php echo $coinnames[$i] ?>';" class="topheaderitem"><span><?php echo $coinnames[$i]; ?></span></div>
                    <?php } ?>
                </div>
            </div>
            <?php
                for ($i=0; $i < count($countryiso); $i++) {
            ?>
                <div class="fullcountry">
                    <div class="country">
                        <div class="countryflag">

                        </div>
                        <div class="countryname">
                            <span><?php echo $countryname[$i] ?></span>
                        </div>
                    </div>
            <?php
                    $coins = $db->getCoinDetailsByCountryAndType($countryiso[$i], $coinvalue);
                    foreach ($coins as $value) {
            ?>
                        <div class="<?php echo (count($coins) > 1 ? "collection" : "collectionextra"); ?>" id="<?php echo $value['id'] ?>">
                            <div class="coin" id="<?php echo $value['id'] ?>">
                                <div class="coinimage" id="<?php echo $value['id'] ?>">
                                    <img src="<?php echo $value['imageloc'];?>">
                                </div>
                                <div class="coinextra" id="<?php echo $value['id'] ?>">
                                    <div class="cointext"><span><?php echo $coinname; ?></span></div>
                                    <input type="text" id="<?php echo $value['id'] ?>">
                                    <label class="container">
                                        <input type="checkbox" id="<?php echo $value['id'] ?>" onclick="saveCoinSelection(this)">
                                        <span class="checkmark"></span>
                                    </label>
                                    <?php if (!empty($value['symbol'])) { ?>
                                        <div class="symbol"><span><?php echo $value['symbol'] ?></span></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
            <?php
                    }
            ?>
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
