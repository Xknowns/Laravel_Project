<?php
require_once 'connection.php';
session_start();
if(isset($_SESSION['user'])) {
      header("location: welcome.php");
}
   
if(isset($_REQUEST['register_btn'])) {

      $name = filter_var($_REQUEST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
      $email = filter_var($_REQUEST['email'], FILTER_SANITIZE_EMAIL);
      $password = filter_var($_REQUEST['password']);
      
      // Initialize error array
      $errorMsg = array();
      
      // Validate name
      if(empty($name)) {
         $errorMsg['name'] = 'Name required';
      }
      
      // Validate email
      if(empty($email)) {
         $errorMsg['email'] = 'Email required';
      } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $errorMsg['email'] = 'Please enter a valid email address';
      }
      
      // Validate password
      if(empty($password)) {
         $errorMsg['password'] = 'Password required';
      } elseif(strlen($password) < 8) {
         $errorMsg['password'] = 'Password must be at least 8 characters long';
      } elseif(!preg_match('/[A-Z]/', $password)) {
         $errorMsg['password'] = 'Password must contain at least one uppercase letter';
      } elseif(!preg_match('/[a-z]/', $password)) {
         $errorMsg['password'] = 'Password must contain at least one lowercase letter';
      } elseif(!preg_match('/[0-9]/', $password)) {
         $errorMsg['password'] = 'Password must contain at least one number';
      } elseif(!preg_match('/[^A-Za-z0-9]/', $password)) {
         $errorMsg['password'] = 'Password must contain at least one special character (!@#$%^&*()_+-=[]{}|;:,.<>?)';
      }
      
      // Check for duplicate email only if basic validations pass
      if(empty($errorMsg)) {
          try{
             $select_stmt = $db->prepare("SELECT name,email FROM users WHERE email = :email");
             $select_stmt->execute([':email' => $email]);
             $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
          
             
             if($row) {
               $errorMsg['email'] = "Email address already exists, please choose another or login instead";
             } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $created = new DateTime();
            $created = $created->format('Y-m-d H:i:s');

            $insert_stmt = $db->prepare("INSERT INTO users (name,email,password, created) VALUES (:name, :email, :password, :created)");

            if(
                $insert_stmt->execute(
                    [
                        ':name'=>$name,
                        ':email'=>$email,
                        ':password'=>$hashed_password,
                        ':created'=>$created
                    ]
                ) ){
                    header("location: index.php?msg=".urlencode('Click the verification email'));
                }
             }
          }
          catch(PDOException $e) {
               $pdoError = $e->getMessage();
               echo "Database error: " . $pdoError;
          }
          catch(PDOException $e) {
               $pdoError = $e->getMessage();
          }
      }
      
      // If no errors, proceed with registration
      /*if(empty($errorMsg)) {
          // Your registration logic here
          echo "Registration successful!";
          // Add your database insertion code here
      }*/
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <title>Register</title>
</head>
<body>
    <div class="container">
       
        <form action="register.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Jane Doe" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
                <?php
                if(isset($errorMsg['name'])) {
                    echo "<p class='small text-danger mt-1'>". $errorMsg['name']."</p>";
                }
                ?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" placeholder="jane@doe.com" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                <?php
                if(isset($errorMsg['email'])) {
                    echo "<p class='small text-danger mt-1'>". $errorMsg['email']."</p>";
                }
                ?>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="">
                <?php
                if(isset($errorMsg['password'])) {
                    echo "<p class='small text-danger mt-1'>". $errorMsg['password']."</p>";
                }
                ?>
                <small class="form-text text-muted">
                    Password must be at least 8 characters long and contain:
                    <br>• One uppercase letter (A-Z)
                    <br>• One lowercase letter (a-z)
                    <br>• One number (0-9)
                    <br>• One special character (!@#$%^&*()_+-=[]{}|;:,.<>?)
                </small>
            </div>
            <button type="submit" name="register_btn" class="btn btn-primary">Register Account</button>
        </form>
        Already Have an Account? <a class="register" href="index.php">Login Instead</a>
    </div>
</body>
</html>
