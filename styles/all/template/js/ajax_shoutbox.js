(function($) { // Avoid conflicts with other libraries
    $(document).ready(function(){
        console.log("Loading ajax shoutbox");
        $.ajax({
            url: AJAX_SHOUTBOX_POSTS,
            success: getAllPosts
        });
    });
    function getAllPosts(result) {
        console.log(result);
    }

    function loadData() {
        console.log("Load data.");
    }

    $("#shoutbox_content").scroll(function () {
        if ($("shoutbox_content").scrollTop() == $("#shoutbox_content").height) {
            loadData();
        }
    });
})(jQuery);
