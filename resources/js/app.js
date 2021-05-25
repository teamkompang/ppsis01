require('./bootstrap');


$(document).ready(function () {
    var today = new Date();
    $('.datepicker').datepicker({
        format: 'mm-dd-yyyy',
        autoclose:true,
        endDate: "today",
        maxDate: today
    }).on('changeDate', function (ev) {
            $(this).datepicker('hide');
        });


    $('.datepicker').keyup(function () {
        if (this.value.match(/[^0-9]/g)) {
            this.value = this.value.replace(/[^0-9^-]/g, '');
        }
    });
});