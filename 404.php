<?php get_header(); ?><main class="main-wrap">
		<div class="container">
			<div class="error-page-wrap">
				<div class="image-404 text-center">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/404.svg" alt="<?php _e('error-404', 'bibiloteka') ?>">
				</div>
				<div class="error-page-content">
					<h1><?php _e('Strona nie została znaleziona', 'bibiloteka') ?></h1>
					<p><?php _e('Wróć na stonę główną<br> lub skorzystaj z wyszukiwarki na górze ekranu.', 'bibiloteka') ?></p>
					<div class="web-btn d-flex">
						<a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary"><?php _e('Strona główna', 'bibiloteka') ?></a>
					</div>
				</div>
			</div>	
		</div>
	</main>
	
<?php get_footer(); ?>

