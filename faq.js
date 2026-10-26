const questions = document.querySelectorAll(".faq-question");

questions.forEach(function(question){

    question.addEventListener("click", function(){

        const answer = this.nextElementSibling;

        answer.classList.toggle("show");

    });

});