<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Definir el conjunto de caracteres a UTF-8 -->
    <meta charset="UTF-8">
    
    <!-- Establecer la configuración de la vista para dispositivos móviles -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Título de la página -->
    <title>Selección de Avatar y Mundo</title>
    
    <!-- Enlace a una hoja de estilos externa (no se especifica el archivo) -->
    <link rel="stylesheet" href="styles.css">
    
    <style>
        /* Estilo para el cuerpo de la página */
        body {
            font-family: Arial, sans-serif; /* Fuente para el texto */
            background-color: #1A1A2E; /* Color de fondo */
            color: white; /* Color de texto */
            text-align: center; /* Centrar el texto */
        }
        
        /* Estilo para la sección del perfil */
        .perfil {
            display: flex; /* Usar flexbox para la disposición */
            align-items: center; /* Alinear los elementos al centro verticalmente */
            padding: 10px; /* Relleno de 10 píxeles */
            background-color: #0F3460; /* Fondo oscuro */
        }

        /* Estilo para la imagen del perfil */
        .perfil img {
            width: 50px; /* Ancho de la imagen */
            height: 50px; /* Alto de la imagen */
            border-radius: 50%; /* Hacer la imagen redonda */
            margin-right: 10px; /* Espacio a la derecha de la imagen */
        }

        /* Estilo para las opciones */
        .opciones {
            margin-top: 20px; /* Espacio superior */
        }

        /* Estilo para cada opción (avatar o mundo) */
        .opcion {
            display: inline-block; /* Alineación en línea */
            cursor: pointer; /* Cambiar el cursor al pasar sobre la opción */
            text-align: center; /* Centrar el texto dentro de la opción */
            margin: 20px; /* Espacio entre opciones */
        }

        /* Estilo para las imágenes de las opciones */
        .opcion img {
            width: 100px; /* Ancho de las imágenes */
            height: 100px; /* Alto de las imágenes */
            border-radius: 10px; /* Bordes redondeados */
            border: 2px solid white; /* Borde blanco */
        }

        /* Estilo para el modal (ventana emergente) */
        .modal {
            display: none; /* Inicialmente no se muestra */
            position: fixed; /* Posición fija para que se quede en la misma posición al hacer scroll */
            top: 0; /* Arriba de la página */
            left: 0; /* A la izquierda de la página */
            width: 100%; /* Ancho completo */
            height: 100%; /* Alto completo */
            background: rgba(0, 0, 0, 0.8); /* Fondo oscuro con transparencia */
        }

        /* Estilo para el contenido del modal */
        .modal-contenido {
            background: #16213E; /* Fondo oscuro para el contenido */
            width: 60%; /* Ancho del modal */
            margin: 10% auto; /* Centrar el modal verticalmente */
            padding: 20px; /* Relleno dentro del modal */
            border-radius: 10px; /* Bordes redondeados */
        }

        /* Estilo para el botón de cerrar */
        .cerrar {
            float: right; /* Posicionar el botón a la derecha */
            font-size: 24px; /* Tamaño de fuente grande */
            cursor: pointer; /* Cambiar el cursor a mano */
        }

        /* Estilo para la lista de opciones dentro del modal */
        .opciones-lista {
            display: flex; /* Usar flexbox para la disposición */
            flex-direction: column; /* Alinear los elementos en columna */
            align-items: center; /* Centrar los elementos */
        }

        /* Estilo para cada elemento dentro de la lista */
        .opcion-lista {
            display: flex; /* Usar flexbox */
            align-items: center; /* Alinear elementos al centro */
            background: #0F3460; /* Fondo oscuro */
            padding: 10px; /* Relleno */
            margin: 10px; /* Espaciado entre los elementos */
            width: 80%; /* Ancho de los elementos */
            border-radius: 10px; /* Bordes redondeados */
            cursor: pointer; /* Cambiar cursor al pasar por encima */
        }

        /* Estilo para las imágenes dentro de la lista de opciones */
        .opcion-lista img {
            width: 60px; /* Ancho de la imagen */
            height: 60px; /* Alto de la imagen */
            border-radius: 10px; /* Bordes redondeados */
            margin-right: 15px; /* Espacio a la derecha de la imagen */
        }
    </style>
</head>
<body>
    <!-- Sección del perfil del usuario -->
    <section class="perfil">
        <img src="avatar_actual.jpg" id="perfil-avatar" alt="Avatar"> <!-- Imagen del avatar -->
        <div>
            <h2>GABY123</h2> <!-- Nombre del usuario -->
            <p><span>450 PTS</span></p> <!-- Puntos del usuario -->
            <p>NIVEL 1</p> <!-- Nivel del usuario -->
        </div>
    </section>

    <!-- Sección de las opciones para elegir avatar y mundo -->
    <section class="opciones">
        <div class="contenedor-opciones">
            <div class="fila">
                <!-- Opción de selección de avatar -->
                <div class="opcion" id="seleccionar-avatar">
                    <p>AVATAR</p> <!-- Título de la opción -->
                    <img src="avatar_actual.jpg" id="avatar-seleccionado" alt="Avatar"> <!-- Imagen del avatar seleccionado -->
                    <span>Pepito</span> <!-- Nombre del avatar seleccionado -->
                </div>
                <!-- Opción de selección de mundo -->
                <div class="opcion" id="seleccionar-mundo">
                    <p>MUNDO</p> <!-- Título de la opción -->
                    <img src="mundo_actual.jpg" id="mundo-seleccionado" alt="Mundo"> <!-- Imagen del mundo seleccionado -->
                    <span>KHAOS</span> <!-- Nombre del mundo seleccionado -->
                </div>
            </div>
        </div>
    </section>

    <!-- Modal (ventana emergente) para elegir un avatar o un mundo -->
    <div id="modal" class="modal">
        <div class="modal-contenido">
            <span class="cerrar" id="cerrar-modal">&times;</span> <!-- Botón para cerrar el modal -->
            <h2 id="titulo-modal">AVATARES DISPONIBLES</h2> <!-- Título del modal -->
            <div class="opciones-lista" id="lista-opciones">
                <!-- Aquí se llenarán las opciones dinámicamente -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Elementos del DOM que se utilizan en el script
            const modal = document.getElementById("modal");
            const cerrarModal = document.getElementById("cerrar-modal");
            const listaOpciones = document.getElementById("lista-opciones");
            const avatarSeleccionado = document.getElementById("avatar-seleccionado");
            const mundoSeleccionado = document.getElementById("mundo-seleccionado");
            const seleccionarAvatar = document.getElementById("seleccionar-avatar");
            const seleccionarMundo = document.getElementById("seleccionar-mundo");

            // Variable para saber qué tipo de selección se está haciendo (avatar o mundo)
            let tipoSeleccion = "avatar";

            // Evento para seleccionar el avatar
            seleccionarAvatar.addEventListener("click", function() {
                abrirModal("AVATARES DISPONIBLES", [
                    { nombre: "Pepito", img: "avatar1.jpg" },
                    { nombre: "Pepita", img: "avatar2.jpg" },
                    { nombre: "Bananin", img: "avatar3.jpg" }
                ]);
                tipoSeleccion = "avatar"; // Cambiar tipo de selección
            });

            // Evento para seleccionar el mundo
            seleccionarMundo.addEventListener("click", function() {
                abrirModal("MUNDOS DISPONIBLES", [
                    { nombre: "Kaos", img: "mundo1.jpg" },
                    { nombre: "Nébula", img: "mundo2.jpg" }
                ]);
                tipoSeleccion = "mundo"; // Cambiar tipo de selección
            });

            // Función para abrir el modal con las opciones
            function abrirModal(titulo, opciones) {
                document.getElementById("titulo-modal").innerText = titulo;
                listaOpciones.innerHTML = ""; // Limpiar opciones anteriores
                opciones.forEach(op => {
                    const div = document.createElement("div");
                    div.classList.add("opcion-lista");
                    div.innerHTML = `<img src="${op.img}" alt="${op.nombre}"><span>${op.nombre}</span>`;
                    div.addEventListener("click", function() {
                        // Si es selección de avatar o mundo, cambiar la imagen seleccionada
                        if (tipoSeleccion === "avatar") {
                            avatarSeleccionado.src = op.img;
                        } else {
                            mundoSeleccionado.src = op.img;
                        }
                        modal.style.display = "none"; // Cerrar el modal
                    });
                    listaOpciones.appendChild(div); // Agregar las opciones al modal
                });
                modal.style.display = "block"; // Mostrar el modal
            }

            // Evento para cerrar el modal
            cerrarModal.addEventListener("click", function() {
                modal.style.display = "none"; // Cerrar el modal
            });
        });
    </script>
</body>
</html>
