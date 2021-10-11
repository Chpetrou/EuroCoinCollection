<?php
    session_start();
    if (isset($_SESSION['token'])) {
?>

<?php
    $coincountry = $_GET['country'];
    $coincountryname = $_GET['countryname'];
    $coincountryimage = $_GET['countryimage'];
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
            $countryimages = $db->getCountryImages();
        ?>

        <div class="main">
            <div class="topheaderwrapper">
                <div class="topheader">
                    <?php for ($i=0; $i < count($countryname); $i++) { ?>
                        <div onclick="window.location='http://localhost/main/countrycoin.php?country=<?php echo $countryiso[$i] ?>&countryname=<?php echo $countryname[$i] ?>&countryimage=<?php echo $countryimages[$i] ?>';" class="topheaderitem"><span><?php echo $countryname[$i]; ?></span></div>
                    <?php } ?>
                </div>
            </div>
                <div class="fullcountry">
                    <div class="country">
                        <div class="countryflag">
                            <img src="<?php echo $coincountryimage ?>" alt="<?php echo $coincountryname ?>">
                        </div>
                        <div class="countryname">
                            <span><?php echo $coincountryname ?></span>
                        </div>
                    </div>
                    <?php
                            $coins = $db->getCoinDetailsByCountry($coincountry);
                            foreach ($coins as $value) {
                    ?>
                        <div class="<?php echo (count($coins) > 1 ? "collection" : "collectionextra"); ?>" id="<?php echo $value['id'] ?>">
                            <div class="coin" id="<?php echo $value['id'] ?>">
                                <div class="coinimage" id="<?php echo $value['id'] ?>">
                                    <img src="<?php echo $value['imageloc'];?>">
                                </div>
                                <div class="coinextra" id="<?php echo $value['id'] ?>">
                                    <div class="cointext"><span><?php echo $value['coinname']; ?></span></div>
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
         </div>

        <?php include_once "footer.php" ?>

        </body>
        </html>
    <?php
        } else {
            header('Location: index.php');
        }
    ?>
