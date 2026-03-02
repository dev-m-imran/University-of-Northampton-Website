🎓 University of Northampton Website

A dynamic university website built with role-based administration, course management, enquiries handling, and advanced search functionality.
The project is containerized using Docker for easy setup and deployment.

🔐 Admin Access

Admin Login URL

https://v.je/admin/login.php
Super Admin Credentials

Username: admin

Password: admin

🚀 How to Run the Project
Requirements

Docker installed and running on your PC

Steps

Open a terminal in the project root folder

Run:

docker compose up

Visit the application in your browser.

📌 System Features (Tickets Implemented)
🧑‍💼 NMP-0001: User Accounts

Super Admin can create new admin accounts

New admins can add subject areas and courses

Super Admin can delete accounts

Super Admin account cannot be deleted

Non-superadmins cannot manage accounts

Role-based access control implemented

Password hashing stored securely in database

📚 NMP-0002: Subject Areas

Admins can add, rename, and delete subject areas

Non-logged-in users are restricted from admin pages

Subject areas displayed dynamically in navigation menu

Subject area page heading updates based on selection

🎓 NMP-0003: Courses Management

Admins can add courses with required details and modules

Courses can be edited and updated

Courses can be moved between subject areas

Courses displayed dynamically on public subject pages

📩 NMP-0004: Enquiries System

Public users can submit enquiries

Logged-in admins can view enquiries

Admins can mark enquiries as responded

Responder information logged

Separate views for:

Pending enquiries

Responded enquiries

🔎 NMP-0005: Course Search

Users can search courses by:

Course type

Subject area

Duration

Combination of one, two, or three criteria

⏳ NMP-0006: Part-Time Courses

Admin option to mark courses as part-time

Part-time status displayed:

On subject area page

On search results page

Search filter available for part-time courses

📄 NMP-0007: Pagination

Pagination implemented for:

Subject area course listings

Search results

🛠️ Technical Overview

PHP-based web application

MySQL database

Role-based authentication system

Secure password hashing

Dockerized environment for consistent deployment

🔒 Security Features

Role-based access control

Super Admin protection

Hashed passwords stored in database

Admin routes protected from unauthenticated access

📌 Notes

Default superadmin credentials are for development/testing purposes only.

Change credentials before deploying to production.
