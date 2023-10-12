function expandNav() {
    var element1 = document.getElementById("main");
    var element2 = document.getElementById("mySidebar");
    var otvori = document.getElementById("expandOn");
    var zatvori = document.getElementById("expandOff");
    

  if (zatvori.style.display === "none") {
    zatvori.style.display = "block";
    otvori.style.display = "none";
    element1.style.marginLeft = "250px"; 
   
  } else {
    zatvori.style.display = "none";
    otvori.style.display = "block";  
    element1.style.marginLeft = "0";  
  }
    element2.classList.toggle("expand2");
  }
