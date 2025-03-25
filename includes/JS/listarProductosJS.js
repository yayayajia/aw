$(document).ready(function() {
    $.ajax({
        url: '../includes/controller/obtenerProductosController.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.length === 0) {
                $('#productos').html('<p>No hay productos disponibles.</p>');
            } else {
                var productosHtml = '';
                data.forEach(function(producto) {
                    productosHtml += '<div class="producto">';
                    productosHtml += '<h3>' + producto.nombreProducto + '</h3>';
                    productosHtml += '<p>' + producto.descripcionProducto + '</p>';
                    productosHtml += '<p>Precio: ' + producto.precio + '€</p>';
                    productosHtml += '<p>Categoría: ' + producto.categoriaProducto + '</p>';
                    productosHtml += '<img src="../' + producto.rutaImagen + '" style="height: 200px;" />';
                    /*PARA LA PRACTICA 3 
                    productosHtml += '<form action="../includes/controller/ComprarProductoController.php" method="POST">';
                    productosHtml += '<input type="hidden" name="producto_id" value="' + producto.id + '">';
                    productosHtml += '<input type="hidden" name="precio" value="' + producto.precio + '">';
                    productosHtml += '<button type="submit" class="btn">Comprar</button>'; PARA LA PRACTICA 3*/
                    productosHtml += '</form>';
                    productosHtml += '</div>';
                });
                $('#productos').html(productosHtml);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error al obtener los productos:', textStatus, errorThrown);
        }
    });
});
