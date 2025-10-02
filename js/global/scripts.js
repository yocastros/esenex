document.addEventListener("DOMContentLoaded", () => {
    // Obtener referencias a elementos clave
    const form = document.querySelector("#contact-form");
    const messageDiv = document.querySelector("#form-message");
    const darkModeButton = document.querySelector("#dark-mode-toggle");
    const contactSection = document.querySelector("#contacto");
    const scrollToTopBtn = document.getElementById("scrollToTopBtn");

    // Capturar parámetros de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get("status");

    // Mostrar mensaje en consola
    console.log("Parámetro status:", status);

    // Validación del formulario
    if (form) {
        form.addEventListener("submit", (event) => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                if (messageDiv) {
                    messageDiv.style.display = "block";
                    messageDiv.classList.add("alert", "alert-danger");
                    messageDiv.textContent = "Por favor, completa todos los campos correctamente.";
                }
            } else if (messageDiv) {
                messageDiv.style.display = "none";
            }
            form.classList.add("was-validated");
        });
    } else {
        console.warn("Formulario no encontrado.");
    }

    // Mostrar mensajes de estado en base al parámetro 'status'
    if (status) {
        const alertDiv = document.createElement("div");
        alertDiv.classList.add("alert", "mt-3");

        if (status === "success") {
            alertDiv.classList.add("alert-success");
            alertDiv.textContent = "¡Mensaje enviado exitosamente!";
        } else if (status === "error") {
            alertDiv.classList.add("alert-danger");
            alertDiv.textContent = "Hubo un error al enviar el mensaje. Intenta nuevamente.";
        } else if (status === "invalid") {
            alertDiv.classList.add("alert-warning");
            alertDiv.textContent = "Por favor, completa todos los campos correctamente.";
        }

        if (contactSection && form) {
            contactSection.insertBefore(alertDiv, form);
        } else {
            console.error("No se encontró la sección de contacto o el formulario.");
        }
    }

    // Alternar Modo Oscuro
    if (darkModeButton) {
        darkModeButton.addEventListener("click", () => {
            document.body.classList.toggle("dark-mode");
            // Guardar preferencia en localStorage
            const isDarkMode = document.body.classList.contains("dark-mode");
            localStorage.setItem("darkMode", isDarkMode ? "enabled" : "disabled");
        });

        // Comprobar preferencia al cargar la página
        const darkModePreference = localStorage.getItem("darkMode");
        if (darkModePreference === "enabled") {
            document.body.classList.add("dark-mode");
        }
    } else {
        console.warn("Botón de modo oscuro no encontrado.");
    }

    

    // Mostrar el botón al hacer scroll
    window.addEventListener("scroll", () => {
        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
            scrollToTopBtn.style.display = "block";
        } else {
            scrollToTopBtn.style.display = "none";
        }
    });

    // Volver al inicio de la página al hacer clic
    scrollToTopBtn.addEventListener("click", () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});
