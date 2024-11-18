let apiURL = 'http://localhost/GomezBalaguerV%c3%adctorProyecto1T/Proyecto1Eval/productos/producto.php';

function renderProductos() {
    const productosContainer = document.querySelector('.contenedorFotos');

    fetch(apiURL)
        .then(response => {
            if (!response.ok) {
                throw new Error("Error en la respuesta de la API");
            }
            return response.json();
        })
        .then(productos => {

            productosContainer.innerHTML = "";
            let row = document.createElement('div');
            row.classList.add('row')

            productos.forEach(producto => {

                const colDiv = document.createElement('div');
                colDiv.classList.add('col-md-3');

                const cardDiv = document.createElement('div');
                cardDiv.classList.add('card', 'espacioCard');

                const img = document.createElement('img');
                img.src = producto.foto;
                img.classList.add('card-img-top');
                img.alt = producto.nombre;

                const cardBodyDiv = document.createElement('div');
                cardBodyDiv.classList.add('card-body');

                const encabezadoCardDiv = document.createElement('div');
                encabezadoCardDiv.classList.add('encabezadoCard');

                const nombreProducto = document.createElement('h5');
                nombreProducto.classList.add('card-nombre');
                nombreProducto.innerText = producto.nombre;

                const precioProducto = document.createElement('h5');
                precioProducto.classList.add('precio');
                precioProducto.innerText = `${producto.precio} €`;

                const descripcionProducto = document.createElement('p');
                descripcionProducto.classList.add('card-descripcion');
                descripcionProducto.innerText = producto.descripcion;

                const enlace = document.createElement('a');
                enlace.href = `verDetalle.php?idProducto=${producto.idProducto}`;
                enlace.classList.add('btn', 'btn-primary', 'sombraInfo');
                enlace.innerText = 'Más información';

                encabezadoCardDiv.appendChild(nombreProducto);
                encabezadoCardDiv.appendChild(precioProducto);
                cardBodyDiv.appendChild(encabezadoCardDiv);
                cardBodyDiv.appendChild(descripcionProducto);
                cardBodyDiv.appendChild(enlace);
                cardDiv.appendChild(img);
                cardDiv.appendChild(cardBodyDiv);
                colDiv.appendChild(cardDiv);
                row.appendChild(colDiv);
            }

            );
            productosContainer.appendChild(row)
        })
        .catch(error => {
            console.error("Error al obtener los productos:", error);
        });
}


renderProductos();