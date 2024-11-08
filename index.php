<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>HMS</title>
	<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />
	<link rel="stylesheet" href="style1.css">
	<link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
	<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
	<style>
		.form-control {
			border-radius: 0.75rem;
		}
	</style>
	<script>
		function checkPasswordRequirements() {
			const password = document.getElementById("password").value;
			const requirements = {
				length: password.length >= 6,
				uppercase: /[A-Z]/.test(password),
				lowercase: /[a-z]/.test(password),
				number: /\d/.test(password),
			};

			const passwordError = document.getElementById("passwordError");
			passwordError.innerHTML = "";

			if (!requirements.length) {
				passwordError.innerHTML += "Password must be at least 6 characters long.<br>";
				
			}
			if (!requirements.uppercase) {
				passwordError.innerHTML += "Password must contain at least one uppercase letter.<br>";
				
			}
			if (!requirements.lowercase) {
				passwordError.innerHTML += "Password must contain at least one lowercase letter.<br>";
				
			}
			if (!requirements.number) {
				passwordError.innerHTML += "Password must contain at least one digit.<br>";
				
			}

			return requirements.length && requirements.uppercase && requirements.lowercase && requirements.number;
		}

		function checkPasswordMatch() {
			const password = document.getElementById('password').value;
			const confirmPassword = document.getElementById('cpassword').value;
			const message = document.getElementById('message');
			if (password === confirmPassword) {
				message.style.color = '#5dd05d';
				message.innerHTML = 'Matched';
			} else {
				message.style.color = '#f55252';
				message.innerHTML = 'Not Matching';
			}
		}

		function checkDuplicateEmail() {
			const email = document.getElementById('email').value;
			const emailError = document.getElementById('emailError');
			const submitButton = document.querySelector('.btnRegister');

			// Clear previous error message
			emailError.innerHTML = "";

			// Basic email format validation
			const emailPattern = /^[^\s@]+@[^\s@]+\.[a-z]{2,3}$/;
			if (!emailPattern.test(email)) {
				emailError.style.color = 'red';
				emailError.innerHTML = "Please enter a valid email address.";
				return;
			}

			// AJAX request to check if the email already exists in the database
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "check_email.php", true); // Send to the check_email.php file
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

			xhr.onreadystatechange = function() {
				if (xhr.readyState === 4 && xhr.status === 200) {
					var response = xhr.responseText.trim(); // Get the response from PHP, use trim() to remove any extra spaces

					if (response === "exists") {
						emailError.style.color = 'red';
						emailError.innerHTML = "This email is already registered.";
						submitButton.disabled = true;
						
					} else if (response === "available") {
						emailError.style.color = 'green';
						emailError.innerHTML = "Email is available.";

						submitButton.disabled = false;
               			
					} else {
						emailError.style.color = 'orange';
						emailError.innerHTML = "Unexpected response.";
					}
				}
			};

			// Send the email to the server for checking
			xhr.send("email=" + encodeURIComponent(email));
		}

		function validateForm() {
			const password = document.getElementById("password").value;
			const confirmPassword = document.getElementById("cpassword").value;
			const email = document.getElementById("email").value;
			const emailError = document.getElementById("emailError");

			

			// Reset previous error messages
			emailError.textContent = '';

			// Email format validation
			const emailPattern = /^[^\s@]+@[^\s@]+\.[a-z]{2,3}$/;
			if (!emailPattern.test(email)) {
				emailError.textContent = "Please enter a valid email address.";
				return false;

			}

			const passwordValid = checkPasswordRequirements();
			if (!passwordValid) {
				return false; // Prevent form submission if password does not meet requirements
			}

			// Ensure passwords match
			if (password !== confirmPassword) {
				alert("Passwords do not match.");
				return false;
			}

			return true;
		}
	</script>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
		<div class="container">
			<a class="navbar-brand" href="#" style="margin-top: 10px; font-family: 'IBM Plex Sans', sans-serif;">
				<h4><i class="fa fa-user-plus"></i>&nbsp;GLOBAL HOSPITALS</h4>
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarResponsive">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link" href="index.php" style="color: white;"><h6>HOME</h6></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="services.html" style="color: white;"><h6>ABOUT US</h6></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="contact.html" style="color: white;"><h6>CONTACT</h6></a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container register" style="font-family: 'IBM Plex Sans', sans-serif; margin-top: 100px;">
		<div class="row">
			<div class="col-md-3 register-left">
				<img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
				<h3>Welcome</h3>
			</div>
			<div class="col-md-9 register-right">
				<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-selected="true">Patient</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-selected="false">Doctor</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="admin-tab" data-toggle="tab" href="#admin" role="tab" aria-selected="false">Receptionist</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="home" role="tabpanel">
						<h3 class="register-heading">Register as Patient</h3>
						<form method="post" action="func2.php" onsubmit="return validateForm();">
							<div class="row register-form">
								<div class="col-md-6">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="First Name *" name="fname" onkeydown="return alphaOnly(event);" required/>
									</div>
									<div class="form-group">
										<input type="email" class="form-control" id="email" placeholder="Your Email *" name="email" onkeyup="checkDuplicateEmail();" required />
										<span id="emailError" style="color: red;"></span>
									</div>
									<div class="form-group">
										<input type="password" class="form-control" placeholder="Password *" id="password" name="password" onkeyup="checkPasswordRequirements(); checkPasswordMatch();" minlength="6" required/>
										<span id="passwordError" style="color: red;"></span>
									</div>
									<div class="form-group">
										<div class="maxl">
											<label class="radio inline">
												<input type="radio" name="gender" value="Male" checked>
												<span>Male</span> 
											</label>
											<label class="radio inline">
												<input type="radio" name="gender" value="Female">
												<span>Female</span>
											</label>
										</div>
										<a href="index1.php">Already have an account?</a>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Last Name *" name="lname" onkeydown="return alphaOnly(event);" required/>
									</div>
									<div class="form-group">
										<input type="tel" minlength="10" maxlength="10" name="contact" class="form-control" pattern="\d{10}" placeholder="Your Phone *" required />
									</div>
									<div class="form-group">
										<input type="password" class="form-control" id="cpassword" placeholder="Confirm Password *" name="cpassword" onkeyup="checkPasswordMatch();" required />
										<span id="message"></span>
									</div>
									<input type="submit" class="btnRegister" name="patsub1" value="Register"/>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <h3  class="register-heading">Login as Doctor</h3>
                                <form method="post" action="func1.php">
                                <div class="row register-form">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="User Name *" name="username3" onkeydown="return alphaOnly(event);" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="password" class="form-control" placeholder="Password *" name="password3" required/>
                                        </div>
                                        
                                        <input type="submit" class="btnRegister" name="docsub1" value="Login"/>
                                    </div>
                                </div>
                            </form>
                            </div>


                            <div class="tab-pane fade show" id="admin" role="tabpanel" aria-labelledby="profile-tab">
                                <h3  class="register-heading">Login as Admin</h3>
                                <form method="post" action="func3.php">
                                <div class="row register-form">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="User Name *" name="username1" onkeydown="return alphaOnly(event);" required/>
                                        </div>
                                        


                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="password" class="form-control" placeholder="Password *" name="password2" required/>
                                        </div>
                                        <input type="submit"  class="btnRegister" name="adsub" value="Login"/>
                                        
										
                                    </div>
									
                                </div>
								
                            </form>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
    </body>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    </html>

  
				</div>
			</div>
		</div>
	</div>
</body>
</html>
