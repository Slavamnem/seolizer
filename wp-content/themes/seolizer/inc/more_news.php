<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

$args = array( 'post_type' => 'post', 'posts_per_page' => 1000, 'offset' => 4);
$loop = new \WP_Query( $args );
$counter = 1;
while ( $loop->have_posts() ) : $loop->the_post(); ?>

    <div data-id="<?=$post->ID?>" class="news_item open-modal <?php echo get_metadata("post", $post->ID, 'blocks_structure', 1) ?>">
        <div class="wrap_img">
            <?php the_post_thumbnail(); ?>
        </div>
        <div class="wrap_text">
            <strong>
                <?php the_title();?>
            </strong>
            <p>
                <?php the_content();?>
            </p>
            <div class="wrap_icon">
                <span class="date"><?php echo getDatesDiff(get_the_date(), date("d.m.Y")); ?></span>
                <span class="quantaty_view"><?php echo get_metadata("post", $post->ID, 'views', 1);?></span>
            </div>
        </div>
    </div>

<?php endwhile; ?>
