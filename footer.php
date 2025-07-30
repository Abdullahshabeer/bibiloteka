<section class="partners-block full-width-carousel">
    <div class="container">
        <div class="partners-b-inner">
            <div class="carousel-block">
                <div class="owl-carousel owl-theme partners-carousel">
                    <?php
                    if ( is_active_sidebar('footer-gallery') ) {
                        // Capture the gallery widget output
                        ob_start();
                        dynamic_sidebar('footer-gallery');
                        $gallery_content = ob_get_clean();

                        // Match <a> tags with <img> inside OR standalone <img>
                        if ( preg_match_all('/<a[^>]*>.*?<img[^>]+>.*?<\/a>|<img[^>]+>/i', $gallery_content, $matches) ) {
                            foreach ( $matches[0] as $item ) {
                                echo '<div class="item"><div class="partner-logo">' . $item . '</div></div>';
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>    
</section>

<footer>
	<div class="container">
		<div class="footer-top">
			<div class="row">
				<div class="col-xl-3 col-lg-6">
					<div class="footer-col">
						<div class="widget">
							<div class="footer-logo">
								<?php
									if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
										$logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
										$alt_text = __('logo drow link do strony głównej', 'drow');
										echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="'. esc_attr( $alt_text ) .'"><img src="' . esc_url( $logo[0] ) . '" alt="' . esc_attr( $alt_text ) . '"></a>';
									} else {
										echo '<h3>' . get_bloginfo( 'name' ) . '</h3>';
									}
								?>
							</div>
							<?php
								if (is_active_sidebar('footer-sidebar')) {
									dynamic_sidebar('footer-sidebar');
								}
							?>
							<?php
								if (is_active_sidebar('social-sidebar')) { 
									?>
									<div class="social-icon">
									  <?php dynamic_sidebar('social-sidebar'); ?>
								    </div>
									<?php
								}else{
                                  
							$has_logo = false;
							for ( $i = 1; $i <= 4; $i++ ) {
								if ( get_theme_mod( 'social_logo_' . $i ) ) {
									$has_logo = true;
									break; // Stop checking as soon as we find one logo
								}
							}

							if ( $has_logo ) : ?>
								<div class="social-icon">
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
							<?php endif; 
								}
							?>
						</div>
					</div>
				</div>
				<?php if (is_active_sidebar('footer-menu-first') ) : ?>
					<?php dynamic_sidebar('footer-menu-first'); ?>
				<?php endif; ?>
			</div>
		</div>
		<div class="footer-bottom">
			<div class="footer-bottom-logos desktop-logo">
				<?php
				// Get all logo URLs and links
				$logos = [
					['url' => get_theme_mod('first_logo'),  'link' => get_theme_mod('first_link_control')],
					['url' => get_theme_mod('second_logo'), 'link' => get_theme_mod('second_link_control')],
					['url' => get_theme_mod('Third_logo'),  'link' => get_theme_mod('Third_link_control')],
					['url' => get_theme_mod('Four_logo'),   'link' => get_theme_mod('Four_link_control')],
				];

				foreach ( $logos as $index => $logo ) {
					if ( ! empty( $logo['url'] ) ) {
						if ( $index == 3 ) { // Add border before the fourth logo
							echo '<div class="logo-bdr"></div>';
						}
						echo '<div class="bottom-logo">
								<a href="' . esc_url( $logo['link'] ) . '">
									<img src="' . esc_url( $logo['url'] ) . '" alt="">
								</a>
							</div>';
					}
				}
				?>
			</div>

		</div>
	</div>
</footer>
  <?php wp_footer(); ?>
  </body>
</html>
