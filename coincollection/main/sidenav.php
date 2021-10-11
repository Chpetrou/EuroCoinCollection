<?php
    // session_start();
    if (isset($_SESSION['token'])) {
?>
        <div class="sidenav">
          <a href="home.php">Home</a>
          <a href="categories.php">Categories</a>
          <a href="countries.php">Countries</a>
          <a onclick="logout()" href="#">Logout</a>
        </div>
<?php
    } else {
        header('Location: index.php');
    }
?>
