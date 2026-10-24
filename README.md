# Student Records Management System
# Submitted by: Kate Margarette B. Maglalang - BSIT 3-1
A beginner-oriented CRUD project using PHP, MySQL, HTML, and CSS with Apache
through XAMPP. The layout uses PUP-inspired maroon, gold, and white.
This is a student project, not an official PUP system.

## Setup

1. Click Code → Download ZIP on this GitHub repository.
2. Extract the ZIP and rename the extracted project folder to student-records-management-system.
3. Move the folder into C:\xampp\htdocs.
4. Start Apache and MySQL in the XAMPP Control Panel.
5. Open http://localhost/phpmyadmin and import database.sql.
6. Update the database settings in db.php if needed.
7. Open http://localhost/student-records-management-system/ in your browser.

Use PHP 7.4 or later with mysqli and mbstring enabled (standard XAMPP
installations include these). The SQL works with MySQL and XAMPP's MariaDB.

If replacing the previous version, replace the application folder with this
version. Keep your existing database; do not delete it. The same students table
is used, so existing records remain compatible. Copy any customized database
credentials from your old config.php into the new db.php.

## Files and what to study

| File | Purpose |
| --- | --- |
| db.php | Opens the database connection |
| index.php | Displays records using SELECT and a while loop |
| add.php | Reads form values and saves a record using INSERT |
| edit.php | Loads one student and changes it using UPDATE |
| delete.php | Asks for confirmation, then uses DELETE |
| form.php | The HTML form shared by Add and Edit |
| header.php | Page heading and navigation |
| footer.php | Footer and closing HTML tags |
| security.php | Small session/token check for submitted forms |
| database.sql | Creates the database and students table |
| style.css | Page colors, table, buttons, and form styling |

## How the backend works

1. `require 'db.php'` opens the connection.
2. Add and Edit read the form values from `$_POST` after submission.
3. Simple if/elseif checks reject missing fields, invalid email addresses,
   invalid year levels, and values longer than the database columns allow.
4. `mysqli_prepare` creates the SQL statement. Its question marks are
   placeholders for form values.
5. `mysqli_stmt_bind_param` supplies the values: `s` means string and `i`
   means integer. Keeping values separate from SQL prevents SQL injection.
6. `mysqli_stmt_execute` runs the statement.
7. `header('Location: index.php')` returns the user to the student list.

`htmlspecialchars` displays typed text safely in HTML. The small security.php
file creates a session token, which is included as a hidden input in each form.
It rejects submissions without a matching token. These basic protections stay
in place even though the rest of the project is deliberately simple.

There are no classes, framework, custom PHP helper functions, JavaScript,
search features, dashboard cards, animations, or build tools.

## Try the four CRUD operations

1. Add student 2026-001, Alex Reyes, alex@example.com, BSIT, Year 1.
2. Confirm the record appears on the Student List.
3. Edit the course to BSCS and year to 2. Confirm the changes appear.
4. Click Delete, then Cancel. Confirm the record is still there.
5. Click Delete again and confirm. Confirm the record is removed.
6. Try adding a duplicate student number. It should show an error.
7. Try a missing field or invalid email. It should be rejected.
8. Enter a name with an apostrophe or HTML characters. It should display as text.

## Testing and limitations

The source file references and ZIP contents were checked during creation.
PHP and MySQL are unavailable in the build workspace, so PHP syntax checks
and end-to-end CRUD testing must be completed in XAMPP.

For PHP syntax checks, open Command Prompt in the project folder and run:

```bat
for %f in (*.php) do C:\xampp\php\php.exe -l "%f"
```

This is a local classroom project with no login or user roles. Anyone with
access can manage records. Keep it local. The list is intended for small datasets.

If the database connection fails, check that MySQL is running, database.sql
has been imported, and the settings in db.php match your local setup.
If Apache uses a custom port, include it in the URL, such as
http://localhost:8080/student-records-management-system/.
