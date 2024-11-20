let apiCarrito = "../carrito/carrito.php"

// Obtener datos del carrito
fetch(apiCarrito)
    .then(response => response.json())
    .then(data => {
        if (data.length === 0) {
            // Si no hay productos, mostrar mensaje al usuario
            document.getElementById('vacio').innerText = 'Tu carrito está vacío';
        } else {
            document.getElementById('cesta').innerHTML = '';
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
                        let contenedor = document.getElementById('cesta').lastElementChild;

                        // Restar cantidad
                        contenedor.querySelector('.restar').addEventListener('click', function () {
                            let cantidadElemento = contenedor.querySelector('.cantidadProductoActualizable');
                            let cantidadActual = parseInt(cantidadElemento.textContent, 10);
                            if (cantidadActual > 0) {
                                cantidadElemento.textContent = cantidadActual - 1;
                            }
                        });

                        // Sumar cantidad
                        contenedor.querySelector('.sumar').addEventListener('click', function () {
                            let cantidadElemento = contenedor.querySelector('.cantidadProductoActualizable');
                            let cantidadActual = parseInt(cantidadElemento.textContent, 10);
                            cantidadElemento.textContent = cantidadActual + 1;
                        });
                        function calcularSubtotal() {
                            // Seleccionar todos los elementos con la clase "cantidadProductoActualizable"
                            const cantidades = document.querySelectorAll('.cantidadProductoActualizable');

                            // Sumar los valores del innerText de cada elemento
                            let totalCantidad = 0;
                            cantidades.forEach(cantidad => {
                                const valor = parseInt(cantidad.innerText, 10) || 0; // Asegurarse de convertir a número y evitar NaN
                                totalCantidad += valor;
                            });

                            // Mostrar el total en el elemento con id "subtotal"
                            const subtotalElement = document.getElementById('subtotal');
                            if (subtotalElement) {
                                subtotalElement.innerText = 'Subtotal: ' + totalCantidad;
                            }
                        };

                        // Ejecutar la función al cargar la página
                        calcularSubtotal();

                        let boton = document.getElementById('iniciarPedido')
                        boton.addEventListener('click', () => {
                            window.location.href = "confirmar.php"
                        })

                        // Eliminar producto
                        contenedor.querySelector('.eliminarProducto').addEventListener('click', function () {
                            let idProducto = this.dataset.idproducto;

                            fetch(`../carrito/carrito.php`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({ idProducto }),
                            })
                                .then(response => {
                                    console.log('Producto eliminado:', response);
                                    window.location.href = "verCarrito.php";
                                })
                                .catch(error => {
                                    console.error('Error al eliminar producto:', error);
                                });
                        });
                    })
                    .catch(error => {
                        console.error('Error al obtener detalles del producto:', error);
                    });
            });
        }
    })
    .catch(error => {
        console.error('Error al obtener datos del carrito:', error);
    });
