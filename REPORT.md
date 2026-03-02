# University of Northampton Website Report

## Admin login URL
- `https://v.je/admin/login.php`

## Super Admin Login
-  username: admin
-  password: admin


## How to run the project
- You need docker open in your PC
- open project in a terminal and run the comand: docker compose up


## Ticket NMP-0001: User accounts
- A superadmin can log in and add new accounts: `websites/default/public/admin/login.php` (lines 6-17), `websites/default/public/admin/users.php` (lines 3-6, 19-26, 52-63)
- New account can log in and add subject areas/courses: `websites/default/public/admin/login.php` (lines 6-17), `websites/default/public/admin/subjects.php` (lines 2-23, 45-63), `websites/default/public/admin/courses.php` (lines 2-35, 66-94)
- A superadmin can delete accounts: `websites/default/public/admin/users.php` (lines 10-17, 69-74)
- The superadmin account cannot be deleted: `websites/default/public/admin/users.php` (lines 11-17, 69-75)
- Non-superadmins cannot add/remove accounts: `websites/default/public/admin/users.php` (lines 2-6)
- Roles + password hashing in DB: `websites/database.sql` (lines 182-186)

## Ticket NMP-0002: Add/display subject areas
- Admin can add/rename/delete subject areas: `websites/default/public/admin/subjects.php` (lines 2-23, 45-63)
- Non-logged-in users blocked: `websites/default/public/admin/subjects.php` (lines 2-6)
- Subject areas appear in menu: `websites/default/public/navigation.php` (lines 5-12)
- Subject area page heading matches selection: `websites/default/public/pages/subject-area.php` (lines 11-26)

## Ticket NMP-0003: Add/display courses
- Courses added with required data + modules: `websites/default/public/admin/courses.php` (lines 14-32, 71-93), `websites/default/public/admin/modules.php` (lines 9-19, 45-67)
- Courses can be added or updated: `websites/default/public/admin/courses.php` (lines 16-23)
- Courses can move subject area: `websites/default/public/admin/courses.php` (lines 17-18, 71-75)
- Courses visible on public subject area page: `websites/default/public/pages/subject-area.php` (lines 27-43)

## Ticket NMP-0004: Enquiries
- Anyone can submit an enquiry: `websites/default/public/pages/enquiry.php` (lines 3-31)
- Enquiries visible to logged-in admins: `websites/default/public/admin/enquiries.php` (lines 2-6, 19-50)
- Mark responded and log responder: `websites/default/public/admin/enquiries.php` (lines 9-12, 43-45)
- Pending enquiries view: `websites/default/public/admin/enquiries.php` (lines 16-19, 33-34)
- Responded enquiries view: `websites/default/public/admin/enquiries.php` (lines 16-19, 33-45)

## Ticket NMP-0005: Course search
- Search by type: `websites/default/public/pages/search.php` (lines 16-18, 58-59)
- Search by subject area: `websites/default/public/pages/search.php` (lines 12-15, 48-55)
- Search by duration: `websites/default/public/pages/search.php` (lines 20-26, 60-63)
- Search by one/two/three criteria: `websites/default/public/pages/search.php` (lines 10-33)

## Ticket NMP-0006: Part time courses
- Part time option on add/edit: `websites/default/public/admin/courses.php` (lines 15-16, 85-86)
- Part time shown on subject area list: `websites/default/public/pages/subject-area.php` (line 32)
- Part time shown on search results: `websites/default/public/pages/search.php` (line 74)
- Search filter for part time: `websites/default/public/pages/search.php` (lines 28-29, 64-65)

## Ticket NMP-0007: Pagination
- Subject area pagination: `websites/default/public/pages/subject-area.php` (lines 4-22, 47-49)
- Search results pagination: `websites/default/public/pages/search.php` (lines 3-42, 89-97)

