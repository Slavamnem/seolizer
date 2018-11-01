$( document ).ready(function() {

    $('#more_news').click(function(){
        //alert("more!!!");

        //var sort_type = $('.sort_workers_select').val();
        $.ajax({
            url: "http://seolizer/wp-content/themes/seolizer/inc/more_news.php",
            data: {sort_type: "1"},
            type: 'POST',
            success: function(res){
                $('#more_news').hide();
                //alert(res);
                $('.more_news').html(res);
                //res = jQuery.parseJSON(res);
                //$('.all_workers').html(res[0]);
            },
            error: function(){
                alert("error");
            }
        });

    });

});
