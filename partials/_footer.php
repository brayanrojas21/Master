<div class="modal fade" id="Salir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">¿Realmente quieres salir?</h5>
            </div>
            <div class="modal-body">Seleccione "Salir" si está listo para finalizar su sesión actual.</div>
            <div class="modal-footer">
                <a class="btn btn-default" type="button" data-bs-dismiss="modal">Cancelar</a>
                <a class="btn btn-danger salir" href="/">Salir</a>
            </div>
        </div>
    </div>
</div>
<!-- plugins:js -->
<script src="/assets/vendors/js/vendor.bundle.base.js?v1"></script>
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="/assets/js/sweetalert2.min.js" type="text/javascript"></script>
<script src="/assets/js/dropzone-min.js?v1" type="text/javascript"></script>

<script src="/assets/vendors/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="/assets/vendors/datatables/dataTables.bootstrap4.min.js" type="text/javascript"></script>
<script src="/assets/vendors/datatables/dataTables.fixedHeader.min.js" type="text/javascript"></script>
<script src="/assets/vendors/datatables/dataTables.responsive.min.js" type="text/javascript"></script>
<script src="/assets/js/flexible.pagination.js" type="text/javascript"></script>
<script src="/assets/js/jquery.smartWizard.min.js" type="text/javascript"></script>
<script src="/assets/vendors/moment/moment.min.js" type="text/javascript"></script>
<script src="/assets/vendors/moment/es-mx.js" type="text/javascript"></script>
<script src="/assets/vendors/select2/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>
<script src="/assets/js/logica/<?= $js ?? 'respuesta' ?>.js?v=<?= uniqid() ?>" type="text/javascript"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="/assets/js/off-canvas.js?v1.1" type="text/javascript"></script>
<!-- endinject -->
</body>

</html>
