
let urlParam = new URLSearchParams(window.location.search);
let id = urlParam.get('idProducto');

fetch('http://localhost/GomezBalaguerV%c3%adctorProyecto1T/Proyecto1Eval/productos/producto.php?idProducto=' + id)
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
        let ruta = '../vistas/imagenes/' + data.nombre + '.png';
        imagen.src = ruta;

    })


    .catch(error => console.error("Error en la solicitud:", error));
