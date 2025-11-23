// In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap-5'
    });

    $('.datepicker').datepicker({
    dateFormat: 'yy-mm-dd',
        defaultDate: new Date(),
        autoclose: true,
        todayHighlight: true
    });
});