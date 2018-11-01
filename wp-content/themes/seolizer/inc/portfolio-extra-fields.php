<?php
add_action('add_meta_boxes', 'portfolio_extra_fields', 1);

function portfolio_extra_fields() {
    add_meta_box( 'portfolio_box', 'Дополнительные поля', 'portfolio_fields_box_content', 'portfolio', 'normal', 'high'  );
}

function portfolio_fields_box_content($post){
    wp_nonce_field(plugin_basename(__FILE__), 'portfolio_fields_box_content_nonce'); ?>

    <label>
        Ссылка:<br>
        <input type="text" name="portfolio[website]" id="portfolio_website" value="<? echo get_metadata("post", $post->ID, 'website', 1); ?>"/>
    </label>
    <br>
    <label>
        Тематика:<br>
        <textarea name="portfolio[theme]" id="portfolio_theme"><? echo get_metadata("post", $post->ID, 'theme', 1); ?></textarea>
    </label>
    <br>
    <label>
        Рост трафика:<br>
        <input type="text" name="portfolio[growth]" id="portfolio_growth" value="<? echo get_metadata("post", $post->ID, 'growth', 1); ?>"/>
    </label>
    <br>
    <label>
        Срок продвижения:<br>
        <input type="text" name="portfolio[advance_term]" id="portfolio_advance_term" value="<? echo get_metadata("post", $post->ID, 'advance_term', 1); ?>"/>
    </label>
    <br>
    <label>
        Посетители:<br>
        <input type="text" name="portfolio[visitors]" id="portfolio_visitors" value="<? echo get_metadata("post", $post->ID, 'visitors', 1); ?>"/>
    </label>

<?php
}

add_action("save_post", "portfolio_fields_box_save");

function portfolio_fields_box_save($post_id){

    $_POST['portfolio'] = array_map( 'sanitize_text_field', (array)$_POST['portfolio'] ); // чистим все данные от пробелов по краям
    foreach( $_POST['portfolio'] as $key => $value ){
        if( empty($value) ){
            delete_post_meta( $post_id, $key ); // удаляем поле если значение пустое
            continue;
        }
        update_post_meta( $post_id, $key, $value ); // add_post_meta() работает автоматически
    }

}
?>