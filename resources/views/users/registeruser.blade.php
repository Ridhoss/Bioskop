<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
	
	<link rel="icon" href="assets/img/brand.png">

    {{-- vanilla css --}}
    <link rel="stylesheet" type="text/css" href="assets/css/reg.css">
    <!-- FONT -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	
	<!-- ICON -->
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>

	{{-- bootstrap --}}
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>

    <div class="cont">

		<div class="img">
			@error('username')
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>Registration Failed!</strong> {{ $message }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@enderror
			@error('password')
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>Registration Failed!</strong> {{ $message }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@enderror
			@error('email')
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>Registration Failed!</strong> {{ $message }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@enderror
			@error('Name')
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>Registration Failed!</strong> {{ $message }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@enderror
			@error('Phone')
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>Registration Failed!</strong> {{ $message }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@enderror
			<img src="assets/img/login.png">
		</div>

		<div class="login-content">
			<form action="/reguser" method="post">
				@csrf
				<h2 class="title fw-bold">Signup
					<br>TIP Family</h2>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Username</h5>
           		   		<input type="text" class="input" name="username" minlength="5" required>
           		   </div>
           		</div>

           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Password</h5>
           		    	<input type="password" class="input" name="password" minlength="5" required>
            	   </div>
            	</div>

                <div class="input-div email">
           		   <div class="i">
					  <i class="fas fa-envelope"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Email</h5>
           		   		<input type="text" class="input" name="email" required>
           		   </div>
           		</div>

                <div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Name</h5>
           		   		<input type="text" class="input" name="Name" required>
           		   </div>
           		</div>

                <div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-phone"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Phone</h5>
           		   		<input type="text" class="input" name="Phone" required>
           		   </div>
           		</div>

                <div class="link">
					<a href="/" class="a">Already have an account?</a>
					<a href="#" class="a">Forgot Password?</a>
				</div>

            	<input type="submit" class="btnin" value="Signup" name="signup">
            
            </form>
        </div>
    </div>


	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/login.js"></script>
    
</body>
</html>