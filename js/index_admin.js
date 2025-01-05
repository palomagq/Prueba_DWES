const editModalClient = document.getElementById('editModalClient');
const deleteModalClient = document.getElementById('deleteModalClient');
const editModalItem = document.getElementById('editModalItem');
const deleteModalItem = document.getElementById('deleteModalItem');

// Manejo del botón y modal de añadir cliente
const addClientBtn = document.getElementById('addClientBtn');
                
const addClientModal = document.getElementById('addClientModal');
const closeAddClientModal = document.getElementById('closeAddClientModal');
const cancelAddClient = document.getElementById('cancelAddClient');

                // Abrir el modal
                function openAddClientModal() {
                    document.getElementById("addClientModal").style.display = "flex";
                }

                // Cerrar el modal
                function closeAddClientModal2() {
                    document.getElementById("addClientModal").style.display = "none";
                }

//********************************CLIENTES*********************************************************************************** */
                addClientBtn.addEventListener('click', () => addClientModal.classList.add('active'));
                closeAddClientModal.addEventListener('click', () => addClientModal.classList.remove('active'));
                cancelAddClient.addEventListener('click', () => addClientModal.classList.remove('active'));

                        // Manejo del formulario de añadir cliente
                        document.getElementById('addClientForm').addEventListener('submit', function (e) {
                            e.preventDefault();
                            const newClient = {
                                addName: document.getElementById('addName').value,
                                addSurname: document.getElementById('addSurname').value,
                                addPhone: document.getElementById('addPhone').value,
                                addEmail: document.getElementById('addEmail').value,
                                addPassword: document.getElementById('addPassword').value,

                            };
                            console.log('Nuevo cliente:', newClient);
                            // Enviar los datos al servidor
                            fetch('/prueba_DWES/CasesUses/ajax_handler_user.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({
                                    action: "createUser",
                                    name: newClient.addName,
                                    surname: newClient.addSurname,
                                    phone: newClient.addPhone,
                                    email: newClient.addEmail,
                                    password: newClient.addPassword,
                                }),
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    console.log('Datos guardados exitosamente en el servidor.');
                                    location.reload();
                                } else {
                                    console.log('Error al guardar los datos en el servidor:', data.message);
                                }
                            })
                            .catch(error => {
                                console.log('Error en la solicitud:', error);
                                console.log('Detalles del error:', error.message);
                            });
                            // Lógica para enviar datos al servidor...
                            addClientModal.classList.remove('active');
                        });



               // Abrir modal de editar cliente
               let selectedRow = null; // Variable global para almacenar la fila seleccionada

                // Evento para abrir el modal y editar
                document.querySelectorAll('.edit-btn-client').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const row = this.closest('tr'); // Obtener la fila donde se hizo clic
                        console.log('Fila seleccionada para editar:', row);

                        if (!row) {
                            console.error("No se pudo encontrar la fila para editar.");
                            return;
                        }

                        // Almacenar la fila en la variable global
                        selectedRow = row;

                        // Extraer los datos de la fila
                        const name = row.querySelector('td:nth-child(2)').textContent.trim();
                        const surname = row.querySelector('td:nth-child(3)').textContent.trim();
                        const email = row.querySelector('td:nth-child(4)').textContent.trim();
                        const phone = row.querySelector('td:nth-child(5)').textContent.trim();

                        console.log("Datos extraídos de la fila:", name, surname, email, phone);

                        // Asignar los valores al formulario
                        document.getElementById('editName').value = name;
                        document.getElementById('editSurname').value = surname;
                        document.getElementById('editEmail').value = email;
                        document.getElementById('editPhone').value = phone;

                        // Abrir el modal
                        editModalClient.classList.add('active');
                    });
                });



                // Evento para actualizar los datos y cerrar el modal
                document.getElementById('editFormClient').addEventListener('submit', function (e) {
                    e.preventDefault();

                    // Asegurarnos de que hay una fila seleccionada
                    if (!selectedRow) {
                        console.error("No se encontró la fila seleccionada para actualizar.");
                        return;
                    }

                    // Obtener los datos del formulario
                    const updatedName = document.getElementById('editName').value;
                    const updatedSurname = document.getElementById('editSurname').value;
                    const updatedEmail = document.getElementById('editEmail').value;
                    const updatedPhone = document.getElementById('editPhone').value;

                    console.log("Datos actualizados del formulario:", updatedName, updatedSurname, updatedEmail, updatedPhone);

                    // Actualizar los datos en la fila seleccionada
                    selectedRow.querySelector('td:nth-child(2)').textContent = updatedName;
                    selectedRow.querySelector('td:nth-child(3)').textContent = updatedSurname;
                    selectedRow.querySelector('td:nth-child(4)').textContent = updatedEmail;
                    selectedRow.querySelector('td:nth-child(5)').textContent = updatedPhone;
                        // Enviar los datos al servidor
                        fetch('/prueba_DWES/CasesUses/ajax_handler_user.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({
                                    action: "updateClient",
                                    name: updatedName,
                                    surname: updatedSurname,
                                    phone: updatedPhone,
                                    email: updatedEmail,
                                }),
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    console.log('Datos guardados exitosamente en el servidor.');
                                } else {
                                    console.log('Error al guardar los datos en el servidor:', data.message);
                                }
                            })
                            .catch(error => {
                                console.log('Error en la solicitud:', error);
                                console.log('Detalles del error:', error.message);
                            });
                    // Limpiar la variable de la fila seleccionada
                    selectedRow = null;

                    // Cerrar el modal
                    editModalClient.classList.remove('active');
                });



                // Abrir modal de eliminar
                    document.querySelectorAll('.delete-btn-client').forEach(btn => {
                        btn.addEventListener('click', function () {
                            const row = this.closest('tr'); // Obtener la fila donde se hizo clic
                            console.log('Fila seleccionada para eliminar:', row);

                            if (!row) {
                                console.error("No se pudo encontrar la fila para eliminar.");
                                return;
                            }
                            // Almacenar la fila en la variable global
                            selectedRow = row;

                            // Abrir el modal de eliminar
                            deleteModalClient.classList.add('active');
                        });
                    });

                    document.getElementById('deleteClient').addEventListener('click', function (e) {
                        
                        console.log('llego')
                        e.preventDefault();
                        // Asegurarnos de que hay una fila seleccionada
                        if (!selectedRow) {
                            console.error("No se encontró la fila seleccionada para actualizar.");
                            return;
                        }
                        id = selectedRow.querySelector('td:nth-child(1)').textContent;

                        // Enviar los datos al servidor
                        fetch('/prueba_DWES/CasesUses/ajax_handler_user.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                action: "deleteClient",
                                id : id
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                console.log('Datos guardados exitosamente en el servidor.');
                                location.reload()
                            } else {
                                console.log('Error al guardar los datos en el servidor:', data.message);
                            }
                        })
                        .catch(error => {
                            console.log('Error en la solicitud:', error);
                            console.log('Detalles del error:', error.message);
                        });
                        // Limpiar la variable de la fila seleccionada
                        selectedRow = null;
    
                        // Cerrar el modal
                        editModalClient.classList.remove('active');
                    });

                // Cerrar modales (editar y eliminar)
                document.querySelectorAll('.close-btn, .cancel-btn').forEach(btn => {
                    btn.addEventListener('click', function () {
                        editModalClient.classList.remove('active');
                        deleteModalClient.classList.remove('active');
                    });
                });

//******************* ARTICULO***************************************************************************************** */


addItemBtn.addEventListener('click', () => addItemModal.classList.add('active'));
closeAddItemModal.addEventListener('click', () => addItemModal.classList.remove('active'));
cancelAddItem.addEventListener('click', () => addItemModal.classList.remove('active'));

        // Manejo del formulario de añadir item
        document.getElementById('addItemForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const newItem = {
                addNameItem: document.getElementById('addNameItem').value,
                addPrice: document.getElementById('addPrice').value,
                addDescription: document.getElementById('addDescription').value,


            };
            console.log('Nuevo articulo:', newItem);
            // Enviar los datos al servidor
            fetch('/prueba_DWES/CasesUses/ajax_handler_item.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: "createItem",
                    name: newItem.addNameItem,
                    price: newItem.addPrice,
                    description: newItem.addDescription,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log('Datos guardados exitosamente en el servidor.');
                    location.reload();
                } else {
                    console.log('Error al guardar los datos en el servidor:', data.message);
                }
            })
            .catch(error => {
                console.log('Error en la solicitud:', error);
                console.log('Detalles del error:', error.message);
            });
            // Lógica para enviar datos al servidor...
            addItemModal.classList.remove('active');
        });



// Abrir modal de editar item
let selectedRowItem = null; // Variable global para almacenar la fila seleccionada

// Evento para abrir el modal y editar
document.querySelectorAll('.edit-btn-item').forEach(btn => {
    btn.addEventListener('click', function () {
        const row = this.closest('tr'); // Obtener la fila donde se hizo clic
        console.log('Fila seleccionada para editar:', row);

        if (!row) {
            console.error("No se pudo encontrar la fila para editar.");
            return;
        }

        // Almacenar la fila en la variable global
        selectedRowItem = row;

        // Extraer los datos de la fila
        const name = row.querySelector('td:nth-child(2)').textContent.trim();
        const price = row.querySelector('td:nth-child(3)').textContent.trim();
        const description = row.querySelector('td:nth-child(4)').textContent.trim();

        console.log("Datos extraídos de la fila:", name, price, description);

        // Asignar los valores al formulario
        document.getElementById('editNameItem').value = name;
        document.getElementById('editPrice').value = price;
        document.getElementById('editDescription').value = description;

        // Abrir el modal
        editModalItem.classList.add('active');
    });
});



// Evento para actualizar los datos y cerrar el modal
document.getElementById('editFormItem').addEventListener('submit', function (e) {
    e.preventDefault();

    // Asegurarnos de que hay una fila seleccionada
    if (!selectedRowItem) {
        console.error("No se encontró la fila seleccionada para actualizar.");
        return;
    }

    // Obtener los datos del formulario
    const updatedNameItem = document.getElementById('editNameItem').value;
    const updatedPrice = document.getElementById('editPrice').value;
    const updatedDewscription = document.getElementById('editDescription').value;

    console.log("Datos actualizados del formulario:", updatedNameItem, updatedPrice, updatedDewscription);

    // Actualizar los datos en la fila seleccionada
    selectedRowItem.querySelector('td:nth-child(2)').textContent = updatedNameItem;
    selectedRowItem.querySelector('td:nth-child(3)').textContent = updatedPrice;
    selectedRowItem.querySelector('td:nth-child(4)').textContent = updatedDewscription;
        // Enviar los datos al servidor
        fetch('/prueba_DWES/CasesUses/ajax_handler_item.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: "updateItem",
                    name: updatedNameItem,
                    price: updatedPrice,
                    description: updatedDewscription,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log('Datos guardados exitosamente en el servidor.');
                } else {
                    console.log('Error al guardar los datos en el servidor:', data.message);
                }
            })
            .catch(error => {
                console.log('Error en la solicitud:', error);
                console.log('Detalles del error:', error.message);
            });
    // Limpiar la variable de la fila seleccionada
    selectedRowItem = null;

    // Cerrar el modal
    editModalItem.classList.remove('active');
});



// Abrir modal de eliminar
    document.querySelectorAll('.delete-btn-item').forEach(btn => {
        btn.addEventListener('click', function () {
            const row = this.closest('tr'); // Obtener la fila donde se hizo clic
            console.log('Fila seleccionada para eliminar:', row);

            if (!row) {
                console.error("No se pudo encontrar la fila para eliminar.");
                return;
            }
            // Almacenar la fila en la variable global
            selectedRowItem = row;

            // Abrir el modal de eliminar
            deleteModalItem.classList.add('active');
        });
    });

    document.getElementById('deleteItem').addEventListener('click', function (e) {
        
        console.log('llego')
        e.preventDefault();
        // Asegurarnos de que hay una fila seleccionada
        if (!selectedRowItem) {
            console.error("No se encontró la fila seleccionada para actualizar.");
            return;
        }
        id = selectedRowItem.querySelector('td:nth-child(1)').textContent;

        // Enviar los datos al servidor
        fetch('/prueba_DWES/CasesUses/ajax_handler_item.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: "deleteItem",
                id : id
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                console.log('Datos guardados exitosamente en el servidor.');
                location.reload()
            } else {
                console.log('Error al guardar los datos en el servidor:', data.message);
            }
        })
        .catch(error => {
            console.log('Error en la solicitud:', error);
            console.log('Detalles del error:', error.message);
        });
        // Limpiar la variable de la fila seleccionada
        selectedRowItem = null;

        // Cerrar el modal
        editModalItem.classList.remove('active');
    });

// Cerrar modales (editar y eliminar)
document.querySelectorAll('.close-btn, .cancel-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        editModalItem.classList.remove('active');
        deleteModalItem.classList.remove('active');
    });
});
