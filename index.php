<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("location: template/login.html");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.1/css/all.min.css" integrity="sha512-SUwyLkI1Wgm4aEZkDkwwigXaOI2HFLy1/YW73asun4sfvlkB9Ecl99+PHfCnfWD0FJjIuFTvWMM7BZPXCckpAA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/index.css">
  <title>Welcome Home</title>
</head>

<body>
  <header>
    <div>
      <i class="fas fa-user-lock"></i>
      Demo Website
    </div>
    <a href="scripts/logout.php"><i class="fas fa-sign-out-alt"></i></a>
  </header>
  <main>
    <h1><?php echo "Welcome " . $_SESSION['first_name'] ?>!</h1>
    <a href="scripts/delete_account.php" class="delete-profile-btn">Delete Your Profile</a>
  </main>
  <footer>
    Made with ❤️ by Antra. All rights Reserved.
  </footer>
</body>

</html>