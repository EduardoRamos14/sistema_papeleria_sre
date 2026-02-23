<?php if (session('message')): ?>
<div  id="alert-success"
     class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3 shadow"
     style="z-index:99999; min-width:400px" role="alert">
    <?= session('message') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if (session('message_warning')): ?>
<div  id="alert-warning"
     class="alert alert-warning alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3 shadow"
     style="z-index:99999; min-width:400px" role="alert">
    <?= session('message_warning') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if (session('message_danger')): ?>
<div  id="alert-danger"
     class="alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3 shadow"
     style="z-index:99999; min-width:400px" role="alert">
    <?= session('message_danger') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>


<script>
    // Cerrar las alertas después de 1.5 segundos
    setTimeout(function() {
        var successAlert = document.getElementById('alert-success');
        if (successAlert) {
            successAlert.style.display = 'none';
        }
        
        var warningAlert = document.getElementById('alert-warning');
        if (warningAlert) {
            warningAlert.style.display = 'none';
        }

        var dangerAlert = document.getElementById('alert-danger');
        if (dangerAlert) {
            dangerAlert.style.display = 'none';
        }
    }, 4000);
</script>


