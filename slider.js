const images = [

    "images/img1.jpeg",

    "images/img2.jpeg",

    "images/img3.jpeg"

];

let current = 0;

const sliderImage = document.getElementById("sliderImage");

const nextBtn = document.getElementById("nextBtn");

const prevBtn = document.getElementById("prevBtn");

nextBtn.addEventListener("click", function(){

    current++;

    if(current >= images.length){

        current = 0;

    }

    sliderImage.src = images[current];

});

prevBtn.addEventListener("click", function(){

    current--;

    if(current < 0){

        current = images.length - 1;

    }

    sliderImage.src = images[current];

});