$( document ).ready(function() {

    $('#more_news').click(function(){
        $.ajax({
            url: "http://seolizer/wp-content/themes/seolizer/inc/more_news.php",
            data: {sort_type: "1"},
            type: 'POST',
            success: function(res){
                $('#more_news').hide();
                $('.more_news').html(res);
            },
            error: function(){
                alert("error");
            }
        });
    });

    $('body').on('click', '.open-modal', function(){
        if (!$('body').hasClass('active-post-pop-up')) {
            $('body').addClass('active-post-pop-up');

            var post_id = $(this).data('id');
            $.ajax({
                url: "http://seolizer/wp-content/themes/seolizer/inc/post_popup.php",
                data: {post_id: post_id},
                type: 'POST',
                success: function(res){
                    $('#overlay').fadeIn(400, // снaчaлa плaвнo пoкaзывaем темную пoдлoжку
                        function(){
                            $('#post_modal').html(res);
                            $('#post_modal').fadeIn();
                        }
                    );
                },
                error: function(){
                    alert("error");
                }
            });
        }
    });

    $('body').on('click', '.close', function(e){
        if ($('body').hasClass('active-post-pop-up')) {
            $('#post_modal').fadeOut();
            $('#overlay').hide();
            $('body').removeClass('active-post-pop-up');
        }
    });

});
