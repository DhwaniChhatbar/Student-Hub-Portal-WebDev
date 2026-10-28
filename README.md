# StudentHub – Student Portal and PHP Practicals

## 1. Project Overview

StudentHub is a multi-page student portal developed as part of the Web Development Frameworks practicals. The project demonstrates frontend web development using HTML, CSS, JavaScript, and JSON, followed by server-side development using PHP and MySQL.

The project is organised into two parts:

- **Practicals 1–6:** An integrated frontend StudentHub website.
- **Practicals 7–14:** Separate PHP practicals covering form processing, database connectivity, authentication, CRUD operations, APIs, and administration.

Practicals 7–14 are independent practicals and are not merged into the Practicals 1–6 frontend project.

## 2. Objectives

- Develop a multi-page student portal.
- Create structured and responsive web pages.
- Implement interactive features using JavaScript.
- Validate form input on the client and server sides.
- Process and store data using CSV and JSON files.
- Connect PHP applications to MySQL.
- Implement secure registration and login functionality.
- Manage student and event records using CRUD operations.
- Develop a JSON API and use Fetch/AJAX.
- Implement role-based access control and an admin dashboard.
- Maintain audit logs for relevant administrative activities.

## 3. Technologies Used

- **HTML5:** Structure and content of web pages.
- **CSS3:** Styling, layout, and responsive design.
- **JavaScript:** Client-side validation and interactive features.
- **JSON:** Structured data storage and API responses.
- **PHP:** Server-side processing and application logic.
- **MySQL:** Relational database management.
- **PDO and MySQLi:** PHP database connectivity, as used in the respective practicals.
- **Fetch/AJAX:** Asynchronous communication with the PHP API.
- **XAMPP:** Local Apache and MySQL development environment.
- **Git and GitHub:** Version control and source-code hosting.

## 4. Project Structure

### 4.1 Practicals 1–6: Integrated Frontend

```text
StudentHub/
├── images/
├── index.html
├── aboutus.html
├── announcements.html
├── Assignment.html
├── dark.html
├── dark.js
├── dashboard.html
├── events.html
├── events.json
├── faq.html
├── faq.js
├── faqs.json
├── hamburger.html
├── hamburger.js
├── helpdesk.html
├── login.html
├── modal.html
├── modal.js
├── mycourses.html
├── notification.html
├── notification.js
├── practical6.css
├── practical6.js
├── profile.html
├── queryselcetor.html
├── register.html
├── slider.html
├── slider.js
├── students.json
├── style.css
├── style4.css
├── timetable.html
└── README.md
```

### 4.2 Practicals 7–14: Independent PHP Practicals

The PHP practicals are maintained separately from the frontend project. Each practical contains the PHP files, SQL or data files, and other resources required for that practical.

The following is a logical overview, not a claim about the exact filenames or folder names in the repository.

```text
PHP_Practicals/
├── Practical7/
│   └── PHP forms and CSV/JSON file handling
├── Practical8/
│   └── MySQL connectivity and database operations
├── Practical9/
│   └── User registration and password hashing
├── Practical10/
│   └── Login, sessions, and role-based access
├── Practical11/
│   └── Student CRUD operations
├── Practical12/
│   └── Event CRUD and poster upload
├── Practical13/
│   └── PHP JSON API and Fetch/AJAX
└── Practical14/
    └── Admin dashboard and audit logs
```

Use the actual directory and filename structure present in the repository.

## 5. Practicals 1–6: Frontend Features

### Practical 1 – Project Initiation and Setup

- Define the project scope and requirements.
- Identify the main pages and user roles.
- Establish the project structure and navigation.
- Maintain the project repository and README documentation.

### Practical 2 – HTML Page Development

- Develop multiple pages using HTML.
- Organise page content with appropriate HTML elements.
- Create navigation links between relevant pages.
- Develop student-related sections such as courses, events, profile, and timetable.

### Practical 3 – CSS Styling and Layout

- Apply CSS styling to web pages.
- Use layout techniques to organise content.
- Improve readability, consistency, and usability.
- Style forms, navigation, and page sections.

### Practical 4 – JavaScript Interactivity

- Implement interactive page components.
- Add a hamburger menu, modal, slider, and dark mode where implemented.
- Handle user interactions using JavaScript.

### Practical 5 – Form Validation

- Validate form inputs.
- Check required fields and invalid values.
- Display appropriate validation feedback.

### Practical 6 – Dynamic Data and Fetch

- Load structured data from `events.json`, `students.json`, and `faqs.json` where used.
- Display JSON data dynamically.
- Implement search, filtering, sorting, pagination, and loading or error handling where implemented.

## 6. Practicals 7–14: PHP and Database Development

### Practical 7 – PHP Form Processing and File Handling

- Process submitted form data using PHP.
- Validate data on the server side.
- Read and write structured data using CSV and JSON files.
- Display suitable success or error messages.

This practical uses file-based data handling and does not require the shared MySQL database used by Practicals 8–14.

### Practical 8 – MySQL Connectivity

- Connect PHP to MySQL using PDO.
- Use the `studenthub1` database.
- Execute database operations using prepared statements where applicable.
- Insert and retrieve student records.

### Practical 9 – User Registration

- Accept and validate registration details.
- Check for duplicate email addresses.
- Hash passwords using PHP password-hashing functions.
- Store user information in the database.

### Practical 10 – Login, Sessions, and Access Control

- Authenticate users using their registered credentials.
- Maintain login sessions.
- Implement logout functionality.
- Restrict protected pages according to authentication and user roles.
- Apply session timeout handling where implemented.

### Practical 11 – Student CRUD Operations

- Create, read, update, and deactivate student records.
- Search and filter student records.
- Display records using pagination.
- Export student data to CSV where implemented.

### Practical 12 – Event Management and Poster Upload

- Manage event records through CRUD operations.
- Upload event posters where implemented.
- Validate uploaded file size and permitted file types.
- Display event information from the database.

### Practical 13 – PHP JSON API and Fetch/AJAX

- Create PHP endpoints that return JSON responses.
- Retrieve data asynchronously using Fetch/AJAX.
- Process API requests for the implemented operations.
- Display returned data without requiring a full-page reload where implemented.

### Practical 14 – Admin Dashboard and Audit Logs

- Restrict the administration dashboard to authorised administrators.
- Display counts of users, students, events, and registrations.
- Display recent registrations.
- Provide a role-based navigation menu.
- Record and display relevant audit-log information.

## 7. Database Details

Practicals 8–14 use the shared MySQL database named **`studenthub1`**.

The database contains tables required by the implemented practicals, including:

- `users` – User credentials and roles.
- `students` – Student details and status.
- `events` – Event details.
- `registrations` – Student event registrations.
- `audit_logs` – Recorded application activities.

The exact table columns and relationships are defined in the SQL database structure used by the project.

Practical 7 uses CSV/JSON file handling and does not depend on `studenthub1`.

### Database Setup

1. Start Apache and MySQL from the XAMPP Control Panel.
2. Open `http://localhost/phpmyadmin`.
3. Create or select the database named `studenthub1`.
4. Import the SQL file supplied for Practicals 8–14, if included.
5. Verify that the required tables exist.
6. Check the database connection settings in the PHP configuration file.
7. Run the relevant practical through the local server.

For a local XAMPP setup, the connection configuration must match the installed MySQL username, password, host, and database name. Do not replace existing tables or data unnecessarily if the shared database is already configured.

## 8. Setup and Installation

### Frontend Project: Practicals 1–6

1. Download or clone the repository.
2. Open the project folder in Visual Studio Code.
3. Install the Live Server extension if required.
4. Open `index.html` using Live Server.
5. Test navigation and the available interactive features.
6. Verify that the JSON data files load correctly.

A local web server is recommended because browser Fetch requests may not work correctly when HTML files are opened directly through the `file://` protocol.

### PHP Practicals: Practicals 7–14

1. Install and open XAMPP.
2. Start Apache and MySQL for the practicals that require them.
3. Place the PHP practical folders inside the XAMPP `htdocs` directory.
4. For Practical 7, open the relevant PHP page through `http://localhost/` and verify CSV/JSON file handling.
5. For Practicals 8–14, configure the database connection to use `studenthub1`.
6. Import the supplied SQL database structure and data when necessary.
7. Open the required practical using its local URL.
8. Test the functionality and verify the expected output.

Example URL format:

`http://localhost/your-practical-folder/`

Replace `your-practical-folder` with the actual folder name. Run each practical independently using its own entry page.

## 9. Testing Instructions

### Frontend Testing

- Verify that navigation links open the correct pages.
- Check page layouts and content.
- Test registration and login interfaces.
- Enter valid and invalid form data.
- Verify JSON data loading.
- Test the hamburger menu, modal, slider, and dark mode.
- Check search, filtering, sorting, and pagination where implemented.
- Verify the behaviour of interactive controls and error states.

### PHP Practical Testing

- **Practical 7:** Test server-side validation and CSV/JSON read and write operations.
- **Practical 8:** Verify the database connection and insert/retrieve operations.
- **Practical 9:** Test valid registration, invalid input, and duplicate email handling.
- **Practical 10:** Test login, logout, session protection, and role restrictions.
- **Practical 11:** Test adding, viewing, editing, deactivating, searching, and exporting student records where implemented.
- **Practical 12:** Test event CRUD operations and invalid poster uploads.
- **Practical 13:** Test API responses, JSON output, and asynchronous requests.
- **Practical 14:** Test administrator access, dashboard statistics, role-based menus, and audit logs.

The developer has confirmed that the implemented functionalities are working. Testing should be repeated after any code or database changes.

## 10. Security and Accessibility

Security measures should match the actual implementation of each practical.

- Validate user input on both the client and server sides.
- Hash passwords rather than storing them as plain text.
- Use prepared statements for database queries.
- Protect authenticated pages and enforce role checks on the server.
- Escape user-controlled output before displaying it in HTML.
- Validate uploaded files for size and allowed types.
- End sessions properly during logout.
- Avoid exposing database credentials or real personal information in public repositories.
- Use semantic HTML and meaningful headings.
- Provide labels for form controls and alternative text for meaningful images.
- Check keyboard navigation and text contrast.
- Handle unavailable data and invalid requests appropriately.

Refer to `Test_Security_Report.docx` for the project's testing, security, and accessibility report. Security checks should be marked as passed only where the relevant protection has been verified.

## 11. Submission Checklist

The final submission should contain the items required by the practical instructions:

- [ ] GitHub repository link.
- [ ] Integrated frontend source code for Practicals 1–6.
- [ ] Separate source code for PHP Practicals 7–14.
- [ ] `studenthub.sql` database dump containing the database used by the integrated project, if required.
- [ ] SQL export for `studenthub1` if required for the PHP practicals.
- [ ] `README.md` containing setup and testing instructions.
- [ ] `Test_Security_Report.docx`.
- [ ] Screenshots or a demo showing the implemented pages and functionality.

Ensure that the SQL dump corresponds to the database required by the relevant part of the submission. The frontend and PHP practicals should remain separate as described above.

## 12. GitHub Repository

**Repository URL:** Add the actual GitHub repository link here.

## 13. Conclusion

StudentHub demonstrates the development of a multi-page student portal and the application of server-side web development concepts. Practicals 1–6 focus on HTML, CSS, JavaScript, and dynamic JSON data. Practicals 7–14 extend the learning to PHP form processing, database connectivity, authentication, CRUD operations, file uploads, JSON APIs, and administration.

Together, the practicals provide experience in frontend development, backend processing, database management, testing, security, and documentation.
