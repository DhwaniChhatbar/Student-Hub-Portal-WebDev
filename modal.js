const modal = document.getElementById("modal");
const openModal = document.getElementById("openModal");
const closeIcon = document.querySelector(".close");
const closeModal = document.getElementById("closeModal");

openModal.onclick = function() {
    modal.classList.add("show");
};

closeIcon.onclick = function() {
    modal.classList.remove("show");
};

closeModal.onclick = function() {
    modal.classList.remove("show");
};

window.onclick = function(event) {
    if (event.target === modal) {
        modal.classList.remove("show");
    }
};