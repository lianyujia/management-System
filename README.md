# Hospital Management System
This project uses a Hospital Management System Github Project from this author "https://github.com/kishan0725/Hospital-Management-System?tab=readme-ov-file". It uses MySQL, Php and Bootstrap for the project development. It contains 3 user roles (administrator, patient and doctor).

## Prerequisites
1. Install XAMPP web server
2. Any Editor (Preferably VS Code or Sublime Text)
3. Any web browser with latest version

## Languages and Technologies used
1. HTML5/CSS3
2. JavaScript (to create dynamically updating content)
3. Bootstrap (An HTML, CSS, and JS library)
4. XAMPP (A web server by Apache Friends)
5. Php
6. MySQL (An RDBMS that uses SQL)
7. TCPDF (to generate PDFs)

## Steps to run the project in your machine
1. Download and install XAMPP in your machine
2. Clone or download the repository
3. Extract all the files and move it to the 'htdocs' folder of your XAMPP directory.
4. Start the Apache and Mysql in your XAMPP control panel.
5. Open your web browser and type 'localhost/phpmyadmin'
6. In phpmyadmin page, create a new database from the left panel and name it as 'myhmsdb'
7. Import the file 'myhmsdb.sql' inside your newly created database and click ok.
8. Go to "https://getcomposer.org/download/" and install the Composer-Setup.exe.
9. Install it at xampp/composer. Create a new folder called "composer" for that.
10. In your command prompt or terminal, direct to "cd C:\xampp\php" and enter this:
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
12. In your command prompt or terminal, direct to "cd C:\xampp\htdocs\management-System" and enter
composer require vlucas/phpdotenv.
13. Verify your installation by entering "composer --version".
14. Open a new tab and type 'localhost/foldername' in the url of your browser.

### Starting Apache And MySQL in XAMPP:
  The XAMPP Control Panel allows you to manually start and stop Apache and MySQL. To start Apache or MySQL manually, click the ‘Start’ button under ‘Actions’.
  
## Group Members' Contribution
1. Peh Jia Xuan (Captcha, CSRF, Bill Password, Admin Management (Delete Doctor), Credit Card Payment)
2. Chin Hui Zhen (HTTPS with SSL Certificate, Session Expiration, Encryption, Logging and Analysis, Admin Management (Edit Sensitive Information and Create New Doctor))
3. Lian Yu Jia (Input Validation, Reset Password with OTP, User Consent/ Terms and Conditions/ Data Policy, Password Hashing, Patient and Doctor Profile)

