<?php 
  session_start();

  if (!isset($_SESSION['username'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Chat Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="stylesheet" 
	      href="css/style.css">
	<link rel="icon" href="img/logo.png">
</head>
<body class="d-flex
             justify-content-center
             align-items-center
             vh-100">
	 <div class="lg:w-2/5 md:w-9/12 sm:w-10/12 w-11/12 p-2">
	 	<form method="post" 
	 	      action="app/http/auth.php">
	 		<div class="flex
	 		            justify-center
	 		            items-center
	 		            flex-column">
	 		<h3 class="text-4xl text-indigo-600
	 		           text-center pb-10">
	 			       LOGIN</h3>   


	 		</div>
	 		<?php if (isset($_GET['error'])) { ?>
	 		<div class="alert alert-warning" role="alert">
			  <?php echo htmlspecialchars($_GET['error']);?>
			</div>
			<?php } ?>
			
	 		<?php if (isset($_GET['success'])) { ?>
	 		<div class="alert alert-success" role="alert">
			  <?php echo htmlspecialchars($_GET['success']);?>
			</div>
			<?php } ?>
		  <div class="mb-3">
		    <label class="form-label text-indigo-400">
		           User name</label>
		    <input type="text" 
		           class="form-control text-zinc-600 rounded-full"
		           name="username">
		  </div>

		  <div class="mb-3">
		    <label class="form-label text-indigo-400">
		           Password</label>
		    <input type="password" 
		           class="form-control text-zinc-600 rounded-full"
		           name="password">
		  </div>
		  
		  <button type="submit" 
		          class="text-white bg-indigo-600 px-4 py-2 rounded-full">
		          LOGIN</button>
		</form>
		<br>
			<p class="text-zinc-600 pt-1">Already have an account?<a href="manu.php" class="text-indigo-600 pl-2">Login</a></p>
	 </div>
</body>
</html>
<?php
  }else{
  	header("Location: home.php");
   	exit;
  }
 ?>