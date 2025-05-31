// Obtener la URL base dinámicamente
const URL_B = `${window.location.origin}${window.location.pathname.replace(/\/[^/]*$/, '/')}`;
// Completar con la URI
const URL_BASE = `${URL_B}index.php?action=`;
// Inicia el módulo al cargar la página
document.addEventListener('DOMContentLoaded', initProspectos);

// Punto de entrada del módulo
function initProspectos() {
    const formulario = document.getElementById("formularioContacto");
    if (formulario) {
        formulario.addEventListener("submit", handleSubmitProspecto);
    }
}

// Manejador del evento submit
async function handleSubmitProspecto(e) {
    e.preventDefault();

    const form = e.target;
    const data = formToJson(form);

    const response = await crearProspecto(data);

    if (response.status === 'success') {
        mostrarMensaje("✅ " + response.message, "success");
        form.reset();
        setTimeout(() => window.location.href = "index.html", 2000);
    } else {
        mostrarMensaje("❌ " + (response.message || "Error inesperado."), "error");
    }
}

// Convierte FormData a JSON
function formToJson(form) {
    const formData = new FormData(form);
    return Object.fromEntries(formData.entries());
}

// Hace la solicitud al backend
async function crearProspecto(data) {
    // Inyectar campos generados por el sistema (lado cliente)
    const dataConSistema = {
        ...data,
        dominioOrigen: "rapicleanpuebla.com",
        giroDominio: "Lavanderia Ropa",
        categoriaProspecto: "Prospecto",
        estadoSistema: "Activo",
        conversacion: "Bitácora de conversación",
        origenProspecto: "Formulario Web"
    };
    try {
        const res = await fetch(URL_BASE + 'crearProspecto', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(dataConSistema)
        });

        return await res.json();
    } catch (error) {
        console.error("Error de red:", error);
        return { status: 'error', message: error.message };
    }
}

// Muestra un mensaje al usuario
function mostrarMensaje(texto, tipo = "info") {
    alert(texto); // reemplaza con toast o snackbar si usas Bootstrap o Tailwind
}