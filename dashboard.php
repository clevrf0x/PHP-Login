<?php include 'inc/header.php'; ?>
<?php
  if(!isset($_SESSION['user'])) {
    header('Location: /registration');
    exit;
  } else {
    $user_id = $_SESSION['id'];
    $sql = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_array($result);
  }
?>
  <div class="dashboard-container">
    <div class="right-content">
      <h2>Welcome <?php echo $user['name'] ?></h2>
      <p>Email Address: <?php echo $user['email'] ?></p>
      <p>Created Date : <?php echo $user['date'] ?></p>
      <form action="logout.php" method="post">
        <button type="submit" class="login" style="border: 1px solid white; margin-top: 20px;">LOGOUT</button>
      </form>
    </div>
  </div>

<?php include 'inc/footer.php' ?>