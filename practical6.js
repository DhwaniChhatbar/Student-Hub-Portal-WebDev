let events = [];
let students = [];
let faqs = [];

let eventPage = 1;
let studentPage = 1;
let faqPage = 1;
const perPage = 6;

function fetchData(file, loadingId, errorId){
    const loading = document.getElementById(loadingId);
    const error = document.getElementById(errorId);

    return fetch(file)
        .then(function(response){
            if(!response.ok) throw new Error("Failed to load data");
            return response.json();
        })
        .catch(function(err){
            error.textContent = "Error loading data";
            throw err;
        })
        .finally(function(){
            loading.style.display = "none";
        });
}

function showPages(total, page, containerId, pageId, renderFunction){
    const container = document.getElementById(pageId);
    container.innerHTML = "";

    const pages = Math.ceil(total / perPage);

    if(pages <= 1) return;

    const prev = document.createElement("button");
    prev.textContent = "Previous";
    prev.disabled = page === 1;
    prev.onclick = function(){
        renderFunction(page - 1);
    };
    container.appendChild(prev);

    for(let i = 1; i <= pages; i++){
        const button = document.createElement("button");
        button.textContent = i;

        if(i === page) button.classList.add("active");

        button.onclick = function(){
            renderFunction(i);
        };

        container.appendChild(button);
    }

    const next = document.createElement("button");
    next.textContent = "Next";
    next.disabled = page === pages;
    next.onclick = function(){
        renderFunction(page + 1);
    };
    container.appendChild(next);
}

/* EVENTS */

function displayEvents(page = 1){
    eventPage = page;

    let data = [...events];
    const search = document.getElementById("eventSearch").value.toLowerCase();
    const filter = document.getElementById("eventFilter").value;
    const sort = document.getElementById("eventSort").value;

    data = data.filter(function(event){
        return event.name.toLowerCase().includes(search);
    });

    if(filter !== "all"){
        data = data.filter(function(event){
            return event.category === filter;
        });
    }

    if(sort === "az"){
        data.sort(function(a,b){
            return a.name.localeCompare(b.name);
        });
    }else if(sort === "za"){
        data.sort(function(a,b){
            return b.name.localeCompare(a.name);
        });
    }else if(sort === "dateAsc"){
        data.sort(function(a,b){
            return new Date(a.date) - new Date(b.date);
        });
    }else if(sort === "dateDesc"){
        data.sort(function(a,b){
            return new Date(b.date) - new Date(a.date);
        });
    }

    const start = (page - 1) * perPage;
    const pageData = data.slice(start,start + perPage);
    const container = document.getElementById("eventContainer");

    container.innerHTML = "";

    pageData.forEach(function(event){
        container.innerHTML += `
        <div class="card">
            <h3>${event.name}</h3>
            <p><b>Category:</b> ${event.category}</p>
            <p><b>Date:</b> ${event.date}</p>
            <p><b>Venue:</b> ${event.venue}</p>
            <p><b>Organizer:</b> ${event.organizer}</p>
        </div>`;
    });

    showPages(data.length,page,"eventContainer","eventPagination",displayEvents);
}

/* STUDENTS */

function displayStudents(page = 1){
    studentPage = page;

    let data = [...students];
    const search = document.getElementById("studentSearch").value.toLowerCase();
    const filter = document.getElementById("studentFilter").value;
    const sort = document.getElementById("studentSort").value;

    data = data.filter(function(student){
        return student.name.toLowerCase().includes(search);
    });

    if(filter !== "all"){
        data = data.filter(function(student){
            return student.course === filter;
        });
    }

    if(sort === "az"){
        data.sort(function(a,b){
            return a.name.localeCompare(b.name);
        });
    }else if(sort === "za"){
        data.sort(function(a,b){
            return b.name.localeCompare(a.name);
        });
    }

    const start = (page - 1) * perPage;
    const pageData = data.slice(start,start + perPage);
    const container = document.getElementById("studentContainer");

    container.innerHTML = "";

    pageData.forEach(function(student){
        container.innerHTML += `
        <div class="card">
            <h3>${student.name}</h3>
            <p><b>Course:</b> ${student.course}</p>
            <p><b>Semester:</b> ${student.semester}</p>
            <p><b>Email:</b> ${student.email}</p>
            <p><b>City:</b> ${student.city}</p>
        </div>`;
    });

    showPages(data.length,page,"studentContainer","studentPagination",displayStudents);
}

/* FAQS */

function displayFAQs(page = 1){
    faqPage = page;

    let data = [...faqs];
    const search = document.getElementById("faqSearch").value.toLowerCase();
    const sort = document.getElementById("faqSort").value;

    data = data.filter(function(faq){
        return faq.question.toLowerCase().includes(search);
    });

    if(sort === "az"){
        data.sort(function(a,b){
            return a.question.localeCompare(b.question);
        });
    }else if(sort === "za"){
        data.sort(function(a,b){
            return b.question.localeCompare(a.question);
        });
    }

    const start = (page - 1) * perPage;
    const pageData = data.slice(start,start + perPage);
    const container = document.getElementById("faqContainer");

    container.innerHTML = "";

    pageData.forEach(function(faq){
        container.innerHTML += `
        <div class="faq-item">
            <button class="faq-question">${faq.question}</button>
            <div class="faq-answer">${faq.answer}</div>
        </div>`;
    });

    document.querySelectorAll(".faq-question").forEach(function(question){
        question.onclick = function(){
            this.nextElementSibling.classList.toggle("show");
        };
    });

    showPages(data.length,page,"faqContainer","faqPagination",displayFAQs);
}

/* LOAD JSON FILES */

Promise.all([
    fetchData("events.json","eventLoading","eventError"),
    fetchData("students.json","studentLoading","studentError"),
    fetchData("faqs.json","faqLoading","faqError")
])
.then(function(data){
    events = data[0];
    students = data[1];
    faqs = data[2];

    displayEvents();
    displayStudents();
    displayFAQs();
});

/* CONTROLS */

document.getElementById("eventSearch").addEventListener("input",function(){
    displayEvents(1);
});

document.getElementById("eventFilter").addEventListener("change",function(){
    displayEvents(1);
});

document.getElementById("eventSort").addEventListener("change",function(){
    displayEvents(1);
});

document.getElementById("studentSearch").addEventListener("input",function(){
    displayStudents(1);
});

document.getElementById("studentFilter").addEventListener("change",function(){
    displayStudents(1);
});

document.getElementById("studentSort").addEventListener("change",function(){
    displayStudents(1);
});

document.getElementById("faqSearch").addEventListener("input",function(){
    displayFAQs(1);
});

document.getElementById("faqSort").addEventListener("change",function(){
    displayFAQs(1);
});