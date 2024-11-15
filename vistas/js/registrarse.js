document.getElementById('formularioRegistrarse').addEventListener('submit', function (event) {
    event.preventDefault();
    var formData = new FormData(this);
    var jsonData = {};
    formData.forEach((value, key) => {
        jsonData[key] = value;
    });

    fetch('http://localhost/GomezBalaguerV%c3%adctorProyecto1T/Proyecto1Eval/clientes/cliente.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(jsonData)
    })
        .then(response => response.json())
        .then(data => {
            if (data.registro) {
                window.location.href = "inicio.php";
            } else {
                //document.getElementById('errorRegistro').innerText = data.error
                document.getElementById('formularioRegistrarse').reset();
                alert(data.error)
            }
        })
        .catch(error => {
            console.error('Error:', error)
            alert('Hubo un problema con la solicitud al servidor.');
        });

}
)






