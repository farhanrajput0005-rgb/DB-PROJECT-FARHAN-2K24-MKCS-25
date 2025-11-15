# DB-PROJECT-FARHAN-2K24-MKCS-25

This project contains a **PHP web form and MySQL database** for storing student information.

## How to Run the Project (XAMPP Instructions)

1. Copy the whole project folder into:
C:\xampp\htdocs\

lua
Copy code
So the path becomes:
C:\xampp\htdocs\DB-PROJECT-FARHAN-2K24-MKCS-25\

markdown
Copy code
2. Start XAMPP services:
- Apache  
- MySQL  

3. Create the database:  
Open your browser and go to:  
`http://localhost/phpmyadmin`  
Click **Databases → create new database** with name:  
form_db

bash
Copy code
Then go to **Import → choose file → form_db.sql → Go**.

4. Update PHP files for XAMPP:  
Open your PHP files (like `students.php`) and set these values:  
```php
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "form_db";
Run the project:
Open in browser:

bash
Copy code
http://localhost/DB-PROJECT-FARHAN-2K24-MKCS-25/index.php
Fill the form → data is saved in MySQL.
Then visit:

bash
Copy code
http://localhost/DB-PROJECT-FARHAN-2K24-MKCS-25/view.php
(to see submitted data)

