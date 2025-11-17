document.getElementById("btnAdauga").addEventListener("click", function () {
    const input = document.getElementById("inputActivitate");
    const lista = document.getElementById("listaActivitati");
    const text = input.value.trim();

    if (text !== "") {
       
        const luni = [
            "Ianuarie", "Februarie", "Martie", "Aprilie", "Mai", "Iunie",
            "Iulie", "August", "Septembrie", "Octombrie", "Noiembrie", "Decembrie"
        ];

        
        const azi = new Date();
        const zi = azi.getDate();
        const luna = luni[azi.getMonth()];
        const an = azi.getFullYear();

        
        const li = document.createElement("li");
        li.textContent = `${text} - adăugată la: ${zi} ${luna} ${an}`;

        
        lista.appendChild(li);

        
        input.value = "";
    }
});
