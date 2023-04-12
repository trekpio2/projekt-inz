
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

