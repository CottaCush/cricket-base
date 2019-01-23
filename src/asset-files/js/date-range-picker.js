(function ($) {
    var startDate = $('#startDate'),
        endDate = $('#endDate');

    //DatePicker
    $('.dateInput').each(function () {
        $(this).datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
    });

    startDate.datepicker()
        .on('changeDate', function () {
            let e = startDate.datepicker('getDate');
            endDate.datepicker('setStartDate', e);
        });

    endDate.datepicker()
        .on('changeDate', function () {
            let e = endDate.datepicker('getDate');
            startDate.datepicker('setEndDate', e);
        });
})(jQuery);