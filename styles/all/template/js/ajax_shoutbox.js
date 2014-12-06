(function($) { // Avoid conflicts with other libraries
    var timeout;
    var lastId;
    var firstId;
    var waitingEarlier;

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

        $("#ajaxshoutbox_loadbefore").hide();
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

        $("#ajaxshoutbox_loadafter").hide();
        waitingEarlier = false;
    }

    /**
     * Get posts after the last post.
     */
    function getPostsAfter() {
        clearTimeout(timeout);
        $("#submit_shoutbox").fadeIn();
        $("#ajaxshoutbox_loadbefore").fadeIn();

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
        if ($("#shout" + post.id).length != 0) {
            return;
        }

        var element = $("#copy").clone();
        element.attr('id',  "shout" + post.id);
        $(element).find("[data-type='user']").html(post.user);
        $(element).find("[data-type='message']").html(post.message);
        $(element).find("[data-type='date']").html(post.date);

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
        $("#ajaxshoutbox_loadafter").fadeIn();
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
        waitingEarlier = false;
    });

    $("#shoutbox_scroll").scroll(function () {
        if (!waitingEarlier && $("#shoutbox_scroll").scrollTop() >= $("#shoutbox_content").height() - $("#shoutbox_scroll").height() - 25) {
            waitingEarlier = true;
            loadData();
        }
    });
    phpbb.addAjaxCallback('paul999.ajaxshoutbox.post_callback', function(data) {
        if (data.error) {
            console.log(data.error);
            phpbb.alert(data.title, data.error);
        }

        console.log("Finished ajax callback");
        getPostsAfter();
    });

    phpbb.ajaxify({selector: $("#ajaxshoutbox_post"), filter: function() {
            console.log("Posting message");

            $("#text_shoutbox").val('');
            $("#submit_shoutbox").hide();
            clearTimeout(timeout);

            return true;
        },
        callback: 'paul999.ajaxshoutbox.post_callback'
    });
})(jQuery);
