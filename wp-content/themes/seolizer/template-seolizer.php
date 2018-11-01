<?php
/**
 * Template name: Main Page Template
 */
get_header();
global $redux_demo;
?>

<div class="content">

    <?php if(count($redux_demo['seolizer-about-us-slides']) > 0): ?>
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
    <?php endif; ?>

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
                    <?php endwhile; ?>

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

    <?php if(count($redux_demo['seolizer-why-seo-slides']) > 0): ?>
    <section class="why_seo light">
        <div class="container">
            <h2><?=$redux_demo['seolizer-why-seo-title'];?></h2>
            <p class="why">
                <?=$redux_demo['seolizer-why-seo-description'];?>
            </p>
            <div class="about_list">
                <?php foreach($redux_demo['seolizer-why-seo-slides'] as $slide): ?>
                    <div class="about_item">
                        <div class="wrap_img">
                            <img src="<?=$slide['image'];?>" alt="img" />
                        </div>
                        <div class="wrap_text">
                            <p>
                                <?=$slide['description'];?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if(count($redux_demo['seolizer-advantages-slides']) > 0): ?>
    <section class="advantages dark">
        <div class="container">
            <h2><?=$redux_demo['seolizer-advantages-title'];?></h2>
            <div class="about_list">
                <?php foreach($redux_demo['seolizer-advantages-slides'] as $slide): ?>
                    <div class="about_item">
                        <div class="wrap_img">
                            <img src="<?php echo $slide['image'];?>" alt="pic" />
                        </div>
                        <div class="wrap_text">
                            <strong><?php echo $slide['title'];?></strong>
                            <p>
                                <?php echo $slide['description'];?>
                                <?php //print_r($redux_demo); ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="steps light">
        <div class="container">
            <h2><?=$redux_demo['seolizer-steps-title'];?></h2>
            <p class="steps_descr">
                <?=$redux_demo['seolizer-steps-description'];?>
            </p>

            <?php $steps = $redux_demo['seolizer-steps-slides']; ?>

            <div class="steps_list">
                <div class="steps_column">
                    <?php for($i = 0; $i < count($steps); $i+=2): ?>
                        <div class="steps_item">
                            <div class="wrap_text">
                                <strong><?php echo $steps[$i]['title'];?></strong>
                                <p>
                                    <?php echo $steps[$i]['description'];?>
                                </p>
                            </div>
                            <span class="number"><? echo $i+1; ?></span>
                        </div>
                    <? endfor; ?>
                </div>
                <div class="steps_column center">
                    <img src="<?php echo $redux_demo['seolizer-steps-delimeter']['url'];?>" alt="pic" />
                </div>
                <div class="steps_column">
                    <?php for($i = 1; $i < count($steps); $i+=2): ?>
                        <div class="steps_item">
                            <span class="number"><? echo $i+1; ?></span>
                            <div class="wrap_text">
                                <strong><?php echo $steps[$i]['title'];?></strong>
                                <p>
                                    <?php echo $steps[$i]['description'];?>
                                </p>
                            </div>
                        </div>
                    <? endfor; ?>
                </div>
            </div>

            <div class="mob_steps_list">
                <?php for($i = 0; $i < count($steps); $i++): ?>
                    <div class="mob_steps_item">
                        <?php if($i%2 == 1): ?>
                            <span class="number"><? echo $i+1; ?></span>
                        <? endif; ?>
                        <div class="wrap_text">
                            <strong>Определение целей</strong>
                            <p>
                                В зависимости от выбранной цели будет формироваться свой план продвижения и свои методы формирования отчетов и анализа результатов раскрутки
                            </p>
                        </div>
                        <?php if($i%2 == 0): ?>
                            <span class="number"><? echo $i+1; ?></span>
                        <? endif; ?>
                    </div>
                <? endfor; ?>
            </div>
        </div>
    </section>

<!--    -->

    <section class="news light">
        <div class="container">
            <h2>Последнии новости SEO мира</h2>

            <div class="news_list">
                <?php $args = array( 'post_type' => 'post', 'posts_per_page' => 4);
                $loop = new WP_Query( $args );
                $counter = 1;
                while ( $loop->have_posts() ) : $loop->the_post(); ?>

                    <div class="news_item <?php echo get_metadata("post", $post->ID, 'blocks_structure', 1) ?>">
                        <div class="wrap_img">
                            <a href="">
                                <?php the_post_thumbnail(); ?>
                            </a>
                        </div>
                        <div class="wrap_text">
                            <strong>
                                <?php the_title();?>
                            </strong>
                            <p>
                                <?php the_content();?>
                            </p>
                            <div class="wrap_icon">
                                <span class="date"><?php echo getDatesDiff(get_the_date(), date("d.m.Y"), "days"); ?></span>
                                <span class="quantaty_view">180</span>
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>
            </div>

            <div class="wrap_btn">
                <a id="more_news">
                    Загрузить больше новостей
                </a>
            </div>

            <div class="news_list more_news"></div>
        </div>
    </section>

<!--    -->
    <section class="form_sect dark">
        <div class="container">
            <h2>У Вас есть вопросы?</h2>
            <p class="descr">
                Заполните форму и наш менеджер свяжется с Вами:
            </p>
            <?php echo do_shortcode('[contact-form-7 id="63" title="У Вас есть вопросы?" html_class="form_feedback"]');?>
<!--            <form action="" class="form_feedback">-->
<!--                <label for="">-->
<!--                    <input type="text" name="name" placeholder="Ваше имя*" required />-->
<!--                </label>-->
<!--                <label for="">-->
<!--                    <input type="tel" name="tel" placeholder="Ваш телефон*" required />-->
<!--                </label>-->
<!--                <label for="">-->
<!--                    <input type="text" name="email" placeholder="Ваш e-mail" />-->
<!--                </label>-->
<!--                <label class="btn_submit">-->
<!--                    <input type="submit" name="send" />-->
<!--                </label>-->
<!--            </form>-->

        </div>
    </section>

    <section class="google_map">
        <div id="map"></div>
        <div class="overlay_map"></div>
    </section>

<!--    <br><br><br><br><br><br><br><br><br><br><br><br><br><br>-->
	
</div>

<?php get_footer(); ?>