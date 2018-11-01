<?php
/**
 * Template name: Main Page Template
 */
get_header();
global $redux_demo;
?>

<div class="content">

	<section class="about_us light">
		<div class="container">
			<h2>Как мы заставляем ваш сайт продавать</h2>
			<div class="about_list">
				<?php foreach($redux_demo['seolizer-about-us-slides'] as $slide): ?>
					<div class="about_item">
						<div class="wrap_img">
							<img src="<?php echo $slide['image']; ?>" alt="img" />
						</div>
						<div class="wrap_text">
							<strong><?php echo $slide['title']; ?></strong>
							<p>
								<?php echo $slide['description']; ?>
							</p>
						</div>
					</div>
				<? endforeach; ?>
			</div>
		</div>
	</section>	


    <section class="slider_carousel dark">
        <div class="container">
            <h2>Портфолио</h2>

            <div class="slider_wrapper">
                <div class="slider_list">

                    <?php $args = array( 'post_type' => 'portfolio', 'posts_per_page' => 10);
                    $loop = new WP_Query( $args );
                    $counter = 1;
                    while ( $loop->have_posts() ) : $loop->the_post(); ?>

                        <div class="slider_item <?php echo $counter == 1? "active":"next"; ?>" id = "item<?=$counter?>" data-id='<?=$counter?>'>
                            <h3 class="title"><?php the_title(); ?></h3>
                            <?php the_content(); ?>
                            <div class="wrapper_descr">
                                <div class="wrap_img">
                                    <?php the_post_thumbnail(); ?>
                                </div>
                                <div class="wrap_text">
                                    <a href="" class="title_website">https://izobility.com/</a>
                                    <dl>
                                        <dt>Тематика:</dt>
                                        <dd><?php echo get_metadata("post", $post->ID, 'theme', 1) ?></dd>
                                        <dt>Рост трафика:</dt>
                                        <dd><?php echo get_metadata("post", $post->ID, 'growth', 1) ?></dd>
                                        <dt>Срок продвижения:</dt>
                                        <dd><?php echo get_metadata("post", $post->ID, 'advance_term', 1) ?></dd>
                                        <dt>Посетители:</dt>
                                        <dd><?php echo get_metadata("post", $post->ID, 'visitors', 1) ?></dd>
                                    </dl>
                                    <div class="wrap_btn">
                                        <a href="">Подробнее</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $counter++; ?>
                    <?php endwhile;  // End of the loop. ?>

                </div>
                <div class="prev_slide">
                    <img src="<? echo get_template_directory_uri()."/img/prev.png";?>" alt="pic" />
                </div>
                <div class="next_slide">
                    <img src="<? echo get_template_directory_uri()."/img/next.png";?>" alt="pic" />
                </div>
            </div>
        </div>
    </section>

    <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	
</div>

<?php get_footer(); ?>