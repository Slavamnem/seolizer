<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package seolizer
 */
global $redux_demo;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div class="wrapper">
	
		<header class="header">
				<div class="top_head">
					<div class="container">
						<div class="logo">
							<a href=""><?=$redux_demo['seolizer-logo']?></span></a>	
						</div>
						<div class="menu">
							<div class="hamburger_menu">
								<img src="<? echo get_template_directory_uri()."/img/burger.png"; ?>" alt="icon" />
							</div>
							<?php
								wp_nav_menu(array(
									'theme_location' => 'menu-1',
									'menu_id' => 'primary-menu',
									'container' => false,
									'menu_class' => 'menu_list', 
									
									'container_class' => '',
									'container_id' => '',
								));
							?>
							<!--<ul class="menu_list">
								<li class="menu_item"><a href="#">Услуги</a></li>
								<li class="menu_item"><a href="#">Портфолио</a></li>
								<li class="menu_item"><a href="#">Компания</a></li>
								<li class="menu_item"><a href="#">Контакты</a></li>
							</ul>-->

						</div>
						<div class="addres">
							<?=$redux_demo['seolizer-address']?>
						</div>

						<div class="contact">
								<a href="tel:<?=$redux_demo['seolizer-number-href']?>"><?=$redux_demo['seolizer-number-pretty']?></a>
								<br>
								<a href="mailto:<?=$redux_demo['seolizer-email']?>" class="email"><?=$redux_demo['seolizer-email']?></a>
						</div>

						<div class="wrap_btn">
							<a href="#" class="btn_callback eModal-1">
								<?=$redux_demo['seolizer-button-call']?>
							</a>
						</div>




					</div>
				</div>
				<div class="middle_head">
					<div class="container">
						<h1>
							<?=$redux_demo['seolizer-header-title']?>
							
						</h1>
						<div class="wrap_btn">
							<a href="" class="btn_consult"><?=$redux_demo['seolizer-button-consult']?></a>
							<a href="" class="btn_order"><?=$redux_demo['seolizer-button-order']?></a>
						</div>
					</div>
					<div class="absolut_btn">	
					</div>
				</div>
			</header>


<!--

-->
