<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package seolizer
 */
global $redux_demo;
?>
			</div>
			<footer class="footer" id="footer">
				<div class="container">
					<div class="footer_top">
						<div class="menu">
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
							<a href="#" class="btn_callback call-form-open">
								<?=$redux_demo['seolizer-button-call']?>
							</a>
						</div>
						<div class="logo">
							<a href="">
								<?=$redux_demo['seolizer-logo']?>
							</a>
						</div>
					</div>
					<div class="footer_bottom">
						<span>2009—2017 seolizer.ru. Продвижение сайтов</span>
					</div>
				</div>
			</footer>
		</div>

		<script type="text/javascript" src="js/app.min.js"></script>
		<script async="" defer="" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBiwbJpXgwDY74WuO4ixsOJl5hVcPESFA8&amp;callback=initMap" type="text/javascript">
			
		</script>

		<script>
			function initMap() {
				var myLatLng = {lat: 55.763401, lng: 37.547236};

				var map = new google.maps.Map(document.getElementById('map'), {
					zoom: 12,
					center: myLatLng,
					scrollwheel: false
				});

				var marker = new google.maps.Marker({
					position: {lat: 55.763401, lng: 37.547236},
					map: map,
					title: 'ул. 2-ая Черногрязская д. 7 к.2',
					icon: {
						url: "img/marker.png",
						scaledSize: new google.maps.Size(30, 42)
					}
				});
			}	
		</script>
		<?php wp_footer(); ?>
	</body>
</html>



