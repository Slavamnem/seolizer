<?php
add_action('add_meta_boxes', 'post_extra_fields', 1);

function post_extra_fields() {
    add_meta_box( 'post_box', 'Дополнительные поля', 'post_fields_box_content', 'post', 'normal', 'high'  );
}

function post_fields_box_content($post){
    wp_nonce_field(plugin_basename(__FILE__), 'post_fields_box_content_nonce'); ?>

    <label>
        Расположение блоков:<br>
        <? $blocks_structure = get_metadata("post", $post->ID, 'blocks_structure', 1); ?>
        <select name="post[blocks_structure]" id="blocks_structure">
            <option value="" <?php if(!$blocks_structure){ echo "selected"; }?>>В один ряд</option>
            <option value="column" <?php if($blocks_structure == "column"){ echo "selected"; }?>>В два ряда</option>
        </select>
    </label>
    <br><br>
    <label>
        Просмотры:<br>
        <p><? echo get_metadata("post", $post->ID, 'views', 1); ?></p>
    </label>

    <?php
}

add_action("save_post", "post_fields_box_save");

function post_fields_box_save($post_id){

    $_POST['post'] = array_map( 'sanitize_text_field', (array)$_POST['post'] );
    foreach( $_POST['post'] as $key => $value ){
        if( empty($value) ){
            delete_post_meta( $post_id, $key );
            continue;
        }
        update_post_meta( $post_id, $key, $value );
    }

}
?>