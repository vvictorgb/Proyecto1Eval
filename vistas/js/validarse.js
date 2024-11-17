document.getElementById('formularioValidarse').addEventListener('submit', function (event) {
    event.preventDefault();
    var formData = new FormData(this);
    let dniEnviar = formData.get('dniCliente');
    let contraseñaEnviar = formData.get('pwd');
    let api = 'http://localhost/GomezBalaguerV%c3%adctorProyecto1T/Proyecto1Eval/clientes/cliente.php' + "?dniCliente=" + dniEnviar + '&pwd=' + contraseñaEnviar
    fetch(api)
        .then(response => response.json())
        .then(data => {
            if (data.registro) {
                window.location.href = "inicio.php";
            } else {
                document.getElementById('formularioValidarse').reset();
                document.getElementById('errorValidarse').style.visibility = 'visible';

            }
        })
        .catch(error => {
            console.error('Error:', error)
            alert('Hubo un problema con la solicitud al servidor.');
        });

}
)






