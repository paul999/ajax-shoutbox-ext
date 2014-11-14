(function($) { // Avoid conflicts with other libraries
    var timeout;
    var lastId;

    $(document).ready(function(){
        console.log("Loading ajax shoutbox");
        $.ajax({
            url: AJAX_SHOUTBOX_POSTS,
            success: addPostsFront
        });
    });
    /**
     * Add a resultset of posts in front of current posts.
     *
     * @param result
     */
    function addPostsFront(result) {
        console.log(result);

        $.each(result, function(  ) {
            addPost(this, true);
        });

        clearTimeout(timeout);
        timeout = setTimeout(getPostsAfter, 5000);
    }

    /**
     * Get posts after the last post.
     */
    function getPostsAfter() {
        $.ajax({
            url: AJAX_SHOUTBOX_POSTS_NEW.replace("0", lastId),
            success: addPostsFront
        });
    }

    /**
     * Add a new post to the shoutbox.
     * @param post
     * @param front if true, add the post in front (new posts)
     */
    function addPost(post, front)
    {
        var element = $("#copy").clone();
        element.attr('id',  "shout" + post.id);
        $(element).find("dt[data-type='user']").html(post.user);
        $(element).find("dd[data-type='message']").html(post.message);
        $(element).find("dd[data-type='date']").html(post.date);

        if (front && lastId) {
            $("#shout" + lastId).before(element);
            lastId = post.id;
        }
        else
        {
            $("#shoutbox_content").append(element);
            if (front) {
                lastId = post.id;
            }
        }
        $("#shout" + post.id).fadeIn();
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
