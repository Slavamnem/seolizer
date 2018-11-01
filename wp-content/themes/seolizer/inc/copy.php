<?php
// подключаем функцию активации мета блока (my_extra_fields)
add_action('add_meta_boxes', 'my_extra_fields', 1);

function my_extra_fields() {
    add_meta_box( 'extra_fields', 'Дополнительные поля', 'extra_fields_box_func', 'post', 'normal', 'high'  );

    add_meta_box( 'extra_fields2', 'Дополнительные поля', 'extra_fields_box_portfolio_func', 'portfolio', 'normal', 'high'  );
}

function extra_fields_box_portfolio_func( $portfolio )
{ ?>

    <p>
        <label>
            <input type="text" name="extra[title2]" value="<?php echo get_metadata("portfolio", $portfolio->ID, 'title2', 1); ?>" style="width:50%" /> ? заголовок страницы (title)
        </label>
    </p>

    <p>Описание статьи (description):
        <textarea type="text" name="extra[description]" style="width:100%;height:50px;">
            <?php echo get_metadata("portfolio", $portfolio->ID, 'description', 1); ?>
        </textarea>
    </p>

    <p>Видимость поста: <?php $mark_v = get_post_meta($portfolio->ID, 'robotmeta2', 1); ?>
        <label>
            <input type="radio" name="extra[robotmeta2]" value="" <?php checked( $mark_v, '' ); ?> /> index,follow
        </label>
        <label>
            <input type="radio" name="extra[robotmeta2]" value="nofollow" <?php checked( $mark_v, 'nofollow' ); ?> /> nofollow
        </label>
        <label>
            <input type="radio" name="extra[robotmeta2]" value="noindex" <?php checked( $mark_v, 'noindex' ); ?> /> noindex
        </label>
        <label>
            <input type="radio" name="extra[robotmeta2]" value="noindex,nofollow" <?php checked( $mark_v, 'noindex,nofollow' ); ?> /> noindex,nofollow
        </label>
    </p>

    <p><select name="extra[select2]">
            <?php $sel_v = get_post_meta($portfolio->ID, 'select2', 1); ?>
            <option value="0">----</option>
            <option value="1" <?php selected( $sel_v, '1' )?> >Выбери меня</option>
            <option value="2" <?php selected( $sel_v, '2' )?> >Нет, меня</option>
            <option value="3" <?php selected( $sel_v, '3' )?> >Лучше меня</option>
        </select> ? выбор за вами</p>

    <input type="hidden" name="extra_fields_nonce2" value="<?php echo wp_create_nonce(__FILE__); ?>" />

    <?php
}

// код блока
function extra_fields_box_func( $post ){
    ?>

    <?php
}


// включаем обновление полей при сохранении
add_action( 'save_post', 'my_extra_fields_update', 0 );

## Сохраняем данные, при сохранении поста
function my_extra_fields_update( $post_id ){
    // базовая проверка
    if (
        empty( $_POST['extra'] )
        || ! wp_verify_nonce( $_POST['extra_fields_nonce'], __FILE__ )
        || wp_is_post_autosave( $post_id )
        || wp_is_post_revision( $post_id )
    )
        return false;

    // Все ОК! Теперь, нужно сохранить/удалить данные
    $_POST['extra'] = array_map( 'sanitize_text_field', $_POST['extra'] ); // чистим все данные от пробелов по краям
    foreach( $_POST['extra'] as $key => $value ){
//        if( empty($value) ){
//            delete_post_meta( $post_id, $key ); // удаляем поле если значение пустое
//            continue;
//        }

        update_post_meta( $post_id, $key, $value ); // add_post_meta() работает автоматически
    }

    return $post_id;
}
<?php
/**
 * Created by PhpStorm.
 * User: wsw-777-pc
 * Date: 01.11.2018
 * Time: 10:52
 */