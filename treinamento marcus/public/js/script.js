function openNav(){
    var x = document.getElementById("mySidebar");

    if (x.className === "sidebar-sticky"){
        x.className += " menujs";
        document.getElementById("threeline-icon").innerHTML = "&Cross;";
    } else{
        x.className = "sidebar-sticky";
        document.getElementById("threeline-icon").innerHTML = "&#9776;";
    }

}