<?php include 'inc/header.php' ?>

<?php
  // Redirect if logged in
  hasLoggedin();

  $registerStatus = '';
  // Get data form fields
  if(isset($_POST['submit'])){
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);
    $repeatPassword = filter_input(INPUT_POST, 'repeatPassword', FILTER_DEFAULT);
    // Initialize register helper oject
    $register = new RegisterHelper($name, $email, $password, $repeatPassword);
    $register->validate_fields();

    // Register process
    if($register->hasNoErrors()) {
        $status = $register->registerUser();
        // Authernticate if registration successful
        if ($status) {
          $_SESSION['user'] = $email;
          $_SESSION['id'] = $user['id'];
          header('Location: dashboard.php');
        }
      } 
      else {
        $registerStatus = "<span style='color: red;'>Registration Failed</span> <br> ";
      }
    }
?>

  <div class="left-container">
    <div class="left-content">
      <h2>Register</h2>
        
        <?php if(!empty($registerStatus)): ?>
          <p><?php echo $registerStatus ?></p>
        <?php endif; ?>
        
        <form action="" method="post">
          <input type="text" placeholder="Name" id="email" name="name" class='<?php echo (empty($register->nameErr)) ? null : "error"; ?>'>
          <?php if(!empty($register->nameErr)): ?>
            <p class="error-text"><?php echo $register->nameErr ?></p>
          <?php endif; ?>

          <input type="email" placeholder="Email" id="email" name="email" class='<?php echo (empty($register->emailErr)) ? null : "error"; ?>'>
          <?php if(!empty($register->emailErr)): ?>
            <p class="error-text"><?php echo $register->emailErr ?></p>
          <?php endif; ?>

          <input type="password" placeholder="Password" id="password" name="password" class='<?php echo (empty($register->passwordErr)) ? null : "error"; ?>'>
          <?php if(!empty($register->passwordErr)): ?>
            <p class="error-text"><?php echo $register->passwordErr ?></p>
          <?php endif; ?>

          <input type="password" placeholder="Repeat Password" id="password" name="repeatPassword" class='<?php echo (empty($register->repeatPassErr)) ? null : "error"; ?>'>
          <?php if(!empty($register->repeatPassErr)): ?>
            <p class="error-text"><?php echo $register->repeatPassErr ?></p>
          <?php endif; ?>

          <button type="submit" name="submit" value="submit" class="login">REGISTER</button>
        </form>
        <a href="/registration/" class="forgot">Click to login</a>
    </div>
  </div>

  <div class="right-container">
    <div class="right-content">
      <h2>Registration Form</h2>
      <p>This registration form is created using pure HTML and CSS. For social icons, FontAwesome is used.</p>
    </div>
  </div>

<?php include 'inc/footer.php' ?>