const tableCart = document.getElementById('tableCart').querySelector('tbody');


window.addEventListener('load', function () {
    updateCart();
  });

function updateCart(){
    fetch('/prueba_DWES/CasesUses/ajax_handler_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: "getCartNum",
            user_id: document.getElementById("user_id").value,
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            console.log('Datos guardados exitosamente en el servidor.');
            console.log(data.datos)
            document.getElementById("count_product").innerHTML=data.datos[0].cantidad
            //location.reload();
        } else {
            console.log('Error al guardar los datos en el servidor:', data.message);
        }
    })
    .catch(error => {
        console.log('Error en la solicitud:', error);
        console.log('Detalles del error:', error.message);
    });             
}

function addItemCart(id){

    // Enviar los datos al servidor
    fetch('/prueba_DWES/CasesUses/ajax_handler_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: "addToCart",
            user_id: document.getElementById("user_id").value,
            item_id: id,
            quantity: 1,
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            console.log('Datos guardados exitosamente en el servidor.');
            updateCart()
               
        } else {
            console.log('Error al guardar los datos en el servidor:', data.message);
        }
    })
    .catch(error => {
        console.log('Error en la solicitud:', error);
        console.log('Detalles del error:', error.message);
    });
}


function getCart(){
    // Enviar los datos al servidor
    fetch('/prueba_DWES/CasesUses/ajax_handler_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: "getCart",
            user_id: document.getElementById("user_id").value,
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            console.log('Datos guardados exitosamente en el servidor.'); 
            llenarTabla(data.datos) 
            document.getElementById("cartModal").classList.add('active')
            console.log(data.datos)  

        } else {
            console.log('Error al guardar los datos en el servidor:', data.message);
        }
    })
    .catch(error => {
        console.log('Error en la solicitud:', error);
        console.log('Detalles del error:', error.message);
    });
}


    // Función para llenar la tabla con datos
    function llenarTabla(datos) {
        tableCart.innerHTML = ''; // Limpiar tabla
        total = 0;
        datos.forEach(item => {
            total+=parseFloat(item.total);
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${item.name}</td>
            <td>${item.price}</td>
            <td>${item.cantidad}</td>
            <td>${item.total}</td>

          `;
          tableCart.appendChild(row);
          document.getElementById('total_price').innerHTML=total+"€"
        });
      }

      function checkout(){
        // Enviar los datos al servidor
        fetch('/prueba_DWES/CasesUses/ajax_handler_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: "checkout",
                user_id: document.getElementById("user_id").value,
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('¡Compra realizada exitosamente!');
                // Vaciar el carrito
                const cartList = document.getElementById('cart_list');
                cartList.innerHTML = ''; // Vacía la tabla del carrito

                // Actualizar el total a 0
                document.getElementById('total_price').textContent = '0€';
                
                // Forzar número del carrito a 0 manualmente
                document.getElementById('count_product').textContent = '0';


                updateCart();

                console.log('Datos guardados exitosamente en el servidor.'); 


                console.log(data.datos)  
    
            } else {
                console.log('Error al guardar los datos en el servidor:', data.message);
            }
        })
        .catch(error => {
            console.log('Error en la solicitud:', error);
            console.log('Detalles del error:', error.message);
        });
    }
    

// Cerrar modales 
document.querySelectorAll('.close-btn, .cancel-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById("cartModal").classList.remove('active');
    });
});
