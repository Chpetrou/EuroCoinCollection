<?php

class DbOperation
{
    private $conn;

    //Constructor
    function __construct()
    {
        require_once dirname(__FILE__) . '/constants.php';
        require_once dirname(__FILE__) . '/dbconnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    public function getCountryNames() {
        $countrynames = array("Austria", "Belgium", "Cyprus", "Estonia", "Finland", "France", "Germany", "Greece", "Ireland", "Italy", "Latvia", "Lithuania", "Luxembourg", "Malta", "Netherlands", "Portugal", "Slovakia", "Slovenia", "Spain", "Andorra", "Monaco", "San Marino", "Vatican City");

        return $countrynames;
    }

    public function getCountryIso() {
        $countryiso = array("AT", "BE", "CY", "EE", "FI", "FR", "DE", "GR", "IE", "IT", "LV", "LT", "LU", "MT", "NL", "PT", "SK", "SI", "ES", "AD", "MC", "SM", "VA");

        return $countryiso;
    }

    public function getCountryImages() {
        $countryimages = array("../images/flags/at.png", "../images/flags/be.png", "../images/flags/cy.png", "../images/flags/ee.png", "../images/flags/fi.png", "../images/flags/fr.png", "../images/flags/de.png", "../images/flags/gr.png", "../images/flags/ie.png", "../images/flags/it.png", "../images/flags/lv.png", "../images/flags/lt.png", "../images/flags/lu.png", "../images/flags/mt.png", "../images/flags/nl.png", "../images/flags/pt.png", "../images/flags/sk.png", "../images/flags/si.png", "../images/flags/es.png", "../images/flags/ad.png", "../images/flags/mc.png", "../images/flags/sm.png", "../images/flags/va.png");

        return $countryimages;
    }

    public function getCoinTypes() {
        $cointypes = array("1c", "2c", "5c", "10c", "20c", "50c", "1eu", "2eu");

        return $cointypes;
    }

    public function getCoinNames() {
        $coinnames = array("1 Cent", "2 Cent", "5 Cent", "10 Cent", "20 Cent", "50 Cent", "1 Euro", "2 Euro");

        return $coinnames;
    }

    public function putCountriesIntoDB() {
        $countrynames = array("Austria", "Belgium", "Cyprus", "Estonia", "Finland", "France", "Germany", "Greece", "Ireland", "Italy", "Latvia", "Lithuania", "Luxembourg", "Malta", "Netherlands", "Portugal", "Slovakia", "Slovenia", "Spain", "Andorra", "Monaco", "San Marino", "Vatican City");
        $countryiso = array("AT", "BE", "CY", "EE", "FI", "FR", "DE", "GR", "IE", "IT", "LV", "LT", "LU", "MT", "NL", "PT", "SK", "SI", "ES", "AD", "MC", "SM", "VA");
        for ($i=0; $i < count($countryiso); $i++) {
            $stmt = $this->conn->prepare("INSERT INTO countries (iso, country) VALUES ('$countryiso[$i]', '$countrynames[$i]')");
            $stmt->execute();
            echo $stmt->error;
        }
    }

    public function putcoinsIntoDB() {
        $countrynames = array("Austria", "Belgium", "Cyprus", "Estonia", "Finland", "France", "Germany", "Greece", "Ireland", "Italy", "Latvia", "Lithuania", "Luxembourg", "Malta", "Netherlands", "Portugal", "Slovakia", "Slovenia", "Spain", "Andorra", "Monaco", "San Marino", "Vatican City");
        $countryiso = array("AT", "BE", "CY", "EE", "FI", "FR", "DE", "GR", "IE", "IT", "LV", "LT", "LU", "MT", "NL", "PT", "SK", "SI", "ES", "AD", "MC", "SM", "VA");
        $cointypes = array("1c", "2c", "5c", "10c", "20c", "50c", "1eu", "2eu");
        $coinnames = array("1 Cent", "2 Cent", "5 Cent", "10 Cent", "20 Cent", "50 Cent", "1 Euro", "2 Euro");

        for ($i=0; $i < count($countryiso); $i++) {
            for ($j=0; $j < count($cointypes); $j++) {
                $stmt = $this->conn->prepare("INSERT INTO coins (type, country, imageloc) VALUES ('$cointypes[$j]', '$countryiso[$i]', '../images/$cointypes[$j]/$countrynames[$i].png')");
                $stmt->execute();
            }
        }
    }

    public function getCommonCoinImages() {
        $stmt = $this->conn->prepare("SELECT imageloc FROM coins WHERE country = 'All'");
        $stmt->execute();
        $stmt->bind_result($imageLoc);
        $images = array();

        while($stmt->fetch()) {
            array_push($images, $imageLoc);
        }
        return $images;
    }

    public function getCoinImagesByCountryAndType($country, $type) {
        $stmt = $this->conn->prepare("SELECT imageloc FROM coins WHERE country = '$country' AND type = '$type'");
        $stmt->execute();
        $stmt->bind_result($imageLoc);
        $images = array();

        while($stmt->fetch()) {
            array_push($images, $imageLoc);
        }
        return $images;
    }

    public function getCoinDetailsByCountryAndType($country, $type) {
        $stmt = $this->conn->prepare("SELECT id, type, imageloc, symbol FROM coins WHERE country = '$country' AND type = '$type'");
        $stmt->execute();
        $stmt->bind_result($id, $type, $imageLoc, $symbol);
        $details = array();

        while($stmt->fetch()) {
            $alldetails = array();
            $alldetails['id'] = $id;
            $alldetails['type'] = $type;
            $alldetails['imageloc'] = $imageLoc;
            $alldetails['symbol'] = $symbol;
            array_push($details, $alldetails);
        }
        return $details;
    }

    public function getCoinDetailsByCountry($country) {
        $stmt = $this->conn->prepare("SELECT coins.id, coins.type, coins.imageloc, coins.symbol, coinnames.coinname FROM coins INNER JOIN coinnames ON coins.type = coinnames.coinvalue AND coins.country = '$country'");
        $stmt->execute();
        $stmt->bind_result($id, $type, $imageLoc, $symbol, $coinname);
        $details = array();

        while($stmt->fetch()) {
            $alldetails = array();
            $alldetails['id'] = $id;
            $alldetails['type'] = $type;
            $alldetails['imageloc'] = $imageLoc;
            $alldetails['symbol'] = $symbol;
            $alldetails['coinname'] = $coinname;
            array_push($details, $alldetails);
        }
        echo $stmt->error;
        return $details;
    }

    public function getNumberOfCoinsCollectedByTotal() {
        $stmt = $this->conn->prepare("SELECT usercollection.id FROM usercollection INNER JOIN coins ON coins.id = usercollection.coinid;");
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows;
    }

    public function getTotalNumberOfCoinsByTotal() {
        $stmt = $this->conn->prepare("SELECT id FROM coins;");
        $stmt->execute();
        $stmt->store_result();
        echo $stmt->error;
        return $stmt->num_rows;
    }

    public function getNumberOfCoinsCollectedByType($type) {
        $stmt = $this->conn->prepare("SELECT usercollection.id FROM usercollection INNER JOIN coins ON coins.id = usercollection.coinid AND coins.type = '$type';");
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows;
    }

    public function getTotalNumberOfCoinsByType($type) {
        $stmt = $this->conn->prepare("SELECT id FROM coins WHERE type = '$type';");
        $stmt->execute();
        $stmt->store_result();
        echo $stmt->error;
        return $stmt->num_rows;
    }

    public function getNumberOfCoinsCollectedByCountry($country) {
        $stmt = $this->conn->prepare("SELECT usercollection.id FROM usercollection INNER JOIN coins ON coins.id = usercollection.coinid AND coins.country = '$country';");
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows;
    }

    public function getTotalNumberOfCoinsByCountry($country) {
        $stmt = $this->conn->prepare("SELECT id FROM coins WHERE country = '$country';");
        $stmt->execute();
        $stmt->store_result();
        echo $stmt->error;
        return $stmt->num_rows;
    }

    private function isCoinExistInCollection($coinid)
    {
        $stmt = $this->conn->prepare("SELECT coinid FROM usercollection WHERE coinid = ?");
        $stmt->bind_param("s", $coinid);
        $stmt->execute();
        $stmt->store_result();
        echo $stmt->error;
        return $stmt->num_rows > 0;
    }

    public function addCoinToTheCollection($coinid, $date) {
        if (!$this->isCoinExistInCollection($coinid)) {
            $username = "chpetrou123@gmail.com";
            $stmt = $this->conn->prepare("INSERT INTO usercollection (username, coinid, year) VALUES (?, ?, ?)");
            $stmt->bind_param("sdd", $username, $coinid, $date);
            $stmt->execute();
            return "Coin Added Successfully";
        }
        else {
            $username = "chpetrou123@gmail.com";
            $stmt = $this->conn->prepare("UPDATE usercollection SET year = ? WHERE coinid = ?");
            $stmt->bind_param("dd", $date, $coinid);
            $stmt->execute();
            return "Coin Updated Successfully";
        }
    }

    public function deleteCoinFromTheCollection($coinid) {
        if ($this->isCoinExistInCollection($coinid)) {
            $stmt = $this->conn->prepare("DELETE FROM usercollection WHERE coinid=?");
            $stmt->bind_param("d", $coinid);
            if ($stmt->execute()) {
                return "Coin Deleted Successfully";
            }
            else {
                return "Coin Not Deleted Successfully";
            }
        }
    }

    public function getCoinsFromTheCollection() {
        $stmt = $this->conn->prepare("SELECT coinid, year FROM usercollection");
        $stmt->execute();
        $stmt->bind_result($coinid, $year);
        $details = array();

        while($stmt->fetch()) {
            $alldetails = array();
            $alldetails['coinid'] = $coinid;
            $alldetails['year'] = $year;
            array_push($details, $alldetails);
        }
        return $details;
    }

    public function loginUser($email, $pass)
    {
        // $password = hash('sha512', $pass);
        // $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ? AND password = ?");
        // $stmt->bind_param("ss", $email, $password);
        // $stmt->execute();
        // $stmt->store_result();
        // return $stmt->num_rows > 0;
        // echo password_hash($pass, PASSWORD_BCRYPT) . "\n";
        $stmt = $this->conn->prepare("SELECT password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($userPass);
	    $stmt->fetch();
        return $isPassCorrect = password_verify($pass, $userPass);
    }

    public function getIDFromEmail($email)
    {
	    $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
	    $stmt->bind_param("s", $email);
	    $stmt->execute();
	    $stmt->bind_result($userID);
	    $stmt->fetch();
	    return $userID;
    }
}
