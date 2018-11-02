$( document ).ready(function() {

    /* Show more posts */
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

    ///////////////////////////////////////////////////////////////////
    //////////////////////// Modals PopUp /////////////////////////////
    ///////////////////////////////////////////////////////////////////

    /* Post popup */
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


    /* Portfolio popup */
    $('body').on('click', '.open-portfolio-modal', function(e){
        e.preventDefault();
        if (!$('body').hasClass('active-post-pop-up')) {
            $('body').addClass('active-post-pop-up');

            var portfolio_id = $(this).data('id');
            $.ajax({
                url: "http://seolizer/wp-content/themes/seolizer/inc/portfolio_popup.php",
                data: {portfolio_id: portfolio_id},
                type: 'POST',
                success: function(res){
                    $('#overlay').fadeIn(400, // снaчaлa плaвнo пoкaзывaем темную пoдлoжку
                        function(){
                            $('#portfolio_modal').html(res);
                            $('#portfolio_modal').fadeIn();
                        }
                    );
                },
                error: function(){
                    alert("error");
                }
            });
        }
    });

    /* Call form */
    $('body').on('click', '.call-form-open', function() {
        $('#overlay').fadeIn(400, // снaчaлa плaвнo пoкaзывaем темную пoдлoжку
            function(){
                $('#call_modal').fadeIn();
            }
        );
    });

    // Close modal
    $('body').on('click', '.close', function(e){
        $('#post_modal').fadeOut();
        $('#portfolio_modal').fadeOut();
        $('#call_modal').hide();
        $('#overlay').hide();
        $('body').removeClass('active-post-pop-up');
    });

    ///////////////////////////////////////////////////////////////////
    //////////////////////// End modals PopUp /////////////////////////////
    ///////////////////////////////////////////////////////////////////

    // Scroll to the footer
    $('.absolut_btn').click(function(e){
        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
    });

    // Order form money scroll
    $('body').on('mousemove', ".irs-slider", function() {
        $('.block_cost').html($( ".irs-single" ).html());
    });
    $( ".block_cost" ).click(function() {
        alert( "block_cost." );
    });


});