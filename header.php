<!DOCTYPE html>
<html lang="pl">
<head>   
     <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<header class="main-header">
		<div class="container">
			<div class="main-header-inner d-flex align-items-center justify-content-between">
	            <div class="logo-sec">
	            	<?php
						if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
							$logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
							$alt_text = __('logo drow link do strony głównej', 'bibiloteka');
							echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="'. esc_attr( $alt_text ) .'"><img src="' . esc_url( $logo[0] ) . '" alt="' . esc_attr( $alt_text ) . '"></a>';
						} else {
							echo '<h1><a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a></h1>';
						}
					?>
	            </div>
				
	            <div class="site-navigation justify-content-center align-items-end">
					<div class="header-top-sec d-flex align-items-center">
						<?php
							$has_logo = false;
							for ( $i = 1; $i <= 4; $i++ ) {
								if ( get_theme_mod( 'social_logo_' . $i ) ) {
									$has_logo = true;
									break; // Stop checking as soon as we find one logo
								}
							}

							if ( $has_logo ) : ?>
								<div class="social-icon">
									<p><?php _e('Znajdź nas na:', 'bibiloteka') ?></p>
									<ul>
										<?php for ( $i = 1; $i <= 4; $i++ ) :
											$logo = get_theme_mod( 'social_logo_' . $i );
											$link = get_theme_mod( 'social_logo_link_' . $i );
											if ( $logo ) : ?>
												<li>
													<a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener">
														<img src="<?php echo esc_url( $logo ); ?>" alt="Social Logo <?php echo $i; ?>">
													</a>
												</li>
											<?php endif;
										endfor; ?>
									</ul>
								</div>
							<?php endif; ?>
						<div class="search-form-wrap">
							<p><?php _e( 'Szukaj na stronie:', 'bibiloteka' ); ?></p>
							<form class="search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
								<input class="form-control" type="search"  name="s" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_attr_e( 'Wpisz szukaną frazę', 'bibiloteka' ); ?>" aria-label="<?php esc_attr_e( 'Search', 'bibiloteka' ); ?>">
								<button class="btn-search" type="submit"><?php _e( 'Szukaj', 'bibiloteka' ); ?></button>
							</form>
						</div>
                       <?php if ( has_nav_menu( 'languagechange' ) ) : ?>
							<div class="language-btn">
								<?php
									wp_nav_menu(
										array(
											'theme_location' => 'languagechange',
											'container'      => '',
											'menu_class'     => 'menu-item-has-children',
										)
									);
								?>
							</div>
						<?php endif; ?>
						<div class="accessibility-icon">
							<a href="#">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/accessibility-icon.svg" alt="accessibility">
							</a>
						</div>
						<?php if ( get_theme_mod( 'header_logo' ) ) : ?>
						<div class="right-logo-sec">
							<a href="<?php echo esc_url( get_theme_mod( 'header_logo_link', '#' ) ); ?>">
								<div class="right-logo-inner">
									<img class="d-none d-xl-block" src="<?php echo esc_url( get_theme_mod( 'header_logo' ) ); ?>" alt="Logo">
									<img class="d-xl-none" src="<?php echo esc_url( get_theme_mod( 'header_mobile_logo' ) ); ?>" alt="logo">
								</div>
							</a>

					    </div>
						<?php endif; ?>
					</div>
	            	<div class="main-menu-wrap">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'primary',
									'container'      => false, // Remove the default <div>
									'menu_class'     => 'd-flex align-items-center nav-menu', // Apply classes to <ul>
								)
							);
						?>
					</div>
	            </div>
	            <div class="toggle-button menu-open">
	                <span class="line one"></span>
	                <span class="line two"></span>
	                <span class="line three"></span>
              	</div>
	            <div class="mobile-menu-wrap">
	            	<div class="mobile-menu-wrap-inner">
						<div class="logo-hamburger">
							<div class="logo-sec">
								<?php
									if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
										$logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
										$alt_text = __('logo drow link do strony głównej', 'bibiloteka');
										echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="'. esc_attr( $alt_text ) .'"><img src="' . esc_url( $logo[0] ) . '" alt="' . esc_attr( $alt_text ) . '"></a>';
									} else {
										echo '<h1><a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a></h1>';
									}
								?>
							</div>
							<div class="toggle-button menu-close">
								<span class="line one"></span>
								<span class="line two"></span>
								<span class="line three"></span>
							</div>
						</div>
						<div class="mobile-menu-content">
							<div class="search-form-wrap">
								<p><?php _e( 'Szukaj na stronie:', 'bibiloteka' ); ?></p>
								<form class="search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
									<input class="form-control" type="search"  name="s" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_attr_e( 'Wpisz szukaną frazę', 'bibiloteka' ); ?>" aria-label="<?php esc_attr_e( 'Search', 'bibiloteka' ); ?>">
									<button class="btn-search" type="submit"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/right-arrow.svg" alt="search icon"></button>
								</form>
							</div>
							<div class="mobile-menu">
								<?php
									wp_nav_menu(
										array(
											'theme_location' => 'primary',
											'container' => '',
											'menu_class' => '',
											
										)
									);
								?>
							</div>
							<?php
							$has_logo = false;
							for ( $i = 1; $i <= 4; $i++ ) {
								if ( get_theme_mod( 'social_logo_' . $i ) ) {
									$has_logo = true;
									break; // Stop checking as soon as we find one logo
								}
							}

							if ( $has_logo ) : ?>
								<div class="social-icon">
									<p><?php _e('Znajdź nas na:', 'bibiloteka') ?></p>
									<ul>
										<?php for ( $i = 1; $i <= 4; $i++ ) :
											$logo = get_theme_mod( 'social_logo_' . $i );
											$link = get_theme_mod( 'social_logo_link_' . $i );
											if ( $logo ) : ?>
												<li>
													<a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener">
														<img src="<?php echo esc_url( $logo ); ?>" alt="Social Logo <?php echo $i; ?>">
													</a>
												</li>
											<?php endif;
										endfor; ?>
									</ul>
								</div>
							<?php endif; ?>
							<div class="language-btn">
								<?php
									wp_nav_menu(
										array(
											'theme_location' => 'languagechange',
											'container'      => '',
											'menu_class'     => 'menu-item-has-children',
										)
									);
								?>
							</div>
						</div>
					</div>	
	            </div>
	        </div>
		</div>
	</header>
	
