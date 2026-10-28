# StudentHub – Student Portal

## 1. Project Overview

StudentHub is a multi-page web-based student portal developed as part of the Web Development Frameworks practicals. The project provides a user-friendly interface for student-related activities, including courses, events, announcements, assignments, timetables, profiles, notifications, and helpdesk services.

The project demonstrates the use of HTML, CSS, JavaScript, and JSON to create interactive web pages and display dynamic data.

## 2. Objectives

- Develop a multi-page student portal with clear navigation.
- Create structured web pages using HTML5.
- Apply CSS for styling and responsive layouts.
- Implement interactive features using JavaScript.
- Validate user input through forms.
- Load and display data from external JSON files.
- Implement search, filtering, sorting, and pagination where available.
- Improve usability through interactive components and consistent page design.

## 3. Technologies Used

- **HTML5:** Structure and content of web pages.
- **CSS3:** Styling, layout, and visual design.
- **JavaScript:** Form validation and interactive functionality.
- **JSON:** Sample student, event, and FAQ data.
- **Git and GitHub:** Version control and source-code hosting.

## 4. Project Structure

```text
StudentHub/
│
├── images/
│
├── index.html
├── aboutus.html
├── announcements.html
├── Assignment.html
├── dashboard.html
├── events.html
├── faq.html
├── hamburger.html
├── helpdesk.html
├── login.html
├── modal.html
├── mycourses.html
├── notification.html
├── profile.html
├── queryselcetor.html
├── register.html
├── slider.html
├── timetable.html
│
├── dark.html
├── dark.js
├── hamburger.js
├── modal.js
├── notification.js
├── slider.js
├── practical6.js
├── practical6.css
├── style.css
├── style4.css
├── faq.js
│
├── events.json
├── students.json
├── faqs.json
│
└── README.md
```

## 5. Main Features

- Multi-page student portal with navigation.
- Home page and student dashboard.
- Registration and login pages.
- Student profile and course pages.
- Events and announcements pages.
- Assignment and timetable pages.
- FAQ and helpdesk pages.
- Notification interface.
- Interactive modal and slider components.
- Hamburger navigation menu.
- Dark mode interface.
- Dynamic data using JSON files.
- JavaScript-based interactivity and form validation.
- Search, filtering, sorting, and pagination where implemented.

## 6. Description of Data Files

- **events.json:** Stores sample event information used by the events section.
- **students.json:** Stores sample student information for dynamic display.
- **faqs.json:** Stores frequently asked questions and their answers.

These files allow JavaScript to retrieve and display structured data on the relevant pages.

## 7. Setup and Installation

1. Download or clone the StudentHub project from its GitHub repository.
2. Extract the project files if downloaded as a ZIP archive.
3. Open the project folder in Visual Studio Code.
4. Ensure that the HTML, CSS, JavaScript, JSON, and image files are present in the correct locations.
5. Install the **Live Server** extension in Visual Studio Code if it is not already installed.
6. Open `index.html` and select **Open with Live Server**.
7. Open the local URL in a web browser.
8. Navigate through the pages and test the available features.

**Note:** Use a local web server to run the project because JavaScript `fetch()` requests for JSON files may not work correctly when HTML files are opened directly using the `file://` protocol.

## 8. Testing Instructions

The following tests can be performed to verify the project:

1. Open the home page and verify the navigation links.
2. Open the main pages and check that their content displays correctly.
3. Test the registration and login interfaces.
4. Enter valid and invalid data in the forms and verify the validation messages.
5. Open the events page and check whether the event data loads from `events.json`.
6. Verify student and FAQ data loading from their respective JSON files wherever used.
7. Test the hamburger menu, modal, slider, notification, and dark mode features.
8. Check the dashboard, courses, profile, timetable, assignments, and announcements pages.
9. Verify that the website layout remains usable at different browser window sizes.
10. Check for broken links, missing images, and JavaScript errors.

## 9. Security and Accessibility

Security and accessibility should be evaluated according to the features implemented in the project.

- Validate user input through appropriate form validation.
- Use clear labels and instructions for form fields.
- Use meaningful headings and semantic HTML elements.
- Provide alternative text for meaningful images.
- Ensure that interactive controls can be accessed using a keyboard.
- Maintain readable text and background contrast.
- Handle missing or unavailable JSON data appropriately.
- Avoid storing real passwords or sensitive personal information in sample JSON files.

If authentication is only a frontend demonstration, it should not be considered secure server-side authentication.

Refer to `Test_Security_Report.docx` for the project's testing, security, and accessibility report.

## 10. GitHub Repository

**GitHub Repository URL:** Add your actual GitHub repository link here.

## 11. Conclusion

StudentHub demonstrates the practical application of HTML, CSS, JavaScript, and JSON in developing a multi-page student portal. It includes student-related pages and interactive components that improve navigation and usability. The project provides practical experience in website structure, styling, client-side validation, JavaScript interactivity, and dynamic data loading.

The project was tested to verify that its implemented functionalities work as expected.
