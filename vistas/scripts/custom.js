// ../app/template/js/theme-switcher.js

$(document).ready(function () {
    console.log("Theme Switcher cargado correctamente.");

    // Manejar el cambio de tema al hacer clic en una opción
    $('#themecolors a').on('click', function () {
        var theme = $(this).data('theme'); // Obtener el valor de data-theme
        console.log("Tema seleccionado:", theme);
        
        // **Actualizar la ruta al archivo CSS del tema**
        var themePath = '/rh/app/template/css/colors/' + theme + '.css'; // Ruta correcta al archivo CSS
        console.log("Ruta del tema:", themePath);

        var $this = $(this); // Guardar referencia a 'this'

        // Verificar si el archivo CSS existe antes de aplicarlo
        $.ajax({
            url: themePath,
            type: 'HEAD',
            success: function() {
                // Cambiar el atributo href del enlace de tema
                $('#theme').attr('href', themePath);
                console.log("Cambio de href del tema realizado.");

                // Eliminar la clase 'working' de todos los enlaces de tema
                $('#themecolors a').removeClass('working');

                // Agregar la clase 'working' al enlace de tema seleccionado
                $this.addClass('working');

                // Guardar el tema seleccionado en localStorage
                localStorage.setItem('selectedTheme', theme);
                console.log("Tema guardado en localStorage:", theme);
            },
            error: function() {
                console.error("El archivo de tema no existe:", themePath);
                alert("El tema seleccionado no está disponible.");
            }
        });
    });

    // Cargar el tema guardado al iniciar la página
    var savedTheme = localStorage.getItem('selectedTheme');
    console.log("Tema guardado en localStorage:", savedTheme);
    if (savedTheme) {
        var themePath = '/rh/app/template/css/colors/' + savedTheme + '.css'; // Ruta correcta al archivo CSS
        console.log("Aplicando tema guardado:", themePath);
        $('#theme').attr('href', themePath);

        // Actualizar la clase 'working' en los enlaces de tema
        $('#themecolors a').removeClass('working');
        $('#themecolors a[data-theme="' + savedTheme + '"]').addClass('working');
    }

    // Manejar el toggle del Right Sidebar
    $('.right-side-toggle').on('click', function () {
        console.log("Botón de toggle del Right Sidebar clickeado.");
        $('.right-sidebar').toggleClass('shw-rside');
    });
});
