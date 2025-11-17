window.addEventListener("load", function () {

    const detalii = document.getElementById("detalii");
    const btn = document.getElementById("btnDetalii");
    const dataSpan = document.getElementById("dataProdus");

    
    detalii.classList.add("ascuns");

    
    const luni = [
        "Ianuarie", "Februarie", "Martie", "Aprilie", "Mai", "Iunie",
        "Iulie", "August", "Septembrie", "Octombrie", "Noiembrie", "Decembrie"
    ];

    
    const azi = new Date();
    const zi = azi.getDate();
    const luna = luni[azi.getMonth()];
    const an = azi.getFullYear();

    
    dataSpan.textContent = `${zi} ${luna} ${an}`;

   
    btn.addEventListener("click", function () {
        detalii.classList.toggle("ascuns");

        
        if (detalii.classList.contains("ascuns")) {
            btn.textContent = "Afișează detalii";
        } else {
            btn.textContent = "Ascunde detalii";
        }
    });

});
