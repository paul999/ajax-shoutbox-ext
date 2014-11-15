(function($) { // Avoid conflicts with other libraries
    var timeout;
    var lastId;
    var firstId;

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
     * Append older posts at the back
     * @param result
     */
    function appendPosts(result) {
        console.log(result);

        $.each(result, function(  ) {
            addPost(this, false);
        });
    }

    /**
     * Get posts after the last post.
     */
    function getPostsAfter() {
        clearTimeout(timeout);
        $("#submit_shoutbox").fadeIn();

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
            firstId = post.id;
            if (front) {
                lastId = post.id;
            }
        }
        $("#shout" + post.id).fadeIn();
    }

    /**
     * Load data when we are scrolled to the end.
     */
    function loadData() {
        $.ajax({
            url: AJAX_SHOUTBOX_POSTS_OLD.replace("0", firstId),
            success: appendPosts
        });
    }

    // Once the document is ready, we start collecting posts.
    $(document).ready(function(){
        console.log("Loading ajax shoutbox");
        $.ajax({
            url: AJAX_SHOUTBOX_POSTS,
            success: addPostsFront
        });
    });

    $("#shoutbox_scroll").scroll(function () {
        if ($("#shoutbox_scroll").scrollTop() == $("#shoutbox_content").height() - $("#shoutbox_scroll").height()) {
            loadData();
        }
    });
    phpbb.addAjaxCallback('paul999.ajaxshoutbox.post_callback', function() {
        console.log("Finished ajax callback");
        getPostsAfter();
    });

    phpbb.ajaxify({selector: $("#ajaxshoutbox_post"), filter: function() {
        console.log("Posting message");

        $("#text_shoutbox").val('');
        $("#submit_shoutbox").hide();
        clearTimeout(timeout);

        return true;
    }
    }, false, 'paul999.ajaxshoutbox.post_callback');
})(jQuery);
