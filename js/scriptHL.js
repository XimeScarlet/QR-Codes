function buscarHistorial() {
    var singleDate = document.getElementById("single-date").value;

    $.ajax({
        type: "POST",
        url: "buscarHistorial.php",
        data: { single_date: singleDate },
        success: function(response) {
            document.getElementById("historial-section").innerHTML = response;
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Hubo un error al buscar el historial.',
            });
        }
    });
}
