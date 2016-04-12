<?php 
$page_title = 'Login | Securing Land for prosperity';
include ('./includes/header.html');  
?>  
<html lang="en">
<body>  
<div class="container">
		<div class="openmaps-top">
			<a href="index.html">
				<strong>&laquo;</strong>Urithi Geolocation Service
			</a>
			<span class="right">
				<a href="Login.php">
					<strong>Urithi</strong>
				</a>
			</span>
		</div>
		
		<header>
		
			<h1><strong>Urithi Housing Cooperative Society Ltd‎</strong></h1>
			<h2>Geolocation of realty</h2>
			
		</header>
		
		<section class="main">
			<form class="form-2" method="post" action="Login.php">
			<h1><span class="log-in">Log in</span></h1>
				<p class="float">
					<label for="email"><i class="icon-user"></i>Email</label>
					<input type="text" name="email" placeholder="email">
				</p>
				<p class="float">
					<label for="passwd"><i class="icon-lock"></i>Password</label>
					<input type="password" name="passwd" placeholder="Password" class="showpassword">
				</p>
				<p class="clearfix"> 
				<input type="submit" name="login" value="Log in">
				</p>
			</form>​​
		</section>
</div>  
</body>  
</html>  
<?php  
  
include("./includes/db_connection.php");   
if(isset($_POST['login']))  
{  
	$user_email=$_POST['email'];  
	$user_pass=$_POST['passwd'];  
  
	$check_user="select user_email, user_pass from public.user WHERE (user_email='$user_email'AND user_pass=md5('$user_pass'))";  
  
	$run=pg_query($con,$check_user);  
  
	if(pg_num_rows($run)== 1)  
	{  
		echo "<script>window.open('map.php','_self')</script>";  
  
		$_SESSION['email']=$user_email;//here session is used and value of $user_email store in $_SESSION.  
  
	}  
	else  
	{  
	  echo "<script>alert('Email or password is incorrect!')</script>";  
	}  
}  
?>  