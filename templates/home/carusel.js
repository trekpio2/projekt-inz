
Animals = document.getElementsByClassName("animalPhotoHome");
carusel = document.getElementById("carousel");
console.log(Animals);
i = 1;
prev = Animals[i-1];
current = Animals[i];
next = Animals[i+1];

prev.style.left = "-100px";
next.style.left = "100px";

prev.style.opacity ="0.5";
next.style.opacity ="0.5";
// carusel.innerHTML = Animals[0].outerHTML;
// carusel.innerHTML += Animals[1].outerHTML;
// carusel.innerHTML += Animals[2].outerHTML;

function goLeft(){
    temp = Animals[1].innerHTML;
    Animals[1].innerHTML = Animals[2].innerHTML;
    Animals[2].innerHTML = temp;
}
