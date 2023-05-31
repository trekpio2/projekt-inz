
Animals = document.getElementsByClassName("Baza");
carusel = document.getElementById("carousel");
console.log(Animals);

// carusel.innerHTML = Animals[0].outerHTML;
// carusel.innerHTML += Animals[1].outerHTML;
// carusel.innerHTML += Animals[2].outerHTML;
i = 0;
prev = Animals[i];
current = Animals[i+1];
next = Animals[i+2];
next.addEventListener("click", goLeft);
carusel.innerHTML = prev.innerHTML;
carusel.innerHTML += current.innerHTML;
carusel.innerHTML += next.innerHTML;



Flowers = document.getElementsByClassName("BazaFlower");
caruselF = document.getElementById("carouselPlant");
console.log(Flowers);

// caruselF.innerHTML = Flowers[0].outerHTML;
// caruselF.innerHTML += Flowers[1].outerHTML;
// caruselF.innerHTML += Flowers[2].outerHTML;
j = 0;
prevF = Flowers[i];
currentF = Flowers[i+1];
nextF = Flowers[i+2];
caruselF.innerHTML = prevF.innerHTML;
caruselF.innerHTML += currentF.innerHTML;
caruselF.innerHTML += nextF.innerHTML;

function goLeft(){
    if(i == Animals.length -3){
  
    } else {
        i = i+1;
        prev = Animals[i];
        current = Animals[i+1];
        next = Animals[i+2];
        
        carusel.innerHTML = prev.innerHTML;
        carusel.innerHTML += current.innerHTML;
        carusel.innerHTML += next.innerHTML;
    
    }
}
function goRight(){
    if( i==0){

    }
    else {
        i = i-1;
        prev = Animals[i];
        current = Animals[i+1];
        next = Animals[i+2];
        
        carusel.innerHTML = prev.innerHTML;
        carusel.innerHTML += current.innerHTML;
        carusel.innerHTML += next.innerHTML;
    }
    
}

let touchstartX = 0
let touchendX = 0
    
function checkDirection() {
  if (touchendX < touchstartX) goLeft()
  if (touchendX > touchstartX) goRight()
}

document.addEventListener('touchstart', e => {
  touchstartX = e.changedTouches[0].screenX
})

document.addEventListener('touchend', e => {
  touchendX = e.changedTouches[0].screenX
  checkDirection()
})