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

        $.each(result, function(  ) {
            addPost(this, true);
        });
    }

    var lastId;

    function addPost(post, front)
    {
        var element = $("row").clone();
        element.id = "shout" + post.id;

        if (front && lastId) {
            $("#shout" + lastId).before(element);
            lastId = post.id;
        }
        else
        {
            $("#shoutbox_content").append($element);
            if (front) {
                lastId = post.id;
            }
        }
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
