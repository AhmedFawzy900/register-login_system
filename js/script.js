const dayNight = document.querySelector('.day-night');

dayNight.addEventListener("click",()=>{
    document.body.classList.toggle("dark");
    if (document.body.classList.contains("dark")) {
        localStorage.setItem("theme","dark");
    }else{
        localStorage.setItem("theme","light");
    }
})

function themeMode(){
    if (localStorage.getItem("theme") === 'light') {
        document.body.classList.remove("dark");
    }else{
        document.body.classList.add("dark");
    }
    updateIcon();
}

themeMode();



function updateIcon() {
    if(document.body.classList.contains("dark")){
        dayNight.querySelector("i").classList.add("fa-sun");
        dayNight.querySelector("i").classList.remove("fa-moon");
    }else{    
        dayNight.querySelector("i").classList.add("fa-moon");
        dayNight.querySelector("i").classList.remove("fa-sun");
    }
    
}
updateIcon();
