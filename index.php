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
					alert('You must agree to the terms and conditions and Data policy to register.');
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
            alert('You must agree to the terms and conditions and Data policy to register.');
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
                                                I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a> and <a href="#" data-bs-toggle="modal" data-bs-target="#dataPolicyModal">Data Policy</a>
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
                <div class="terms-conditions">
                <p><strong>Welcome to the Hospital Management System (HMS).</strong> These terms and conditions govern your use of the platform. By accessing or using the HMS, you agree to abide by these terms. If you do not agree, please refrain from using the system.</p>

<h5>1. General Terms</h5>
<h5>1.1 Authorized Use</h5>
<p>All users must use the system solely for purposes related to hospital operations, including appointment management, medical record maintenance, and administrative functions.</p>

<h5>1.2 Data Privacy and Confidentiality</h5>
<p>Users are responsible for safeguarding the privacy of patient data. Unauthorized access, modification, or distribution of sensitive information is strictly prohibited and may result in legal action.</p>

<h5>1.3 System Updates</h5>
<p>The HMS may undergo updates to improve functionality or security. Users agree to adhere to any changes or updated terms that come with such improvements.</p>

<h5>1.4 Prohibited Activities</h5>
<ul>
    <li>Tampering with system functionality.</li>
    <li>Misusing data for personal gain.</li>
    <li>Introducing malicious software or hacking attempts.</li>
</ul>

<h5>1.5 Account Security</h5>
<p>Users must maintain the confidentiality of their account credentials. Sharing credentials is strictly prohibited.</p>

<h5>2. Admin Role</h5>
<h5>2.1 Responsibilities</h5>
<p>Admins are responsible for managing user accounts, overseeing hospital operations within the system, and ensuring compliance with terms and conditions.</p>

<h5>2.2 Data Access</h5>
<p>Admins have access to all system data but must use this access responsibly and ensure that patient confidentiality is maintained.</p>

<h5>2.3 User Management</h5>
<p>Admins can create, update, or deactivate user accounts (doctors and patients). Actions affecting user accounts must be based on legitimate operational needs.</p>

<h5>2.4 Audit Obligations</h5>
<p>Admins are responsible for monitoring activities within the system and ensuring all users comply with these terms.</p>

<h5>3. Doctor Role</h5>
<h5>3.1 Responsibilities</h5>
<p>Doctors are responsible for updating medical records, scheduling appointments, and providing medical care as documented in the system.</p>

<h5>3.2 Patient Data Management</h5>
<p>Doctors must access patient data only for treatment purposes. Sharing or misusing patient information is strictly prohibited.</p>

<h5>3.3 Appointment Scheduling</h5>
<p>Doctors must manage their schedules within the system and adhere to the timings and availability they provide.</p>

<h5>3.4 Ethical Obligations</h5>
<p>Doctors must ensure that all interactions within the HMS align with their professional and ethical standards.</p>

<h5>4. Patient Role</h5>
<h5>4.1 Responsibilities</h5>
<p>Patients are responsible for ensuring their account information is accurate and up to date.</p>

<h5>4.2 Appointment Management</h5>
<p>Patients must use the system to book, reschedule, or cancel appointments in a timely manner. Missed appointments may result in restrictions.</p>

<h5>4.3 Medical Records</h5>
<p>Patients can access their own medical records but must not attempt to alter or tamper with them.</p>

<h5>4.4 Feedback and Complaints</h5>
<p>Patients are encouraged to report any issues or provide feedback regarding system functionality or services.</p>

<h5>5. Data Protection and Security</h5>
<h5>5.1 Confidentiality</h5>
<p>The system is designed to comply with applicable data protection regulations (e.g., GDPR, HIPAA). All data is encrypted and stored securely.</p>

<h5>5.2 User Consent</h5>
<p>By using the HMS, users consent to the collection, storage, and processing of their personal information for operational purposes.</p>

<h5>5.3 Data Breach Response</h5>
<p>In the event of a data breach, the HMS team will notify affected users promptly and take corrective actions.</p>

<h5>6. Liability</h5>
<h5>6.1 System Downtime</h5>
<p>The HMS team strives to provide uninterrupted service but is not liable for downtimes caused by maintenance, technical issues, or unforeseen circumstances.</p>

<h5>6.2 User Actions</h5>
<p>The HMS is not responsible for actions performed by users, such as incorrect data input or misuse of the system.</p>

<h5>6.3 Third-Party Integrations</h5>
<p>The HMS may integrate with third-party systems. The team is not responsible for issues arising from the use of such integrations.</p>

<h5>7. Termination of Access</h5>
<h5>7.1 Breach of Terms</h5>
<p>The HMS reserves the right to terminate access to users who violate these terms.</p>

<h5>7.2 User-Initiated Termination</h5>
<p>Users may request account termination by contacting the Admin team. Upon termination, access to system functionalities will be revoked.</p>

<h5>8. Changes to Terms and Conditions</h5>
<p>The HMS team may update these terms periodically. Users will be notified of significant changes, and continued use of the system constitutes acceptance of the revised terms.</p>

<h5>9. Contact Information</h5>
<p>For any questions or concerns regarding these terms, please contact the hospital's administration team at <a href="mailto:contact@hospital.com">info@globalhospitals.com</a>.</p>

<p>By using the Hospital Management System, you acknowledge that you have read, understood, and agree to these terms and conditions.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Data Policy Modal -->
<div class="modal fade" id="dataPolicyModal" tabindex="-1" aria-labelledby="dataPolicyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataPolicyModalLabel">Data Policy</h5>
            </div>
            <div class="modal-body">
                <div class="data-policy">
                <h4>Data Policy</h4>
    <p>The Hospital Management System (HMS) respects the privacy and security of all users' data. This Data Policy outlines how data is collected, stored, used, shared, and protected within the system. By using the HMS, you agree to this Data Policy.</p>

    <h5>1. Data Collection</h5>
    <h5>1.1 Types of Data Collected</h5>
    <ul>
        <li><strong>Personal Information:</strong> Includes name, contact details, email address, and other personal identifiers.</li>
        <li><strong>Health Records:</strong> Includes medical history, prescriptions, and treatment plans.</li>
        <li><strong>Financial Information:</strong> Includes payment details for services (if applicable).</li>
    </ul>

    <h5>1.2 Purpose of Data Collection</h5>
    <p>Data is collected for the following purposes:</p>
    <ul>
        <li>To provide efficient healthcare services.</li>
        <li>To facilitate appointment scheduling and management.</li>
        <li>To maintain accurate medical records.</li>
        <li>To improve system functionality and user experience.</li>
    </ul>

    <h5>2. Data Usage</h5>
    <h5>2.1 Purpose</h5>
    <ul>
        <li><strong>Admin Role:</strong> For hospital management, user account oversight, and reporting.</li>
        <li><strong>Doctor Role:</strong> For accessing patient records to provide medical care.</li>
        <li><strong>Patient Role:</strong> For accessing medical records, booking appointments, and managing healthcare.</li>
    </ul>

    <h5>2.2 Prohibited Use</h5>
    <p>Data collected in the HMS cannot be used for:</p>
    <ul>
        <li>Personal or non-professional purposes.</li>
        <li>Advertising, marketing, or sharing with third parties without user consent.</li>
    </ul>

    <h5>3. Data Sharing</h5>
    <h5>3.1 Internal Sharing</h5>
    <ul>
        <li><strong>Admins:</strong> Have access to all system data for management purposes.</li>
        <li><strong>Doctors:</strong> Access only patient data relevant to their care responsibilities.</li>
        <li><strong>Patients:</strong> Access their own medical records and appointment details.</li>
    </ul>

    <h5>3.2 External Sharing</h5>
    <p>Data may only be shared with third parties under the following circumstances:</p>
    <ul>
        <li><strong>With Consent:</strong> When users authorize the sharing of their data.</li>
        <li><strong>Legal Obligations:</strong> When required by law or regulatory authorities.</li>
        <li><strong>Emergency Situations:</strong> To protect a user’s health or safety in critical situations.</li>
    </ul>

    <h5>4. Data Storage</h5>
    <h5>4.1 Secure Storage</h5>
    <ul>
        <li>All data is encrypted during transmission and at rest.</li>
        <li>Data is stored on secure servers with restricted access.</li>
    </ul>

    <h5>4.2 Retention Period</h5>
    <ul>
        <li><strong>Patient medical records:</strong> Retained for as long as required by medical record-keeping regulations.</li>
        <li><strong>User accounts:</strong> Data associated with deleted accounts will be anonymized or deleted based on system policies.</li>
    </ul>

    <h5>5. Data Access and Control</h5>
    <h5>5.1 User Rights</h5>
    <ul>
        <li><strong>Access:</strong> Users can request access to their data.</li>
        <li><strong>Correction:</strong> Users can request corrections to inaccurate or incomplete data.</li>
        <li><strong>Deletion:</strong> Users can request the deletion of their data, subject to legal and operational constraints.</li>
    </ul>

    <h5>5.2 Role-Based Access</h5>
    <p>Admins, doctors, and patients have access only to data relevant to their roles. Unauthorized access to sensitive information is strictly prohibited.</p>

    <h5>6. Data Protection</h5>
    <h5>6.1 Security Measures</h5>
    <p>Firewalls, encryption, and secure authentication mechanisms protect all data. Regular audits are conducted to identify and address vulnerabilities.</p>

    <h5>6.2 Data Breach Response</h5>
    <p>Users will be notified promptly in the event of a data breach. Corrective actions will be taken to mitigate risks and prevent recurrence.</p>

    <h5>7. Cookies and Tracking</h5>
    <h5>7.1 System Cookies</h5>
    <p>HMS may use cookies to enhance user experience by storing login sessions and preferences. Cookies do not store sensitive information and are used solely for functionality purposes.</p>

    <h5>7.2 Opt-Out</h5>
    <p>Users may disable cookies through their browser settings, but this may impact the system’s functionality.</p>

    <h5>8. Third-Party Services</h5>
    <h5>8.1 Integration</h5>
    <p>The HMS may integrate with third-party tools (e.g., payment gateways or SMS notification services). Only essential data will be shared with these services under strict confidentiality agreements.</p>

    <h5>8.2 Disclaimer</h5>
    <p>The HMS is not responsible for data misuse by third-party providers beyond our control.</p>

    <h5>9. Compliance</h5>
    <h5>9.1 Regulations</h5>
    <p>The HMS complies with relevant data protection laws, including:</p>
    <ul>
        <li>General Data Protection Regulation (GDPR)</li>
        <li>Health Insurance Portability and Accountability Act (HIPAA)</li>
        <li>Personal Data Protection Act (PDPA)</li>
    </ul>

    <h5>9.2 User Responsibility</h5>
    <p>Users are responsible for ensuring their actions within the system comply with this Data Policy.</p>

    <h5>10. Policy Updates</h5>
    <p>The HMS reserves the right to modify this Data Policy at any time. Users will be notified of significant changes, and continued use of the system constitutes acceptance of the updated policy.</p>

    <h5>11. Contact Information</h5>
    <p>For questions or concerns regarding this Data Policy, please contact the HMS support team at <a href="mailto:support@hospital.com">info@globalhospitals.com</a>.</p>

    <p>By using the Hospital Management System, you acknowledge that you have read, understood, and agree to this Data Policy.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
    .terms-conditions, .data-policy {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        color: #333;
    }
    .terms-conditions h5, .data-policy h5 {
        color: #2c3e50;
        margin-top: 20px;
    }
    .terms-conditions p, .data-policy p {
        margin-bottom: 10px;
    }
</style>

           
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
