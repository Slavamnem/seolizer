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
				<?php
				foreach($redux_demo['seolizer-about-us-slides'] as $slide): ?>
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
				<!--<div class="about_item">
					<div class="wrap_img">
						<img src="img/1.png" alt="img" />
					</div>
					<div class="wrap_text">
						<strong>Аудит сайта</strong>
						<p>
							Мы находим всё,  что мешает сайту расти. Проводим технический анализ, аудит ссылочной массы, оценку юзабилити - продающих качеств сайта, анализ сайтов конкурентов
						</p>
					</div>
				</div>
				<div class="about_item">
					<div class="wrap_img">
						<img src="img/2.png" alt="img" />
					</div>
					<div class="wrap_text">
						<strong>Исправление ошибок</strong>
						<p>
							Мы тестируем и исправляем ошибки и недоработки в работе каждой страницы и формы сайта; ускоряем загрузку, верстку и отображение сайта на адаптивной версии дизайна
						</p>
					</div>								
				</div>
				<div class="about_item">
					<div class="wrap_img">
						<img src="img/3.png" alt="img" />
					</div>
					<div class="wrap_text">
						<strong>Продвижение в TOP</strong>
						<p>
							Зная основные алгоритмы ранжирования сайтов в поисковых системах, наша команда выведет Ваш проект в ТОП, а это больше переходов и больше заказов для Вашего бизнеса
						</p>
					</div>
				</div>
				<div class="about_item">
					<div class="wrap_img">
						<img src="img/4.png" alt="img" />
					</div>
					<div class="wrap_text">
						<strong>Целевой трафик</strong>
						<p>
							Мы  привлекаем к вашему сайту внимание только потенциальных покупателей, то  есть на ваш сайт приходят именно те, кто может у вас что-то купить. Вы  не тратите деньги на привлечение случайных посетителей
						</p>
					</div>
				</div>-->
			</div>
		</div>
	</section>	
	<br><br><br><br><br><br><br>
	
</div>

<?php get_footer(); ?>