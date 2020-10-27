<?php
/**
 * Template "Demos" for 8theme dashboard.
 *
 * @since   
 * @version 1.0.4
 */

$disable_next = false;

$classes = array();
$classes['et_step-reset']    = 'active';
$classes['et_step-child_theme'] = 'hidden';
$classes['et_navigate-next'] = '';
$classes['et_step-requirements'] = 'hidden';
$classes['et_step-engine'] = ( count($_POST['steps']) == 1 && in_array('engine', $_POST['steps']) ) ? '' : 'hidden';

?>
<div class="et_popup-import-content">
	<?php // step reset ?>
	<?php if ( in_array('reset', $_POST['steps']) ): ?>
		<div class="et_popup-step et_step-reset <?php echo esc_attr($classes['et_step-reset']); ?>">
			<br/><h3 class="et_step-title text-center"><?php echo esc_html__('Install', 'xstore') . ' ' . ucfirst( $_POST['version'] ) . ' ' . esc_html__('version', 'xstore'); ?></h3>
			<ul class="text-left">
				<li>1. <?php echo sprintf(esc_html__('It is recommended to run import on fresh WordPress installation (You can use %1sWordpress Database Reset%2s plugin).', 'xstore'), '<a href="https://wordpress.org/plugins/wordpress-database-reset/" target="_blank" rel="nofollow" style="color: #c62828;">', '</a>'); ?></li>
				<li>2. <?php echo esc_html__('Importing site does not delete any pages or posts. However, it can overwrite your existing content.', 'xstore'); ?></li>
				<li>3. <?php echo esc_html__('Copyrighted media will not be imported. Instead it will be replaced with placeholders.', 'xstore'); ?></li>
			</ul>
		</div>
	<?php endif; ?>

	<?php // step requirements ?>
	<?php if (in_array('requirements', $_POST['steps']) ): ?>
		<?php 
			$classes['et_step-reset'] = 'hidden'; 
			$system = new Etheme_System_Requirements();
			$system->system_test();
			$result = $system->result();
		?>
		<?php if ( ! $result ): ?>
			<div class="et_popup-step et_step-requirements <?php echo esc_attr($classes['et_step-requirements']); ?>">
				<br/><h3 class="et_step-title text-center"><?php echo esc_html__('System Requirements','xstore'); ?></h3>
				<?php $system->html(); ?>
				<p class="et-message et-error"><?php esc_html_e( 'Your system does not meet the requirements.', 'xstore' ); ?><p>
			</div>
		<?php endif ?>
	<?php endif ?>

	<?php // step child_theme ?>
	<?php if ( in_array('child_theme', $_POST['steps']) ): ?>
		<?php 
			$theme = get_option('xstore_has_child') ? wp_get_theme(get_option('xstore_has_child') )->Name : 'XStore Child';
			$template = get_template();
		?>
		<div class="et_popup-step et_step-child_theme text-left <?php echo esc_attr($classes['et_step-child_theme']); ?>">
			<br/>
			<h3 class="et_step-title text-center"><?php esc_html_e('Setup XStore Child Theme', 'xstore'); ?></h3>
			<p class="step-description">
				<?php esc_html_e('Using Child theme is highly recommended. It will allow the parent theme to receive updates without overwriting your source code changes.', 'xstore') ?>
			</p>
			<form id="et_create-child_theme-form" action="" method="POST">
				<div class="child-theme-input" style="margin-bottom: 20px;">
					 <label>
						<?php esc_html_e('Child Theme Name', 'xstore'); ?>
					</label>
				 	 <input type="text" name="theme_name" value="<?php echo esc_attr($theme); ?>">
			 	</div>
			 	<div class="child-theme-input" style="margin-bottom: 20px;">
					<label>
						<?php esc_html_e('Parent Theme Template', 'xstore'); ?>
					</label>
					<input type="text" name="theme_template" value="<?php echo esc_attr($template); ?>">
				</div>
				
				<div class="text-center">
					<p class="margin-bottom-10">
						<button type="submit" id="et_create-child_theme" class="et-button button-active et-button-arrow">
				        	<?php esc_html_e('Create & Use Child Theme', 'xstore'); ?>
				        	<svg class="arrow-icon" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 32 32">
					          <g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" stroke-miterlimit="10">
					            <circle class="arrow-icon--circle" cx="16" cy="16" r="15.12"></circle>
					            <path class="arrow-icon--arrow" d="M16.14 9.93L22.21 16l-6.07 6.07M8.23 16h13.98"></path>
					          </g>
					        </svg>
				        </button>
					</p>
					<span type="submit" id="et_skip-child_theme" class="et-button">
			        	<?php esc_html_e('Skip this step', 'xstore'); ?>
			        </span>
				</div>
			</form>
			<p class="et-success et-message hidden">
				<?php esc_html_e('Child Theme ', 'xstore'); ?>
				<strong class="new-theme-title"></strong> 
				<?php esc_html_e('created and activated! Folder is located in ', 'xstore'); ?>
				<strong class="new-theme-path"></strong>
			</p>
			<p class="et-error et-message hidden">
				<?php esc_html_e('Can not create or activate new child theme. Please contact our support.', 'xstore'); ?>
			</p>
		</div>
	<?php endif; ?>

	<?php // step engine ?>
	<?php if ( in_array('engine', $_POST['steps']) && $_POST['engine'] > 1 ): ?>
		<div class="et_popup-step et_step-engine <?php echo esc_attr($classes['et_step-engine']); ?>">
			<br/><h3 class="et_step-title text-center"><?php echo esc_html__('Preferred page builder', 'xstore'); ?></h3><br/>
			<input type="radio" id="wpb" name="engine" value="wpb" checked>
			<label class="engine-selector active" for="wpb">
				<svg width="50px" height="50px" viewBox="0 0 66 50" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <defs></defs>
                        <g id="Page-1" stroke="none" stroke-width="1" fill="#ffffff" fill-rule="evenodd">
                            <path d="M51.3446356,9.04135214 C46.8606356,8.68235214 44.9736356,9.78835214 42.8356356,10.0803521 C45.0046356,11.2153521 47.9606356,12.1793521 51.5436356,11.9703521 C48.2436356,13.2663521 42.8866356,12.8233521 39.1886356,10.5643521 C38.2256356,9.97535214 37.2136356,9.04535214 36.4556356,8.30235214 C33.4586356,5.58335214 31.2466356,0.401352144 21.6826356,0.0183521443 C9.68663559,-0.456647856 0.464635589,8.34735214 0.0156355886,19.6453521 C-0.435364411,30.9433521 8.92563559,40.4883521 20.9226356,40.9633521 C21.0806356,40.9713521 21.2386356,40.9693521 21.3946356,40.9693521 C24.5316356,40.7853521 28.6646356,39.5333521 31.7776356,37.6143521 C30.1426356,39.9343521 24.0316356,42.3893521 20.8506356,43.1673521 C21.1696356,45.6943521 22.5216356,46.8693521 23.6306356,47.6643521 C26.0896356,49.4243521 29.0086356,46.9343521 35.7406356,47.0583521 C39.4866356,47.1273521 43.3506356,48.0593521 46.4746356,49.8083521 L49.7806356,38.2683521 C58.1826356,38.3983521 65.1806356,32.2053521 65.4966356,24.2503521 C65.8176356,16.1623521 59.9106356,9.72335214 51.3446356,9.04135214 L51.3446356,9.04135214 Z" id="Fill-41" fill="#0473aa"></path>
                        </g>
                    </svg>
                <span class="engine-title">WPBakery</span>
			</label>
			<input type="radio" id="elementor" name="engine" value="elementor">
			<label class="engine-selector" for="elementor">
                <svg height="50px" width="50px" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="_x31_09-elementor"><g><path d="M462.999,26.001H49c-12.731,0-22.998,10.268-22.998,23v413.998c0,12.732,10.267,23,22.998,23    h413.999c12.732,0,22.999-10.268,22.999-23V49.001C485.998,36.269,475.731,26.001,462.999,26.001" style="fill:#D63362;"/><rect height="204.329" style="fill:#FFFFFF;" width="40.865" x="153.836" y="153.836"/><rect height="40.866" style="fill:#FFFFFF;" width="122.7" x="235.566" y="317.299"/><rect height="40.865" style="fill:#FFFFFF;" width="122.7" x="235.566" y="235.566"/><rect height="40.865" style="fill:#FFFFFF;" width="122.7" x="235.566" y="153.733"/></g></g><g id="Layer_1"/></svg>
                <span class="engine-title">Elementor</span>
            </label>
        </div>
	<?php endif; ?>

	<?php // step plugins ?>
	<?php if ( in_array('plugins', $_POST['steps']) ): ?>
		<?php 
			$classes['et_step-reset'] = 'hidden';
			$classes['et_navigate-next'] = 'hidden';
			$classes['et_step-requirements'] = 'hidden';
		    $plugins = new Plugins();
			$plugins = $plugins->get_popup_plugin_list($_POST['version']);
		 ?>
		<?php if ( count( $plugins ) ): ?>
			<div class="et_popup-step et_step-plugins hidden">
			<br/><h3 class="et_step-title text-center"><?php echo esc_html__('Required plugins', 'xstore'); ?></h3>
			<p class="margin-bottom-10"><?php echo esc_html__('This demo requires some plugins to be installed.', 'xstore'); ?></p>
			<ul class="et_popup-import-plugins with-scroll">
					<li class="flex justify-content-between align-items-center">
						<span class="flex align-items-center"><input class="all-plugins" type="checkbox" checked>ALL PLUGINS</span>
					</li>
				<?php foreach ($plugins as $key => $value): ?>
					<?php $li_class = ($value['slug'] == 'elementor') ? 'et-mb-remove' : ''; ?>
					<li class="et_popup-import-plugin flex justify-content-between align-items-center install-with-all selected-to-install move-right <?php echo esc_attr($li_class); ?>">
						<?php 
						$notify_class = ' orange-color';
						echo '<span class="flex align-items-center">';
						echo '<input class="plugin-setup" type="checkbox" checked>';
						if ( in_array($value['slug'], array('js_composer', 'et-core-plugin', 'elementor', 'woocommerce'))) {
							$disable_next = true;
							$notify_class = ' red-color';
						}
						echo esc_html($value['name']);
						echo '<span class="dashicons dashicons-warning dashicons-warning '.$notify_class.'"><span class="mt-mes">required</span></span>';
						echo '</span>'; ?>

                        <style>
                            .mt-mes{
                                display: none;
                            }
                            .dashicons-warning:hover .mt-mes, .dashicons-warning:hover .mt-mes{
                                display: inline-block;
                                position: absolute;
                                right: 95px;
                                top: 2px;
                                text-transform: capitalize;
                                border-radius: 3px;
                                background: #222;
                                color: #fff;
                                background: #222;
                                padding: 3px 5px;
                                white-space: nowrap;
                                font-size: 14px;
                                height: 16px;
                                line-height: 15px;
                                box-sizing: content-box;
                                box-shadow: 1px 1px 5px 0px rgba(0, 0, 0, 0.1);
                                font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
                            }
                        </style>
						<span 
							class="et_popup-import-plugin-btn" 
							data-slug="<?php echo esc_attr($value['slug']); ?>" 
							data-type="<?php echo esc_attr($value['btn_type']); ?>"
							style="cursor: pointer; text-decoration: underline; color: #0073aa;"
							>
							<?php echo esc_html($value['btn_text']); ?>
						</span>
					</li>
				<?php endforeach ?>
			</ul>
			<!-- <span class="et-button et-button-green install-selected-plugins hidden"></span> -->
			<span class="hidden et_plugin-nonce" data-plugin-nonce="<?php echo wp_create_nonce( 'envato_setup_nonce' ); ?>"></span>
			</div>
		<?php endif ?>
	<?php endif ?>

	<?php // step install ?>
	<?php if ( in_array('install', $_POST['steps']) ): ?>
		<?php 
			$versions  = etheme_get_demo_versions();
			$version   = $versions[$_POST['version']];
			$to_import = $version['to_import'];
	 	?>
		<div class="et_popup-step et_step-type text-left hidden">
			<br/><h3 class="et_step-title text-center"><?php echo esc_html__('Configuration Installer', 'xstore'); ?></h3>
			<form class="et_install-demo-form with-scroll" action="">
				<div class="et_recomended-setup">
					<input type="checkbox" id="et_all" name="et_all" value="et_all" checked>
					<label for="et_all"><?php echo esc_html__('FULL DEMO-SITE CONTENT', 'xstore'); ?></label>
				</div>
				<div class="et_manual-setup">
					<?php if ( isset( $to_import['pages'] ) && ! empty( $to_import['pages'] ) ): ?>
						<input type="checkbox" id="pages" name="pages" value="pages" checked>
						<label for="pages"><?php echo esc_html__('Pages', 'xstore'); ?></label>
						<br>
						<div class="et_manual-setup-page">
							<?php if ( isset( $to_import['widgets'] ) && ! empty( $to_import['widgets'] ) ): ?>
								<input type="checkbox" id="widgets" name="widgets" value="widgets" checked>
								<label for="widgets"><?php echo esc_html__('Widgets', 'xstore'); ?></label>
							<br>
							<?php endif; ?>
							<?php if ( isset( $to_import['home_page'] ) && ! empty( $to_import['home_page'] ) ): ?>
								<input type="checkbox" id="home_page" name="home_page" value="home_page" checked>
								<label for="home_page"><?php echo esc_html__('Home Page', 'xstore'); ?></label>
							<br>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<?php if ( isset( $to_import['posts'] ) && ! empty( $to_import['posts'] ) ): ?>
						<input type="checkbox" id="posts" name="posts" value="posts" checked>
						<label for="posts"><?php echo esc_html__('Posts', 'xstore'); ?></label>
						<br>
					<?php endif; ?>
					<?php if ( isset( $to_import['products'] ) && ! empty( $to_import['products'] ) ): ?>
						<input type="checkbox" id="products" name="products" value="products" checked>
						<label for="products"><?php echo esc_html__('Products', 'xstore'); ?></label>
						<br>
					<?php endif; ?>
					
					<?php if ( isset( $to_import['static-blocks'] ) && ! empty( $to_import['static-blocks'] ) ): ?>
						<input type="checkbox" id="static-blocks" name="static-blocks" value="static-blocks" checked>
						<label for="static-blocks"><?php echo esc_html__('Static Blocks', 'xstore'); ?></label>
						<br>
					<?php endif; ?>

					<?php if ( isset( $to_import['projects'] ) && ! empty( $to_import['projects'] ) ): ?>
						<input type="checkbox" id="projects" name="projects" value="projects" checked>
						<label for="projects"><?php echo esc_html__('Projects', 'xstore'); ?></label>
						<br>
					<?php endif; ?>
					<?php if ( isset( $to_import['testimonials'] ) && ! empty( $to_import['testimonials'] ) ): ?>
						<input type="checkbox" id="testimonials" name="testimonials" value="testimonials" checked>
						<label for="testimonials"><?php echo esc_html__('Testimonials', 'xstore'); ?></label>
						<br>
					<?php endif; ?>
					<?php if ( isset( $to_import['contact-forms'] ) && ! empty( $to_import['contact-forms'] ) ): ?>
						<input type="checkbox" id="contact-forms" name="contact-forms" value="contact-forms" checked>
						<label for="contact-forms"><?php echo esc_html__('Contact Forms', 'xstore'); ?></label>
						<br>
					<?php endif; ?>
					<?php if ( isset( $to_import['mailchimp'] ) && ! empty( $to_import['mailchimp'] ) ): ?>
						<input type="checkbox" id="mailchimp" name="mailchimp" value="mailchimp" checked>
						<label for="mailchimp"><?php echo esc_html__('Mailchimp Sign-up Forms', 'xstore'); ?></label>
						<br>
					<?php endif; ?>
					<?php if ( isset( $to_import['media'] ) && ! empty( $to_import['media'] ) ): ?>
						<input type="checkbox" id="media" name="media" value="media" checked>
						<label for="media"><?php echo esc_html__('Media', 'xstore'); ?></label>
						<br>
					<?php endif; ?>
					<?php if ( isset( $to_import['grid-builder'] ) && ! empty( $to_import['grid-builder'] ) ): ?>
						<input type="checkbox" id="grid-builder" name="grid-builder" value="grid-builder" checked>
						<label for="grid-builder"><?php echo esc_html__('Grid builder', 'xstore'); ?></label>
						<br class="grid-builder-br">
					<?php endif; ?>
					<?php if ( isset( $to_import['fonts'] ) && ! empty( $to_import['fonts'] ) ): ?>
						<input type="checkbox" id="fonts" name="fonts" value="fonts" checked>
						<label for="fonts"><?php echo esc_html__('Custom fonts', 'xstore'); ?></label>
						<br>
					<?php endif; ?>
				
					<?php if ( isset( $to_import['options'] ) && ! empty( $to_import['options'] ) ): ?>
						<input type="checkbox" id="options" name="options" value="options" checked>
						<label for="options"><?php echo esc_html__('Theme Options', 'xstore'); ?></label>
						<br>
					<?php endif; ?>
					<?php if ( isset( $to_import['products'] ) && ! empty( $to_import['products'] ) && isset( $to_import['variations'] ) && $to_import['variations']  ): ?>
						<input style="display: none;" type="checkbox" id="variation_taxonomy" name="variation_taxonomy" value="variation_taxonomy" checked>
						<label style="display: none;" for="variation_taxonomy"><?php echo esc_html__('Variations taxonomy', 'xstore'); ?></label>
						<input style="display: none;" type="checkbox" id="variations_trems" name="variations_trems" value="variations_trems" checked>
						<label style="display: none;" for="variations_trems"><?php echo esc_html__('Variations terms', 'xstore'); ?></label>
						<input style="display: none;" type="checkbox" id="variation_products" name="variation_products" value="variation_products" checked>
						<label style="display: none;" for="variation_products"><?php echo esc_html__('Products variations', 'xstore'); ?></label>
					<?php endif; ?>
					<?php if ( isset( $to_import['menu'] ) && ! empty( $to_import['menu'] ) ): ?>
						<input type="checkbox" id="menu" name="menu" value="menu" checked>
						<label for="menu"><?php echo esc_html__('Menu', 'xstore'); ?></label>
						<br>
					<?php endif; ?>
					<?php if ( isset( $to_import['elementor_globals'] ) && ! empty( $to_import['elementor_globals'] ) ): ?>
						<input class="et-mb-remove" type="checkbox" id="elementor_globals" name="elementor_globals" value="elementor_globals" checked>
						<label class="et-mb-remove" for="elementor_globals"><?php echo esc_html__('Elementor globals', 'xstore'); ?></label>
						<br class="elementor_globals-br">
					<?php endif; ?>
				</div>
				<div class="et_hidden-setup hidden">
					<?php if ( isset( $to_import['slider'] ) && ! empty( $to_import['slider'] ) ): ?>
						<input type="checkbox" id="slider" name="slider" value="slider" checked>
						<label for="slider"><?php echo esc_html__('Slider', 'xstore'); ?></label>
						<br>
					<?php endif; ?>
					<?php if ( isset( $to_import['multiple_headers'] ) && ! empty( $to_import['multiple_headers'] ) ): ?>
						<input type="checkbox" id="et_multiple_headers" name="et_multiple_headers" value="et_multiple_headers" checked>
						<label for="et_multiple_headers"><?php echo esc_html__('Multiple headers', 'xstore'); ?></label>
						<br>
					<?php endif; ?>
					<?php if ( isset( $to_import['multiple_conditions'] ) && ! empty( $to_import['multiple_conditions'] ) ): ?>
						<input type="checkbox" id="et_multiple_conditions" name="et_multiple_conditions" value="et_multiple_conditions" checked>
						<label for="et_multiple_conditions"><?php echo esc_html__('Headers conditions', 'xstore'); ?></label>
						<br>
					<?php endif; ?>
					<?php if ( isset( $to_import['multiple_single_product'] ) && ! empty( $to_import['multiple_single_product'] ) ): ?>
						<input type="checkbox" id="et_multiple_single_product" name="et_multiple_single_product" value="et_multiple_single_product" checked>
						<label for="et_multiple_single_product"><?php echo esc_html__('Multiple single product', 'xstore'); ?></label>
						<br>
					<?php endif; ?>
					<?php if ( isset( $to_import['multiple_single_product_conditions'] ) && ! empty( $to_import['multiple_single_product_conditions'] ) ): ?>
						<input type="checkbox" id="et_multiple_single_product_conditions" name="et_multiple_single_product_conditions" value="et_multiple_single_product_conditions" checked>
						<label for="et_multiple_single_product_conditions"><?php echo esc_html__('Single product conditions', 'xstore'); ?></label>
						<br>
					<?php endif; ?>
                    <input type="checkbox" id="version_info" name="version_info" value="version_info" checked>
                    <label for="version_info"><?php echo esc_html__('Version data', 'xstore'); ?></label>
                    <br>
				</div>
			</form>
		</div>
	<?php endif ?>
	
	<?php // step processing ?>
	<?php if ( in_array('processing', $_POST['steps']) ): ?>
		<div class="et_popup-step et_step-processing hidden">
			<br/><h3 class="et_step-title text-center"><?php echo esc_html__('Importing, please wait!', 'xstore'); ?></h3><br/>
			<progress class="et_progress" max="100" value="0"></progress><br/>
			<div class="et_progress-notice"></div>
		</div>
	<?php endif ?>
	
	<?php // step final ?>
	<?php if ( in_array('final', $_POST['steps']) ): ?>
		<div class="et_popup-step et_step-final hidden">
			<div class="et_all-success hidden">
				<br/><br/>
				<img src="<?php echo ETHEME_BASE_URI . ETHEME_CODE .'assets/images/'; ?>success-icon.png" alt="installed icon" style="margin-bottom: -7px;"><br/><br/>
				<h3 class="et_step-title text-center"><?php echo ucfirst( $_POST['version'] ) . ' ' . esc_html__('successfully installed!', 'xstore'); ?></h3><br/>
			</div>
			<div class="et_with-errors hidden">
				<br/><br/>
				<h3 class="et_step-title text-center"><?php echo ucfirst( $_POST['version'] ) . ' ' . esc_html__('Installed! But we have some errors:', 'xstore'); ?></h3><br/>
				<ul class="et_errors-list with-scroll"></ul>
				<p><?php esc_html_e('The most common errors happened by low server requirments, we strongly recommend to contact your host provider and check the necessary settings.', 'xstore'); ?></p>
			</div>

			<a class="et-button et-button-green no-loader" href="<?php echo home_url(); ?>" target="_blank"><?php esc_html_e( 'Preview Website', 'xstore' ); ?></a><br/><br/>
		</div>
	<?php endif ?>

	<div class="et_popup-import-navigation">
        <?php do_action('et_popup-import-navigation-start'); ?>
		<span class="et_navigate-next et-button et-button-arrow" <?php echo esc_attr($classes['et_navigate-next']); ?> data-text-install="<?php esc_attr_e('Install', 'xstore'); ?>" data-text-next="<?php esc_attr_e('Next', 'xstore'); ?>">
			<span class="text-holder"><?php echo esc_html__('Next', 'xstore'); ?></span>
			<svg class="arrow-icon" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 32 32">
	          <g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" stroke-miterlimit="10">
	            <circle class="arrow-icon--circle" cx="16" cy="16" r="15.12"></circle>
	            <path class="arrow-icon--arrow" d="M16.14 9.93L22.21 16l-6.07 6.07M8.23 16h13.98"></path>
	          </g>
	        </svg>
	    </span>
		<span class="et_navigate-install et-button et-button-arrow hidden" data-version="<?php echo esc_attr( $_POST['version'] ); ?>">
			<?php echo esc_html__('Install','xstore'); ?>
			<svg class="arrow-icon" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 32 32">
	          	<g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" stroke-miterlimit="10">
		            <circle class="arrow-icon--circle" cx="16" cy="16" r="15.12"></circle>
		            <path class="arrow-icon--arrow" d="M16.14 9.93L22.21 16l-6.07 6.07M8.23 16h13.98"></path>
	          	</g>
	        </svg>
		</span>
        <?php do_action('et_popup-import-navigation-end'); ?>
	</div>
</div>