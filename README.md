🚀 Key Features by User Role

👨‍🎓 Student Features
    Learning Ecosystem: Access course materials, view academic calendars, and track study duration.
    Gamified Progress: A Leaderboard visualizes performance (quiz scores + material views) using interactive bar charts.
    Engagement Tools: Participate in Quizzes, submit Assignments, and interact via Discussion Forums or Private Chat.
    Personalized Organization: Use the "Backpack" feature to store and organize materials across all enrolled courses in one place.
    Campus Information: Quick access to UiTM Arau directories, campus history, and developer profiles.

👨‍🏫 Instructor Features
    Content Management: Create and organize learning materials, assignments, and timed quizzes (Multiple Choice/True-False).
    Student Monitoring: Track student study time and monitor course-wide progress via the leaderboard.
    Communication: Post course announcements and manage real-time Chat Rooms (including moderation capabilities).
    Calendar Management: Add, edit, or remove exam dates and deadlines on the academic calendar.

🔑 Administrator Features
    System Governance: Manage the core hierarchy (Faculties, Semesters, Classes, and Courses).
    User Management: Full CRUD (Create, Read, Update, Delete) control over Student, Teacher, and Admin accounts.
    Audit Logs: Monitor security with Admin Login Logs and Activity Reports.
    Content Authority: Manage global system content, including the University's mission, vision, and directories.

🚀 Import databases

1. Import MySQL Database (XAMPP)

    Start XAMPP: Open the XAMPP Control Panel and click Start for both Apache and MySQL.
    Access phpMyAdmin: Open your browser and go to http://localhost/phpmyadmin/.
    Create Database: * Click New on the left sidebar.
    Database name: studyspark
    Click Create.
    Import SQL File:
    Click on the studyspark database you just created.
    Click the Import tab at the top.
    Click Choose File and select database/studyspark.sql from your project folder.
    Scroll down and click Go (or Import).

2. Import MongoDB Database

    Option A: Using MongoDB Compass (Easiest)
        Connect: Open MongoDB Compass and connect to your local instance.
        Create Database: Click the + (plus icon) to create a database named studyspark.
        Create Collection: Add a collection (e.g., study_sessions).
        Import JSON:
        Click into the collection.
        Click Add Data > Import File.
        Select your .json file from your project's /database folder.
        Ensure the format is set to JSON and click Import.

    Option B: Using Command Line (Fastest) If you have MongoDB Database Tools installed, run this in your terminal: 
        Bash
        mongoimport --db studyspark --collection activity_logs --file ./database/studyspark.study_sessions.json --jsonArray

🚀 URL Entry Points

Student 
    http://localhost/studyspark/src/index.php

Instructor
    http://localhost/studyspark/src/index.php

Administrator
    http://localhost/studyspark/src/admin/index.php

🔐 Login Credentials

To find the login details for testing, please refer to the student, teacher and users tables within the studyspark.sql file:

    Open phpMyAdmin.
    Navigate to the studyspark database.
    Browse the student table to find Student and teacher table for Instructor username/password.
    Browse the users table for Administrative access.