<?php 
/** 
 * Created by OpenMaps.
 * Date: 02/02/2016  
 */
$page_title = 'Admin Login | Securing Land for prosperity';
include ('./includes/header.html');
?>
<html>    
<body>  
<div class="container">
	<div class="openmaps-top">
		<a href="./index.html">
			<strong>Urithi Geolocation Service</strong>
		</a>
		<span class="right">
			<a href="./Admin_login.php">
				<strong>Urithi</strong>
			</a>
		</span>
	</div>
	<section class="main">
		<form class="form-4" method="post" action="Admin_login.php">
			<h1><span class="log-in">Log in</span></h1>
				<p class="float">
					<label for="admin_name"><i class="icon-user"></i>Admin Name</label>
					<input type="text" name="admin_name" placeholder="Admin name">
				</p>
				<p class="float">
					<label for="admin_pass"><i class="icon-lock"></i>Password</label>
					<input type="password" name="admin_pass" placeholder="Password" class="showpassword">
				</p>
				<p class="clearfix"> 
				<input type="submit" name="submit" value="Log in">
				</p>
		</form>​​
	</section>  
</div>
</body>  
</html>  
  
<?php     
include ('./includes/db_connection.php');  
  
if(isset($_POST['submit'])){  
    $admin_name=$_POST['admin_name'];  
    $admin_pass=$_POST['admin_pass'];  
  
    $admin_query="select admin_name, admin_pass from public.admin where (admin_name='$admin_name' AND admin_pass= md5('$admin_pass'))";  
  
    $run_query=pg_query($con,$admin_query);
    if(pg_num_rows($run_query)== 1)  
    {  
  
        echo "<script>window.open('view_users.php','_self')</script>";  
    }  
    else {echo"<script>alert('Admin Details are incorrect..!')</script>";}  
  
}  
  
?> 