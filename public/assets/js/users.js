document.addEventListener('DOMContentLoaded', () => {

    // Lógica para la tabla de usuarios
    const usersTableEl = document.getElementById('usersTable');

    if (usersTableEl) {
        const usersTable = new DataTable('#usersTable', {
            layout: {
                topStart: {
                    pageLength: {
                        menu: [5, 10, 25, 50, 100] // Esto reactiva el selector
                    }
                },

                bottomStart:{
                    buttons: [
                        {
                            text: '<i class="fa-regular fa-user"></i> Nuevo Usuario', 
                            className: 'btn btn-primary',
                            titleAttr: 'Agregar Nuevo Usuario',
                            action: function ( e, dt, node, config ) {
                                 $('#newUserModal').modal('show');
                                // window.location.href = baseUrl + 'usuarios/nuevo';
                            }
                        }
                    ]
                },
            },
            paging: true,
            searching: true,
            info: false,
            ordering: true,
            order: [[0, 'desc']],
            pageLength: 10,
             language: {
                url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-MX.json'
            },
            columnDefs: [{
                targets: [-2, -1],
                width: "70px", 
                orderable: false,
                searchable: false,
                
            },
         {className: 'text-center', targets: '_all'}]
        });
    }

    // Lógica para el modal de edición
        const editUserModal = document.getElementById('editUserModal');
            if (editUserModal) { 
            document.querySelectorAll('.edit-user-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const usuario = JSON.parse(button.dataset.user);

                document.getElementById('id-user-display').textContent = usuario.id_usuario;
                document.getElementById('edit-id-user').value = usuario.id_usuario;
                document.getElementById('edit-usuario').value = usuario.usuario;
                document.getElementById('edit-nombre').value = usuario.nombre;
                document.getElementById('edit-email').value = usuario.email;
                document.getElementById('edit-rol').value = usuario.rol;
                    });
                });
            }        
        
           
    //Lógica para el modal de contraseña
        const changePassModal=document.getElementById('changePassModal');
            if (changePassModal ) {
                document.querySelectorAll('.change-pass-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const usuario = JSON.parse(btn.dataset.user);
                    
                        document.getElementById('id-user-display-pass').textContent = usuario.id_usuario;
                        document.getElementById('pass-id-user').value = usuario.id_usuario;
                        document.getElementById('pass-nombre').value = usuario.nombre;
                    });
                });
            }

    
    //TODO: si switch estatus existe
        const statusSwitches = document.querySelectorAll('.status-switch');

        if (statusSwitches.length > 0) {
            statusSwitches.forEach(swit => {
                swit.addEventListener('change', function() {
                    // Encuentra el span asociado a este switch usando el DOM traversal
                    const statusSpan = this.closest('label').querySelector('span');

                    const idUser = this.dataset.id;
                    const newStatus = this.checked ? 'activo' : 'inactivo';

                    const postData = {
                        id_user: idUser,
                        estatus: newStatus,
                        [csrfName]: csrfHash // Asegúrate de que csrfName y csrfHash estén definidos globalmente
                    };
                    
                    // Corrige la sintaxis: solo debe haber una propiedad 'data'
                    $.ajax({
                        url: updateStatusUrl,
                        method: 'POST',
                        data: postData,
                        success: function(response) {
                            if (response.status === 'success') {
                                // Actualiza el texto del span basándose en la respuesta del servidor
                                if (response.new_status === 'activo') {
                                    statusSpan.textContent = 'Activo';
                                } else {
                                    statusSpan.textContent = 'Inactivo';
                                }
                            // console.log('Estado actualizado:', response.message);
                            } else {
                                // Si hay un error, revierte el estado del checkbox
                                swit.checked = (newStatus === 'activo') ? false : true;
                                //console.error('Error:', response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            // Si la petición falla, revierte el estado del checkbox
                            swit.checked = (newStatus === 'activo') ? false : true;
                            console.error('Error al actualizar el estado:', error);
                        }
                    });
                });
            });
        }


    // Toggle password visibility logic 
    document.addEventListener('click', function (event) {
        const btn = event.target.closest('.toggle-password');
        
        if (btn) {
            const container = btn.closest('.position-relative');
            const passwordInput = container.querySelector('input');
            const icon = btn.querySelector('i');

            if (passwordInput && icon) {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            }
        }
        });

// Fin de DOMContentLoaded
});

    // Función para forzar mayúsculas en inputs con clase .uc-text
        function ForzarMayus() {
            const forceInputUppercase = function(e) {
                let el = e.target;
                let start = el.selectionStart;
                let end = el.selectionEnd;
                
                // Solo transformamos si el valor cambió para evitar loops infinitos
                const originalValue = el.value;
                const upperValue = originalValue.toUpperCase();
                
                if (originalValue !== upperValue) {
                    el.value = upperValue;
                    el.setSelectionRange(start, end);
                }
            };

            // Seleccionamos todos los inputs con la clase .uc-text
            document.querySelectorAll(".uc-text").forEach(function(current) {
                // 'input' es más robusto que 'keyup'
                current.addEventListener("input", forceInputUppercase);
            });
        }

    // Función para eliminar espacios en inputs con clase .no-space
        function ValidarInputUsuario() {
            const processInput = function(e) {
                let el = e.target;
                let start = el.selectionStart;
                
                // 1. Convertir a Mayúsculas
                let value = el.value.toUpperCase();
                
                // 2. Eliminar espacios en blanco
                // La regex /\s/g busca cualquier espacio, tabulación o salto de línea
                value = value.replace(/\s/g, "");
                
                if (el.value !== value) {
                    el.value = value;
                    // Reposicionamos el cursor para que no salte al final
                    el.setSelectionRange(start, start);
                }
            };

            // Aplicar a los inputs con clase .uc-text (Mayúsculas)
            // Y específicamente a .no-space (Sin espacios)
            document.querySelectorAll(".no-space").forEach(function(current) {
                current.addEventListener("input", processInput);
            });
        }

