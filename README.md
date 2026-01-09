# StudySpark 🎓
**A Hybrid Learning Management System (LMS) for UiTM Kampus Arau**

StudySpark is a comprehensive learning platform built with a hybrid database architecture. It leverages **MySQL** for structured user data and **MongoDB** for high-frequency activity logging and flexible content management.

---

## 🚀 Key Features by User Role

### 👨‍🎓 Student Portal
* **Learning Ecosystem:** Access lecture notes, reading materials, and view academic calendars.
* **Gamified Progress:** Visualize your rank on the **Leaderboard** based on quiz scores and material engagement.
* **Engagement Tools:** Participate in real-time **Quizzes**, submit **Assignments**, and interact via **Discussion Forums** or **Chat Rooms**.
* **The Backpack:** A centralized space to organize and store materials from all enrolled courses.
* **Campus Directory:** Instant access to UiTM Arau department contacts and university history.

### 👨‍🏫 Instructor Portal
* **Content Management:** Upload notes and design custom **Timed Quizzes** (Multiple Choice / True-False).
* **Learning Analytics:** Monitor student study duration and track course-wide performance via the leaderboard.
* **Communication Hub:** Post announcements and moderate real-time course **Chat Rooms**.
* **Schedule Authority:** Manage exam dates and assignment deadlines on the academic calendar.

### 🔑 Administrator Portal
* **System Governance:** Manage Faculties, Semesters, Classes, and Courses.
* **User Management:** Full CRUD control over Student, Teacher, and Admin accounts.
* **Security & Auditing:** Monitor **Login Logs** and **Activity Reports** for system integrity.
* **Content Authority:** Manage global university information (Mission, Vision, and Directories).

---

## 🛠️ Installation & Database Setup

### 1. Import MySQL Database (XAMPP)

1.  **Start XAMPP:** Open the XAMPP Control Panel and start **Apache** and **MySQL**.
2.  **Access phpMyAdmin:** Go to [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/).
3.  **Create Database:** Click **New** and name it `studyspark`.
4.  **Import SQL:**
    * Select the `studyspark` database.
    * Click the **Import** tab.
    * Choose `database/studyspark.sql` from your project folder and click **Go**.

### 2. Import MongoDB Database

* **Option A: MongoDB Compass (Easiest)**
    1.  Connect to your local instance and create a database named `studyspark`.
    2.  Create a collection (e.g., `study_sessions`).
    3.  Click **Add Data > Import File** and select your `.json` file from the `/database` folder.
* **Option B: CLI (Fastest)**
    ```bash
    mongoimport --db studyspark --collection study_sessions --file ./database/studyspark.study_sessions.json --jsonArray
    ```

---

## 🔑 Access & Credentials

### URL Entry Points
| Role | URL Path |
| :--- | :--- |
| **Student** | `http://localhost/studyspark/src/index.php` |
| **Instructor** | `http://localhost/studyspark/src/index.php` |
| **Admin** | `http://localhost/studyspark/src/admin/index.php` |

### Login Details
To retrieve test credentials, browse the following tables in **phpMyAdmin**:
* **Students:** Refer to the `student` table.
* **Instructors:** Refer to the `teacher` table.
* **Administrators:** Refer to the `users` table.