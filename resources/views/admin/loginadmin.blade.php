<!DOCTYPE html>
<html>
<head>
	<title>{{ $title }}</title>
	
	<!-- VANILLA CSS -->

	<link rel="stylesheet" type="text/css" href="assets/css/login.css">
	
	<!-- FONT -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	
	<!-- ICON -->
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>

	{{-- bootstrap --}}
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	
</head>
<body>

	<div class="cont">

		<div class="img">
			<img src="assets/img/admin.png">
		</div>

		<div class="login-content">
			<form action="/loginadmin" method="post">
				@csrf
				@if (session()->has('gallog'))
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>Login Failed!</strong> This username or password does not exist.
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				@endif
				
				<h2 class="title">Welcome Our Team</h2>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Username</h5>
           		   		<input type="text" class="input" name="username" required>
           		   </div>
           		</div>

           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Password</h5>
           		    	<input type="password" class="input" name="password" required>
            	   </div>
            	</div>

				<div class="link">
					<a href="#" class="a">Forgot Password?</a>
				</div>

            	<input type="submit" class="btn-log" value="Login">
            
            </form>
        </div>
    </div>

    <script type="text/javascript" src="assets/js/login.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>

</body>
</html>