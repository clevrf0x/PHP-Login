<?php include 'inc/header.php' ?>

<?php 
  // Redirect if logged in
  hasLoggedin();

  $loginErr = $login = '';
  if(isset($_POST['submit'])) {
    // Get user input
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = isset($_POST['password'])? $_POST['password'] : '';
    
    // Initializing login object
    $login = new LoginHelper($email, $password);
    $login->validate_fields();

    // Login 
    if($login->hasNoErrors()) {
      $user = $login->authenticate();
      if (!empty($user)) {
        $_SESSION['user'] = $email;
        $_SESSION['id'] = $user['id'];
        header('Location: dashboard.php');
      } 
      else {
        $loginErr = 'Invalid email or password';
      }
    }
  }
?>

  <div class="left-container">
    <div class="left-content">
      <h2>Login</h2>
      <a href="http://facebook.com" target="_blank" rel="noopener noreferrer">
        <i class="fa-brands fa-facebook-f socials"></i>
      </a>
      <a href="http://twitter.com" target="_blank" rel="noopener noreferrer">
        <i class="fa-brands fa-twitter socials"></i>
      </a>
      <p>or use your account</p>

        <?php if(!empty($loginErr)): ?>
          <p style="color: red;"><?php echo $loginErr ?></p>
        <?php endif; ?>

      <form action="" method="post">
        
        <input type="email" name="email" placeholder="Email" id="email" class='<?php echo (empty($login->emailErr)) ? null : "error"; ?>'>
        <?php if(!empty($login->emailErr)): ?>
          <p class="error-text"><?php echo $login->emailErr ?></p>
        <?php endif; ?>
        
        <input type="password" name="password" placeholder="Password" id="password" class='<?php echo (empty($login->passwordErr)) ? null : "error"; ?>'>
        <?php if(!empty($login->passwordErr)): ?>
          <p class="error-text"><?php echo $login->passwordErr ?></p>
        <?php endif; ?>
        
        <button type="submit" name="submit" value="submit" class="login">LOG IN</button>
      </form>
      <a href="register.php" class="forgot">Register account</a>
    </div>
  </div>

  <div class="right-container">
    <div class="right-content">
      <h2>Login Form</h2>
      <p>This login form is created using pure HTML and CSS. For social icons, FontAwesome is used.</p>
    </div>
  </div>

<?php include 'inc/footer.php' ?>