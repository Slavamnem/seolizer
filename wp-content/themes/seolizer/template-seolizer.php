<?php
/**
 * Template name: Main Page Template
 */
get_header();
global $redux_demo;
?>

<div class="content">

    <?php if(count($redux_demo['seolizer-about-us-slides']) > 0): ?>
	<section class="about_us light" id="about">
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

    <div id="portfolio_modal" class="slider_item def_popup"></div>
    <section class="slider_carousel dark" id="portfolio">
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
                                    <a href="<?php echo get_metadata("post", $post->ID, 'website', 1) ?>" class="title_website"><?php echo get_metadata("post", $post->ID, 'website', 1) ?>/</a>
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
                                        <a href="#" data-id="<?=$post->ID?>" class="open-portfolio-modal">Подробнее</a>
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
    <section class="advantages dark" id="advantages">
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

    <section class="order dark" id="order">
        <div class="container">
            <h2>Заказать расчёт</h2>
            <p class="order_descr">Чтобы оценить стоимость работ, заполните форму ниже:</p>
            <?php echo do_shortcode('[contact-form-7 id="81" title="Заказать расчёт" html_class="order_form"]');?>
        </div>
    </section>


    <section class="news light">
        <div class="container">
            <h2>Последние новости SEO мира</h2>

            <div id="post_modal" class="news_list def_popup"></div>
            <div id="overlay"></div>
            <div class="news_list">
                <?php $args = array( 'post_type' => 'post', 'posts_per_page' => 4);
                $loop = new WP_Query( $args );
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
            </div>

            <div class="wrap_btn">
                <a id="more_news">
                    Загрузить больше новостей
                </a>
            </div>

            <div class="news_list more_news"></div>
        </div>
    </section>

    <section class="form_sect dark" id="consult_form">
        <div class="container">
            <h2>У Вас есть вопросы?</h2>
            <p class="descr">
                Заполните форму и наш менеджер свяжется с Вами:
            </p>
            <?php echo do_shortcode('[contact-form-7 id="63" title="У Вас есть вопросы?" html_class="form_feedback"]');?>
        </div>
    </section>


    <section class="google_map">
        <div id="map"></div>
        <div class="overlay_map"></div>
    </section>

    <div id="call_modal" class="call_modal" style="padding:0px">
        <section class="form_sect dark" style="padding:0px; height:300px;">
            <?php echo do_shortcode('[contact-form-7 id="58" title="Обратный звонок"]');?>
        </section>
    </div>
	
</div>

<?php get_footer(); ?>