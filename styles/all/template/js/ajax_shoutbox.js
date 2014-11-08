(function($) { // Avoid conflicts with other libraries
    $(document).load(function(){
        console.log("Loading ajax shoutbox");
        $.ajax({
            url: AJAX_SHOUTBOX_POSTS,
            success: getAllPosts
        });
    });
    function getAllPosts() {

    }

    function loadData() {
        console.log("Load data.");
    }

    $("#shoutbox_content").scroll(function () {
        if ($("shoutbox_content").scrollTop() == $("#shoutbox_content")) {
            loadData();
        }
    });


})(jQuery);
