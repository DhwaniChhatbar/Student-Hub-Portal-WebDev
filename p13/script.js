
const API_URL = "api.php";

const form = document.getElementById("studentForm");
const studentList = document.getElementById("studentList");
const message = document.getElementById("message");
const formTitle = document.getElementById("formTitle");
const submitBtn = document.getElementById("submitBtn");
const cancelBtn = document.getElementById("cancelBtn");

let editingId = null;
let loading = false;

function showMessage(text, type) {
    message.textContent = text;
    message.className = type;
    message.hidden = false;
}

function setLoading(value, text = "Please wait...") {
    loading = value;
    submitBtn.disabled = value;
    cancelBtn.disabled = value;

    if (value) {
        showMessage(text, "info");
    }
}

async function requestAPI(method, data = null) {
    const options = {
        method: method,
        headers: {
            "Accept": "application/json"
        }
    };

    if (data !== null) {
        options.headers["Content-Type"] = "application/json";
        options.body = JSON.stringify(data);
    }

    const response = await fetch(API_URL, options);

    let result;

    try {
        result = await response.json();
    } catch {
        throw new Error("The server returned an invalid JSON response.");
    }

    if (!response.ok || result.success !== true) {
        throw new Error(
            result.message || `Request failed with status ${response.status}.`
        );
    }

    return result;
}

function addCell(row, value) {
    const cell = document.createElement("td");
    cell.textContent = value ?? "";
    row.appendChild(cell);
    return cell;
}

function createButton(text, className, action) {
    const button = document.createElement("button");
    button.type = "button";
    button.textContent = text;
    button.className = className;
    button.addEventListener("click", action);
    return button;
}

function renderStudents(students) {
    studentList.replaceChildren();

    if (students.length === 0) {
        const row = document.createElement("tr");
        const cell = addCell(row, "No students found.");
        cell.colSpan = 5;
        studentList.appendChild(row);
        return;
    }

    students.forEach(student => {
        const row = document.createElement("tr");

        addCell(row, student.id);
        addCell(row, student.name);
        addCell(row, student.email);
        addCell(row, student.course);

        const actions = addCell(row, "");

        actions.appendChild(
            createButton("Edit", "", () => editStudent(student))
        );

        actions.appendChild(
            createButton("Delete", "delete-btn", () =>
                deleteStudent(student.id)
            )
        );

        studentList.appendChild(row);
    });
}

async function loadStudents(showLoading = true) {
    if (showLoading) {
        studentList.replaceChildren();

        const row = document.createElement("tr");
        const cell = addCell(row, "Loading students...");
        cell.colSpan = 5;
        studentList.appendChild(row);

        showMessage("Loading students...", "info");
    }

    try {
        const result = await requestAPI("GET");
        renderStudents(result.data);

        if (showLoading) {
            showMessage("Students loaded successfully.", "success");
        }
    } catch (error) {
        studentList.replaceChildren();

        const row = document.createElement("tr");
        const cell = addCell(row, "Unable to load students.");
        cell.colSpan = 5;
        studentList.appendChild(row);

        showMessage(error.message, "error");
    }
}

function resetForm() {
    form.reset();
    editingId = null;
    formTitle.textContent = "Add Student";
    submitBtn.textContent = "Add Student";
    cancelBtn.hidden = true;
}

function editStudent(student) {
    if (loading) return;

    editingId = student.id;

    document.getElementById("name").value = student.name;
    document.getElementById("email").value = student.email;
    document.getElementById("course").value = student.course;

    formTitle.textContent = "Edit Student";
    submitBtn.textContent = "Update Student";
    cancelBtn.hidden = false;

    showMessage("Editing student ID " + student.id, "info");
    document.getElementById("name").focus();
}

form.addEventListener("submit", async event => {
    event.preventDefault();

    if (loading) return;

    const data = {
        name: document.getElementById("name").value.trim(),
        email: document.getElementById("email").value.trim(),
        course: document.getElementById("course").value.trim()
    };

    if (!data.name || !data.email || !data.course) {
        showMessage("All fields are required.", "error");
        return;
    }

    if (!form.reportValidity()) {
        return;
    }

    const method = editingId === null ? "POST" : "PUT";

    if (editingId !== null) {
        data.id = editingId;
    }

    setLoading(true, "Saving student...");

    try {
        const result = await requestAPI(method, data);

        resetForm();
        await loadStudents(false);
        showMessage(result.message, "success");
    } catch (error) {
        showMessage(error.message, "error");
    } finally {
        setLoading(false);
    }
});

cancelBtn.addEventListener("click", () => {
    if (loading) return;

    resetForm();
    showMessage("Edit cancelled.", "info");
});

async function deleteStudent(id) {
    if (loading) return;

    if (!confirm("Are you sure you want to delete this student?")) {
        return;
    }

    setLoading(true, "Deleting student...");

    try {
        const result = await requestAPI("DELETE", { id: id });

        if (editingId === id) {
            resetForm();
        }

        await loadStudents(false);
        showMessage(result.message, "success");
    } catch (error) {
        showMessage(error.message, "error");
    } finally {
        setLoading(false);
    }
}

loadStudents();
