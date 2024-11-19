<script>
    let apiCarrito = "../carrito/carrito.php?idUnico=" + <?php echo json_encode($_SESSION['idUnico']); ?>;
    document.getElementById('cesta').innerHTML = '';

    // Función para actualizar los totales
    function actualizarTotales() {
        let totalPrendas = 0;
        let totalPrecio = 0;

        document.querySelectorAll('.contenedorProducto').forEach(producto => {
            const cantidad = parseInt(producto.querySelector('.cantidadProductoActualizable').textContent, 10);
            const precio = parseFloat(producto.querySelector('.precioUnitario').textContent.replace('€', ''));

            totalPrendas += cantidad;
            totalPrecio += cantidad * precio;
        });

        // Actualizar los valores en los elementos HTML
        document.getElementById('cantidadPrendasActualizableJS').textContent = totalPrendas;
        document.getElementById('precioActualizableJS').textContent = `${totalPrecio.toFixed(2)}€`;
    }

    // Obtener datos del carrito
    fetch(apiCarrito)
        .then(response => response.json())
        .then(data => {
            data.forEach(producto => {
                let apiProducto = `../productos/producto.php?idProducto=${producto.idProducto}`;
                fetch(apiProducto)
                    .then(response => response.json())
                    .then(productoDetalles => {
                        let productoHTML = `
                        <div class="row contenedorProducto">
                            <div class="productoCesta">
                                <div class="col-md-3"><img src="${productoDetalles.foto}" alt=""></div>
                                <div class="col-md-3">
                                    <div class="descripcionProducto">${productoDetalles.descripcion}</div>
                                </div>
                                <div class="col-md-3 cantidad" style="display: flex;">
                                    <div class="restar" style="cursor: pointer;">-</div>
                                    <div class="cantidadProductoActualizable">${producto.cantidad}</div>
                                    <div class="sumar" style="cursor: pointer;">+</div>
                                </div>
                                <div class="col-md-3 precioConBasura">
                                    <div class="precioUnitario">${productoDetalles.precio}€</div>
                                    <div>
                                        <img src="../vistas/imagenes/basura.png" alt="" class="eliminarProducto" 
                                            data-idproducto="${producto.idProducto}" 
                                            data-idunico="${producto.idUnico}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                        document.getElementById('cesta').insertAdjacentHTML('beforeend', productoHTML);

                        // Añadir EventListeners después de insertar el HTML
                        let contenedor = document.getElementById('cesta').lastElementChild;

                        // Restar cantidad
                        contenedor.querySelector('.restar').addEventListener('click', function() {
                            let cantidadElemento = contenedor.querySelector('.cantidadProductoActualizable');
                            let cantidadActual = parseInt(cantidadElemento.textContent, 10);
                            if (cantidadActual > 0) {
                                cantidadElemento.textContent = cantidadActual - 1;
                                actualizarTotales(); // Actualizar totales
                            }
                        });

                        // Sumar cantidad
                        contenedor.querySelector('.sumar').addEventListener('click', function() {
                            let cantidadElemento = contenedor.querySelector('.cantidadProductoActualizable');
                            let cantidadActual = parseInt(cantidadElemento.textContent, 10);
                            cantidadElemento.textContent = cantidadActual + 1;
                            actualizarTotales(); // Actualizar totales
                        });

                        // Actualizar totales después de cada inserción
                        actualizarTotales();
                    })
                    .catch(error => {
                        console.error('Error al obtener detalles del producto:', error);
                    });
            });
        })
        .catch(error => {
            console.error('Error al obtener datos del carrito:', error);
        });

    // EventListener para eliminar producto
    document.getElementById('cesta').addEventListener('click', function(event) {
        if (event.target.classList.contains('eliminarProducto')) {
            const idProducto = event.target.getAttribute('data-idproducto');
            const idUnico = event.target.getAttribute('data-idunico');

            // Hacer llamada a la API para eliminar el producto
            fetch(`../carrito/carrito.php?idUnico=${idUnico}&idProducto=${idProducto}`, {
                    method: 'DELETE',
                })
                .then(response => response.json())
                .then(data => {
                    if (data.eliminado) {
                        event.target.closest('.contenedorProducto').remove();
                        actualizarTotales(); // Actualizar totales después de eliminar
                    }
                })
                .catch(error => {
                    console.error('Error al eliminar producto:', error);
                });
        }
    });
</script>