

<!-- General JS Scripts -->
<script src="../../assets/modules/jquery.min.js"></script>
<script src="../../assets/modules/popper.js"></script>
<script src="../../assets/modules/tooltip.js"></script>
<script src="../../assets/modules/bootstrap/js/bootstrap.min.js"></script>
<script src="../../assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
<script src="../../assets/modules/moment.min.js"></script>
<script src="../../assets/js/stisla.js"></script>

<script src="../../assets/modules/datatables/datatables.min.js"></script>
<script src="../../assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="../../assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
<script src="../../assets/modules/jquery-ui/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>

<script src="../../assets/js/page/modules-datatables.js"></script>

<!-- JS Libraies -->

<!-- Page Specific JS File -->

<!-- Template JS File -->
<script src="../../assets/js/scripts.js"></script>
<script src="../../assets/js/custom.js"></script>
<script>
    $(".nominal").inputmask({
        alias : "currency",
        groupSeparator: ".",
        radixPoint: ',',
        prefix: "",
        placeholder: "",
        allowPlus: false,
        allowMinus: false,
        rightAlign: false,
        digits: 0,
        removeMaskOnSubmit: true,
    });
</script>