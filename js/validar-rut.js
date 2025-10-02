// Función para validar y formatear RUT en tiempo real
document.addEventListener("DOMContentLoaded", function () {
    const rutInput = document.getElementById("rut");

    rutInput.addEventListener("input", function (event) {
        let rut = event.target.value.replace(/[^0-9kK]/g, ""); // Eliminar caracteres no numéricos ni 'K'

        if (rut.length > 1) {
            rut = formatRut(rut);
        }

        event.target.value = rut;
    });

    function formatRut(rut) {
        let cuerpo = rut.slice(0, -1);
        let dv = rut.slice(-1).toUpperCase();
        
        // Agregar puntos y guion
        cuerpo = cuerpo.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        return `${cuerpo}-${dv}`;
    }

    // Validación del RUT al enviar el formulario
    const form = document.querySelector("form");
    form.addEventListener("submit", function (event) {
        let rut = rutInput.value.replace(/\./g, "").replace("-", "").toUpperCase();
        
        if (!validarRut(rut)) {
            event.preventDefault();
            alert("El RUT ingresado no es válido. Por favor, revisa e inténtalo nuevamente.");
        }
    });

    function validarRut(rut) {
        let cuerpo = rut.slice(0, -1);
        let dv = rut.slice(-1);
        
        let suma = 0;
        let multiplo = 2;

        for (let i = cuerpo.length - 1; i >= 0; i--) {
            suma += parseInt(cuerpo.charAt(i)) * multiplo;
            multiplo = multiplo < 7 ? multiplo + 1 : 2;
        }

        let dvEsperado = 11 - (suma % 11);
        dvEsperado = dvEsperado === 11 ? "0" : dvEsperado === 10 ? "K" : dvEsperado.toString();

        return dv === dvEsperado;
    }
});


