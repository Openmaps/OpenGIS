<?php 
$page_title = 'Registration | Securing Land for prosperity';
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
                    <a href="Registration.php">
                        <strong>Urithi</strong>
                    </a>
                </span>
            </div>
			
			<header>
				<h1><strong>Urithi Housing Cooperative Society Ltd‎</strong></h1>
				<h2>Geolocation of realty</h2>
			</header>
			
			<section class="main">
				<form class="form-2" method="post" action="registration.php">
					<h1><span class="sign-up">sign up</span></h1>
					<p class="float">
						<label for="email"><i class="icon-user"></i>Email</label>
						<input type="text" name="email" placeholder="Email">
					</p>
					<p class="float">
						<label for="pass"><i class="icon-lock"></i>Password</label>
						<input type="password" name="pass" placeholder="Password" class="showpassword">
					</p>
					<p class="clearfix"> 
					<input type="submit" value="register" name="register">
					</p>
				</form>​​
				<center><b>Already registered ?</b> <br></b><a href="login.php">Login here</a></center>
			</section>
        </div>
</body>  
  
</html>  
  
<?php  
include("./includes/db_connection.php");  	
if(isset($_POST['register'])){
	//here getting result from the post array after submitting the form.
	$user_pass=$_POST['pass'];  
	$user_email=$_POST['email'];  
  
	if($user_pass==''){   
		exit();  
	}  
  
	if($user_email==''){    
		exit();  
	}  
	
	$check_email_query = "select user_email from public.user WHERE user_email='$user_email'";  
	$run_query=pg_query($con,$check_email_query);  
  
	if(pg_num_rows($run_query) > 0){  
		echo "<script>alert('Email $user_email is already exist in our database, Please try another one!')</script>";  
		exit();  
	}  
	//database.	
	$new_user="INSERT INTO public.user (user_email, user_pass, registration_date) VALUES ('$user_email', md5('$user_pass'), NOW())";  
	if(pg_query($con,$new_user)){  
		echo"<script>window.open('map.php','_self')</script>";  
	}   
}   
?>  