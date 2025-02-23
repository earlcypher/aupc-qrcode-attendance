<?php 
   include 'pdo.php';
   session_start();

   // If user submit the user id
   if(isset($_POST['user_id'])){
      $_SESSION['user_id'] = $_POST['user_id'];
         header('location: index.php');
      return;
   }
?>
<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Login</title>
      <link rel="stylesheet" href="styles.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
   </head>
   <body>
      <div class="container-fluid">
         <div class="row p-2 bg-color-green">
            <h2 class="col-12">Online Chat App</h2>
         </div>
         <div class="row p-2 bg-color-gray max-height-90">
            <div class="col-12 d-flex">
               <form class="" action="login.php" method="POST">
                  <h3>Enter your User Id:</h3>
                  <input type="text" name="user_id" class="form-control">
                  <button type="submit" class="btn btn-light form-control mt-2">Submit</button>
               </form>
            </div>
         </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
   </body>
</html>