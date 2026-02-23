<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=base_url()?>public/assets/css/login.css">
    
    <link rel="shortcut icon" href="<?= base_url() ?>public/assent/img/icon.ico" type="image/x-icon">

    <title>Login</title>
</head>
<header>
<div class="container_logo">
    <img src="<?= base_url() ?>public/assets/img/logo_cdmx.png" alt="Logo CDMX" class="logo_cdmx">
</div>
</header>

<body>

<form action="<?=base_url()?>login" method="post">
    <div class="d-flex">
        <h2 class='text-rojo titulo'>Solicitud de Papelería</h2>
    </div>

    <label for="usuario">Usuario:</label>
    <input type="text" name="usuario" id="usuario" required class="form-control uc-text" placeholder="Usuario">
    
    <label for="password">Contraseña:</label>
    <div class="position-relative">
        <input type="password" name="password" id="password" required class="form-control pe-5" placeholder="Contraseña">
        <span id="viewPassword" class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;">
            <i class="fa-solid fa-eye"></i>
        </span>
    </div>

    <input class="mt-4 btn btn-rojo w-100" type="submit" value="Iniciar Sesión">
    

</form>
<?=view ("partials/session"); ?><!--mensaje-->

<footer>
    <p class="text-center mt-md mb-md fixed-bottom fw-bold text-black">Copyright &copy; Ing. Jenny Valeria Jimenez Muñiz</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('viewPassword').addEventListener('click', function () {
        let passwordInput = document.getElementById('password');
        let icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>

<script>//FORZAR MAYUS
		var forceInputUppercase = function(e) {
		let el = e.target;
		let start = el.selectionStart;
		let end = el.selectionEnd;
		el.value = el.value.toUpperCase();
		el.setSelectionRange(start, end);
		};
		document.querySelectorAll(".uc-text").forEach(function(current) {
		current.addEventListener("keyup", forceInputUppercase);
		});
	</script>


</body>
</html>