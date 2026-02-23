<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css"  />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.bootstrap5.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.6/css/buttons.bootstrap5.css"/>
    
    <link rel="shortcut icon" href="<?= base_url() ?>public/assets/img/icon.ico" type="image/x-icon">
</head>
<body>
    <?=view ("partials/navbar"); ?><!--NavBar-->
    <?=view ("partials/session"); ?><!--mensaje-->

    <div class="container mt-4">
        <h2 class="mb-3 text-center fw-bold ">Usuarios</h2>

        <div class="table-responsive">
            <table id="usersTable" class="table table-striped table-hover text-center align-middle  ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Usuario </th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class='table-group-divider'> 
                    <?php foreach ($usuarios as $usuario): ?>
                    
                    <tr>
                        <td><?= esc($usuario->id_usuario) ?></td>
                        <td><?= esc($usuario->nombre) ?></td>
                        <td><?= esc($usuario->email) ?></td>
                        <td><?= esc($usuario->usuario) ?></td>
                        <td><?= esc($usuario->rol) ?></td>
                        <td>
                            <span class="badge 
                                <?= match($usuario->estatus) {
                                    '1' => 'bg-primary',
                                    '0' => 'bg-danger',
                                    default => 'bg-secondary'
                                } ?>">
                                
                                <?= match($usuario->estatus) {
                                    '1' => 'Activo',
                                    '0' => 'Inactivo',
                                    default => 'Desconocido'
                                } ?>
                            </span>
                        </td>
                        <td>
                            <a href="#"
                                class="btn btn-sm btn-outline-primary edit-user-btn"
                                data-user='<?= json_encode($usuario) ?>'
                                data-bs-toggle="modal"
                                data-bs-target="#editUserModal">
                                <i class="fa-regular fa-pen-to-square"></i>
                                </a>

                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-outline-primary change-pass-btn"
                                data-bs-toggle="modal" data-bs-target="#changePassModal" data-user='<?= json_encode($usuario) ?>'><i class="fa fa-key"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <!-- Modal crear -->
        <div class="modal fade" id="newUserModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered ">
                <div class="modal-content shadow-lg ">

                <form id="newUserForm" method="POST" autocomplete="off" action="<?= base_url('usuario/new') ?>">
                    <div class="modal-header bg-primary text-white fw-bold">
                        <h5 class="modal-title">Nuevo usuario</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="new-nombre" class="form-label">Nombre completo</label>
                            <input type="text" name="new-nombre" id="new-nombre" class="form-control uc-text" required>
                        </div>
                        <div class="mb-3">
                            <label for="new-usuario" class="form-label">Usuario</label>
                            <input type="text" name="new-usuario" id="new-usuario"
                                class="form-control uc-text no-space" required>
                        </div>
                        <div class="mb-3">
                            <label for="new-email" class="form-label">Correo electrónico</label>
                            <input type="email" name="new-email" id="new-email"
                                class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="new-password" class="form-label">Contraseña</label>
                            <div class="position-relative">
                                <input type="password" name="new-password" id="new-password" required class="form-control pe-5" placeholder="Contraseña">
                                <span id="viewPassword" class="toggle-password position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;">
                                    <i class="fa-solid fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="new-rol" class="form-label">Rol</label>
                            <select id="new-rol" name="new-rol" class="form-select">
                                <option value="ADMIN">Administrador</option>
                                <option value="USUARIO">Usuario</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            Guardar
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        
    <!-- Edit user modal -->
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered ">
                <div class="modal-content shadow-lg ">

                <form id="editUserForm" method="POST" action="<?= base_url('usuario/update') ?>">
                    <div class="modal-header bg-primary text-white fw-bold">
                        <h5 class="modal-title">Editar usuario</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Id:</label><br>
                            <span id="id-user-display" class="badge bg-primary fs-6">Cargando...</span>
                            <input type="hidden" name="id_user" id="edit-id-user">
                        </div>
                        <div class="mb-3">
                            <label for="edit-nombre" class="form-label">Nombre completo</label>
                            <input type="text" name="nombre" id="edit-nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-usuario" class="form-label">Usuario</label>
                            <input type="text" name="usuario" id="edit-usuario" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-email" class="form-label">Correo electrónico</label>
                            <input type="email" name="correo" id="edit-email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-rol" class="form-label">Rol</label>
                            <select id="edit-rol" name="rol" class="form-select">
                                <option value="ADMIN">Administrador</option>
                                <option value="USUARIO">Usuario</option>
                              
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
                </div>
            </div>
        </div>

    <!-- MODAL PASS -->
        <div class="modal fade" id="changePassModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                <form method="POST" action="<?= base_url('usuario/updatePassword') ?>">
                    <div class="modal-header bg-primary text-dark">
                        <h5 class="modal-title text-white">Actualizar contraseña</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Id:</label><br>
                            <span id="id-user-display-pass" class="badge bg-dark fs-6">Cargando...</span>
                            <input type="hidden" name="id_user" id="pass-id-user">
                        </div>
                        <div class="mb-3">
                            <label for="pass-nombre" class="form-label">Nombre</label>
                            <input type="text" id="pass-nombre" name="pass-nombre" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva contraseña</label>
                            <div class="position-relative">
                                <input type="password" name="password" id="password" required class="form-control pe-5" placeholder="Contraseña">
                                <span id="viewPassword" class="toggle-password position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;">
                                    <i class="fa-solid fa-eye"></i>
                                </span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Confirmar contraseña</label>
                            <div class="position-relative">
                                <input type="password" name="password_confirm" id="password_confirm" required class="form-control pe-5" placeholder="Contraseña">
                                <span id="viewPassword" class="toggle-password position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;">
                                    <i class="fa-solid fa-eye"></i>
                                </span>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Actualizar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> Cancelar</button>
                    </div>
                </form>
                </div>
            </div>
        </div>

    <!-- div container -->
    </div>
    




<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/2.3.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.7/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.6/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.bootstrap5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.colVis.min.js"></script>
<script src="<?= base_url('public/assets/js/users.js') ?>"></script>



<script>
    
    $(document).ready(function() {
        ForzarMayus();
        ValidarInputUsuario();
    });
    
        var updateStatusUrl = "<?= site_url('update_estatus_user') ?>";
        var baseUrl = "<?= base_url() ?>";

        // Abrir modal con datos al hacer click en crear
         <?php if (session()->getFlashdata('open_new_modal')): ?>
            document.addEventListener("DOMContentLoaded", function () {
                const modalnew = new bootstrap.Modal(document.getElementById('newUserModal'));
                modalnew.show();

                
                const usernew = <?= json_encode(session()->getFlashdata('old_user')) ?>;
                document.getElementById('new-nombre').value = usernew.nombre;
                document.getElementById('new-usuario').value = usernew.usuario;
                document.getElementById('new-email').value = usernew.email;
                document.getElementById('new-rol').value = usernew.rol;
                

            });
        <?php endif; ?>

        // Abrir modal con datos al hacer click en editar
        <?php if (session()->getFlashdata('open_edit_modal')): ?>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = new bootstrap.Modal(
                    document.getElementById('editUserModal')
                );
                modal.show();

                const user = <?= json_encode(session()->getFlashdata('old_user')) ?>;

                document.getElementById('edit-id-user').value = user.id_user;
                document.getElementById('id-user-display').textContent = user.id_user;
                document.getElementById('edit-nombre').value = user.nombre;
                document.getElementById('edit-email').value = user.correo;
                document.getElementById('edit-usuario').value = user.usuario;
                document.getElementById('edit-rol').value = user.rol;
            });
        <?php endif; ?> 
        
        

        // Abrir modal con datos al hacer click en pass y mandar errores
        <?php if (session()->getFlashdata('open_pass_modal')): ?>
            document.addEventListener("DOMContentLoaded", function () {
                const modalPass = new bootstrap.Modal(document.getElementById('changePassModal'));
                modalPass.show();

                
                const userPass = <?= json_encode(session()->getFlashdata('old_user')) ?>;
                document.getElementById('pass-id-user').value = userPass.id_user;
                document.getElementById('id-user-display-pass').textContent = userPass.id_user;
                document.getElementById('pass-nombre').value = userPass.nombre;

            });
        <?php endif; ?>
</script>
</body>
</html>