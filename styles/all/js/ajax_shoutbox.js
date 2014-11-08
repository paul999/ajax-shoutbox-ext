(function($) { // Avoid conflicts with other libraries
    function loadData() {
        console.log("Load data.");
    }

    $("#shoutbox_content").scroll(function () {
        if ($("shoutbox_content").scrollTop() == $("#shoutbox_content")) {
            loadData();
        }
    });


})(jQuery);
