document.getElementById('formularioRegistrarse').addEventListener('submit', function (event) {
    event.preventDefault();

    var formData = new FormData(this);

    fetch('http://localhost/GomezBalaguerV%c3%adctorProyecto1T/Proyecto1Eval/clientes/cliente.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.registro) {
                alert('¡Registro exitoso!');
                window.location.href = "inicio.php";
            } else {
                alert('Hubo un error: Intentalo de nuevo.');
                document.getElementById('formularioRegistrarse').reset();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un problema con la solicitud.');
        });
}
)








