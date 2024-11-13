
let urlParam = new URLSearchParams(window.location.search);
let id = urlParam.get('idProducto');


let idEnviar = {
    idProducto: id
};
fetch('urlAPI', {
    method: 'GET',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(idEnviar)
})
    .then(response => response.json())

    .then(data => console.log(data))


    .catch(error => console.error("Error en la solicitud:", error));
