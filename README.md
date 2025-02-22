# HardSurface

<!-- welcome -->
Welcome to the only README file for the HardSurface website.
Though the project is still in development, the website still meets the basic CRUD requirements.

<!-- Resources -->
Resources used:
- Bootstrap (Locally installed)
- Bootstrap Admin template
- Fontawesome icons (locally installed)

<!-- For the database -->
<!-- Most codes can be found in the /doc folder -->
<!-- You will need to create a database called "onibodebest" first -->
SQL code that you will need:

<!-- Admin -->
Admin table:
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    name VARCHAR(255) NOT NULL, 
    password VARCHAR(255) NOT NULL,  
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  
);
INSERT INTO admins (name, password) 
VALUES ('Admin', 'IAmAdmin');

<!-- When trying to access the dashboard, you will need to input "Admin" and "IAmAdmin" in the login page -->

<!-- Login/Signup -->
Login/Signup table:
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,  
    name VARCHAR(255) NOT NULL,   
    email VARCHAR(255) NOT NULL, 
    password VARCHAR(255) NOT NULL, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  
    status TINYINT DEFAULT 1, 
    last_active DATETIME DEFAULT NULL  
);

<!-- Im sure you noticed that the login table is called users. I did this just to keep it simple since both signup and login use thesame table. -->

<!-- File Uploads -->
Uploads table:
CREATE TABLE uploads (
    id INT AUTO_INCREMENT PRIMARY KEY,  
    image_path VARCHAR(255) NOT NULL,  
    title VARCHAR(255) NOT NULL, 
    description TEXT, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);

<!-- Comments from the Contact page -->
Comments/Messages table:
CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    user_id INT, 
    name VARCHAR(255) NOT NULL, 
    email VARCHAR(255) NOT NULL, 
    subject VARCHAR(255) NOT NULL, 
    message TEXT NOT NULL, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

If there are any issues found during the creation of the database or want to contact me, here is my contact information.
Email: glitchtrapsonic@gmail.com
Whatsapp Number: +234 809 111 2033

<!-- Thanks you for you time -->
