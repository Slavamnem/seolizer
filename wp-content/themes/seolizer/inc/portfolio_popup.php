<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

$portfolio_id = $_POST['portfolio_id'];
$content_post = get_post($portfolio_id);
$content = $content_post->post_content;

//$views = get_metadata("post", $portfolio_id, 'views', 1);
//update_post_meta( $portfolio_id, "views", $views + 1 );
?>

<div style="width:100%;" data-id="<?=$portfolio_id?>" class="slider_item">
    <div class="row">
        <h1 align="center">Просмотр портфолио<span class="close">Закрыть</span></h1>
    </div><br><br>
    <div class="modal-img wrap_img">
        <?php echo get_the_post_thumbnail($portfolio_id); ?>
    </div>
    <div class="wrap_text" style="width:100%;">
        <strong>
            <?php echo get_the_title($portfolio_id);?>
        </strong>
        <p>
            <?php echo $content;?>
        </p>
    </div>
    <div class="wrap_text">
        <a href="<?php echo get_metadata("post", $portfolio_id, 'website', 1) ?>" class="title_website">
            <?php echo get_metadata("post", $portfolio_id, 'website', 1) ?>
        </a>
        <dl>
            <dt>Тематика:</dt>
            <dd><?php echo get_metadata("post", $portfolio_id, 'theme', 1) ?></dd>
            <dt>Рост трафика:</dt>
            <dd><?php echo get_metadata("post", $portfolio_id, 'growth', 1) ?></dd>
            <dt>Срок продвижения:</dt>
            <dd><?php echo get_metadata("post", $portfolio_id, 'advance_term', 1) ?></dd>
            <dt>Посетители:</dt>
            <dd><?php echo get_metadata("post", $portfolio_id, 'visitors', 1) ?></dd>
        </dl>
    </div>
</div>