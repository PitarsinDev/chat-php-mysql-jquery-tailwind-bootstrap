<?php 
  session_start();

  if (!isset($_SESSION['username'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Chat Sign Up</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="stylesheet" 
	      href="css/style.css">
	<link rel="icon" href="img/logo.png">
</head>
<body class="flex
             justify-center
             items-start
			 pt-10
             vh-100">
	 <div class="lg:w-2/5 md:w-9/12 sm:w-10/12 w-11/12 p-2">
	 	<form method="post" 
	 	      action="app/http/signup.php"
	 	      enctype="multipart/form-data">
	 		<div class="d-flex
	 		            justify-content-center
	 		            align-items-center
	 		            flex-column">
	 		<h3 class="display-4 fs-1 
	 		           text-center text-indigo-600">
	 			       Admin User</h3>   
	 		</div>

	 		<?php if (isset($_GET['error'])) { ?>
	 		<div class="alert alert-warning" role="alert">
			  <?php echo htmlspecialchars($_GET['error']);?>
			</div>
			<?php } 
              
              if (isset($_GET['name'])) {
              	$name = $_GET['name'];
              }else $name = '';

              if (isset($_GET['username'])) {
              	$username = $_GET['username'];
              }else $username = '';
			?>

	 	  <div class="mb-3">
		    <label class="form-label text-indigo-400">
		           Name</label>
		    <input type="text"
		           name="name"
		           value="<?=$name?>" 
		           class="form-control text-zinc-600 rounded-full">
		  </div>

		  <div class="mb-3">
		    <label class="form-label text-indigo-400">
		           User name</label>
		    <input type="text" 
		           class="form-control text-zinc-600 rounded-full"
		           value="<?=$username?>" 
		           name="username">
		  </div>


		  <div class="mb-3">
		    <label class="form-label text-indigo-400">
		           Password</label>
		    <input type="password" 
		           class="form-control text-zinc-600 rounded-full"
		           name="password">
		  </div>

		  <div class="mb-3">
		    <label class="form-label text-indigo-400">
		           Profile Picture</label>
		    <input type="file" 
		           class="form-control text-zinc-600 rounded-full"
		           name="pp">
		  </div>
		  
		  <button type="submit" 
		          class="text-white bg-indigo-600 px-4 py-2 rounded-full">
		          Sign Up</button>
				  <br>
				  <p class="text-zinc-600 pt-4">Don't have an account yet?<a href="index.php" class="text-indigo-600 pl-2">Login</a></p>
		</form>
	 </div>
</body>
</html>
<?php
  }else{
  	header("Location: home.php");
   	exit;
  }
 ?>