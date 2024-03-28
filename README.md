To access the webpage:

1. Install XAMPP onto your computer
2. Download project files to C:\xampp\htdocs\taskkeeper
3. Open XAMPP control panel and start Apache and MySQL
4. Go to http://localhost/phpmyadmin/
5. Create new database and import taskkeeper.sql into it
6. Go to http://localhost/taskkeeper/login.php

Troubleshooting:
The port XAMPP uses for MySQL may be different based on your computer and if you already have MySQL installed. If you cannot connect to the website, go to config/config.php and change "localhost:3307" based on the following:

- If the port on the XAMPP control panel reads "3306" for MySQL, change to "localhost"
- Otherwise, change to "localhost:xxxx", where xxxx is the port for MySQL
