
let urlParam = new URLSearchParams(window.location.search);
let id = urlParam.get('idProducto');

fetch('../productos/producto.php?idProducto=' + id)
    .then(response => response.json())

    .then(data => {
        document.getElementById('migasDePanPrenda').innerHTML = data.nombre;
        document.getElementById('tituloNombrePrenda').innerHTML = data.nombre;
        document.getElementById('descripcionPrendaDetalle').innerHTML = data.descripcion;
        document.getElementById('precioDetalle').innerHTML = data.precio + " " + "€";
        let nombreFormulario = document.getElementById('nombreFormulario');
        nombreFormulario.value = data.nombre;
        let idProductoFormulario = document.getElementById('idProductoFormulario');
        idProductoFormulario.value = data.idProducto;
        let precioFormulario = document.getElementById('precioFormulario');
        precioFormulario.value = data.precio;
        let imagen = document.getElementById('imagenDetalle');
        let ruta = data.foto;
        imagen.src = ruta;

    })
    .catch(error => console.error("Error en la solicitud:", error));



document.getElementById('formularioDetalle').addEventListener('submit', function (event) {
    event.preventDefault();
    var formData = new FormData(this);
    let cantidad = formData.get('cantidad');
    let idProducto = formData.get('idProducto');
    fetch('../carrito/carrito.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            cantidad: cantidad,
            idProducto: idProducto
        }

        )
    })
        .then(response => response.text())
        .then(data => {
            window.location.href = "verCarrito.php";
        })
        .catch(error => {
            console.error('Error:', error)
            alert('Hubo un problema con la solicitud al servidor.');
        });

}
)

