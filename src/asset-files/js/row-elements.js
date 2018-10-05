(function ($) {
    var $equalHeight = $('.equal-height'),
        $row = $('.row');

    $(document).ready(function() {
        //ensure row elements inherit their siblings maximum height
        $row.each(function() {
            var thisRow = $(this),
                heights = thisRow.find($equalHeight).map(function() {
                    return $(this).height();
                }).get(),

                maxHeight = Math.max.apply(null, heights);
            thisRow.find($equalHeight).css('height', maxHeight + "px" );
        });
    });
})(jQuery);
