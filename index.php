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
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

	<!-- jQuery and Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

	<style>
		.form-control {
			border-radius: 0.75rem;
		}
	</style>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script> <!-- reCAPTCHA API -->
	<script>
		function openResetPasswordModal() {
			$('#resetPasswordModal').modal('show');
		}

		function checkPasswordRequirements() {
			const password = document.getElementById("password").value;
			const requirements = {
				length: password.length >= 6,
				uppercase: /[A-Z]/.test(password),
				lowercase: /[a-z]/.test(password),
				number: /\d/.test(password),
				special: /[\W_]/.test(password), 
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
			if (!requirements.special) {
				passwordError.innerHTML += "Password must contain at least one special character.<br>";
			}

			return (
				requirements.length &&
				requirements.uppercase &&
				requirements.lowercase &&
				requirements.number &&
				requirements.special
			);
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

			emailError.innerHTML = "";

			const emailPattern = /^[^\s@]+@[^\s@]+\.[a-z]{2,3}$/;
			if (!emailPattern.test(email)) {
				emailError.style.color = 'red';
				emailError.innerHTML = "Please enter a valid email address.";
				return;
			}

			var xhr = new XMLHttpRequest();
			xhr.open("POST", "check_email.php", true); 
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

			xhr.onreadystatechange = function() {
				if (xhr.readyState === 4 && xhr.status === 200) {
					var response = xhr.responseText.trim(); 
					if (response === "exists") {
						emailError.style.color = 'red';
						emailError.innerHTML = "This email is already registered.";
						submitButton.disabled = true; // disable submit button
					} else if (response === "available") {
						emailError.style.color = 'green';
						emailError.innerHTML = "Email is available.";
						submitButton.disabled = false; // enable submit button
					} else {
						emailError.style.color = 'orange';
						emailError.innerHTML = "Unexpected response from the server.";
					}
				}
			};

			// send the email to the server for checking
			xhr.send("email=" + encodeURIComponent(email));
		}

		function validateForm() {
			const password = document.getElementById("password").value;
			const confirmPassword = document.getElementById("cpassword").value;
			const email = document.getElementById("email").value;
			const emailError = document.getElementById("emailError");
			const firstName = document.getElementById("fname");
			const lastName = document.getElementById("lname");


			// reset previous error messages
			emailError.textContent = '';

			// email format validation
			const emailPattern = /^[^\s@]+@[^\s@]+\.[a-z]{2,3}$/;
			if (!emailPattern.test(email)) {
				emailError.textContent = "Please enter a valid email address.";
				return false;

			}

			const passwordValid = checkPasswordRequirements();
			if (!passwordValid) {
				return false; 
			}

			// ensure passwords match
			if (password !== confirmPassword) {
				alert("Passwords do not match.");
				return false;
			}
			// check if terms checkbox is checked
			const termsCheckbox = document.getElementById('termsCheckbox');
				if (!termsCheckbox.checked) {
					alert('You must agree to the terms and conditions to register.');
					return false;
				}
			const captchaResponse = grecaptcha.getResponse();
			if (captchaResponse.length === 0) {
				document.getElementById('captchaError').textContent = "Please complete the CAPTCHA.";
				return false;
			}

			return true;
		}
		function confirmAgreement() {
        const termsCheckbox = document.getElementById('termsCheckbox');
        if (!termsCheckbox.checked) {
            alert('You must agree to the terms and conditions to register.');
            return false;
        }
        document.getElementById('registrationForm').submit(); 
		exit;	
	}



	document.addEventListener("DOMContentLoaded", function () {
            
            var termsLink = document.getElementById("termsLink");
            var termsModal = new bootstrap.Modal(document.getElementById("termsModal"));
            
            termsLink.addEventListener("click", function (event) {
                event.preventDefault(); 
                termsModal.show(); // show the modal
            });

            
        });

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
										<div class="form-group">
											<div class="g-recaptcha" data-sitekey="6LeMs3kqAAAAAOadGAZwyxRbWyzpn0-E8AtapfGJ"></div>
											<span id="captchaError" style="color: red; display: block; margin-top: 10px;"></span> <!-- reCAPTCHA error message -->
										</div>
										<div class="form-group" style="display: flex; align-items: center;">
											<input type="checkbox" id="termsCheckbox" required style="margin-right: 5px;">
											<label for="termsCheckbox" style="margin: 0;">
												I agree to the <a href="#" id="termsLink">Terms and Conditions</a>
											</label>
										</div>
										<a href="index1.php" style="top: 40px; position: relative;">Already have an account?</a>
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
									<input type="submit" class="btnRegister" name="patsub1" value="Register" style="margin-top: 230px; margin-left: 100px;"/>
									
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
									<a href="resetpassworddoc.html" >Forgot Password?</a>
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

<div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetPasswordModalLabel">Reset Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="resetPasswordForm" method="post" action="reset-password.php">
                    <div class="form-group">
                        <label for="email">Enter your registered email:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="example@example.com" required />
                    </div>
                    <button type="submit" class="btn btn-primary">Send OTP</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Terms and Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                
            </div>
            <div class="modal-body">
                <h6>Terms and Conditions</h6>
                <p>Put your detailed terms and conditions content here.</p>
           
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    </html>

  
				</div>
			</div>
		</div>
	</div>

	
</body>
</html>
