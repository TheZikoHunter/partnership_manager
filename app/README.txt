Follow these steps to make the application work

A - Configuring Xampp and localhost

-Install the latest version of Xampp. This application is devolopped with php 8.2. Some functionalities may not work with an older version.
-This application is made for Windows machines. It is not tested on any Linux distribution. This guide is just for Windows users. The difference is all about the directories paths.
-Go to c:/xampp/apache/conf/httpd.conf or depending on your installation configuration. Edit the lines:
DocumentRoot "C:/xampp/htdocs/app/public"
<Directory "C:/xampp/htdocs/app/public">
-Copy the "app" directory to your "htdocs" directory in xampp.

B - Configuring the database

-On Xampp, start Apache and MySQL
-Go to localhost/phpmyadmin
-Press on import and import the sql file in the "config" directory of the "app".
-Choose Windows 1256 as the charset. IT IS IMPORTANT!

C - Working with the application

-The first user is meant to enter an email, a username and a password.
-This user is by default the admin.
-Only the admin can make changes on the database, including adding other users.
-Other users can only see the information and print it.
-If you need any clarification or if the application is showing unwanted behaviour, please contact me on douihzakaria@gmail.com.
