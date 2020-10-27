<?php if ( ! defined( 'ABSPATH' ) ) exit( 'No direct script access allowed' );
/**
 * Template "Tnstagram" for 8theme dashboard.
 *
 * @since   6.0.2
 * @version 1.0.5
 */

$instagram = new Instagram();
$api_data     = $instagram->get_api_data();
$api_settings = $instagram->get_api_settings();
$no_users_class = ' hidden';

?>

<div class="etheme-div etheme-social">
    <div class="et-col-7 etheme-instagram-connected">
        <h2 class="etheme-page-title etheme-page-title-type-2"><?php esc_html_e( 'Instagram Accounts', 'xstore' ) ?></h2>

        <p><?php echo sprintf( esc_html__('Instagram widget and Instagram WPBakery element use the special API that requires authentication to show your photos on any theme by 8theme. Authenticated requests need Instagram Access Token. You can get this by clicking the %1s Add account %2s button below.', 'xstore'), '<strong>', '</strong>'); ?></p><p><?php echo sprintf( esc_html__('After clicking, you will be prompted by Instagram to sign in your Instagram account and then you will be asked to authorize %1s 8themeapp %2s to access your Instagram photos.', 'xstore'), '<strong>', '</strong>' ); ?></p>
        <p class="et-message et-info">
			<?php esc_html_e('Generating a token creates a private token for your use only. We will not have access to your feed.', 'xstore'); ?>
        </p>

		<?php if ( isset($_GET['i_error']) && $_GET['i_error'] == 'business_permissions' ): ?>
            <p class="et-message et-error">
				<?php esc_html_e('Seems your user does not have correct permissions to display media of the business account.', 'xstore'); ?>
            </p>
		<?php endif ?>
        <p class="etheme-no-users et-message et-info<?php echo ( is_array($api_data) && count( $api_data ) ) ? esc_attr( $no_users_class ) : ''; ?>"><?php esc_html_e( 'You have not connected any account yet', 'xstore' ) ?></p>
        <a
                class="etheme-instagram-auto et-button et-button-green no-loader last-button etheme-call-popup et-facebook-corporate"
                href="#"
                data-personal="<?php echo esc_url($instagram->get_urls()->personal); ?>"
                data-business="<?php echo esc_url($instagram->get_urls()->business); ?>"
        >
            <span class="dashicons dashicons-instagram"></span>
			<?php esc_html_e('Add account', 'xstore'); ?>
        </a>
        <div class="etheme-instagram-manual-wrapper">
			<a class="etheme-instagram-manual et-button et-button-grey no-loader last-button" href="">
                <span class="dashicons dashicons-instagram"></span>
                <?php esc_html_e( 'Manually add account', 'xstore' ); ?>
            </a>
			<div class="etheme-instagram-manual-form hidden">
				<input id="etheme-manual-token" name="etheme-manual-token" type="text" placeholder="Enter a valid Instagram Access Token">
				<a class="etheme-manual-btn et-button no-loader et-facebook-corporate" href="">
                    <span class="dashicons dashicons-instagram"></span>
                    <?php esc_html_e( 'Connect', 'xstore' ) ?>
                </a>
				<a href="<?php echo esc_url( $instagram->api_url ); ?>" target="_blank"><?php esc_html_e( 'Do not have access token ?', 'xstore' ) ?></a>
				<p class="etheme-form-error hidden et-message et-error"><?php esc_html_e( 'Wrong token', 'xstore' ) ?></p>
				<p class="etheme-form-error-holder et-message et-error hidden"></p>
			</div>
		</div>

		<?php if ( is_array($api_data) && count( $api_data ) ) :
			foreach ( $api_data as $key => $value ) : ?>
				<?php $value = json_decode( $value, true ); ?>
				<?php
				$render_user_data = array();
				if ( isset($value['data']) ) {
					$render_user_data['class'] = 'old-api';
					$render_user_data['username'] = $value['data']['username'];
					$render_user_data['account_type'] = ( $value['data']['is_business'] ) ? 'BUSINESS (Legacy API)' : 'PERSONAL (Legacy API)';

				} else {
					$render_user_data['class'] = 'new-api';
					$render_user_data['username'] = $value['username'];
					$render_user_data['account_type'] = $value['account_type'] . ' (NEW API)';
					if ( isset( $value['connection_type'] ) ) {
						if ( $value['connection_type'] == 'PERSONAL' && $value['account_type'] == 'BUSINESS' ) {
							$render_user_data['account_type'] .= ' connected like personal';
						}
					}
				}
				?>

                <div class="etheme-user <?php echo esc_attr($render_user_data['class']); ?>">
                    <div class="user-info">
                        <div class="user-name"><b><?php esc_html_e( 'Username:', 'xstore' ); ?></b> <?php echo esc_html( $render_user_data['username'] ); ?></div>
                        <div class="user-account-type"><b><?php esc_html_e( 'Account type:', 'xstore' ); ?></b> <?php echo esc_html( $render_user_data['account_type'] ); ?>

                            <div class="et-tooltip">
                                <span class="dashicons dashicons-editor-help et-help tooltip"></span>
                                <span class="et-tooltip-content">
								Due to future Instagram platform changes (<a href="https://facebook.cmail20.com/t/j-l-ckhkjhy-thhhlitldt-j/">Instagram Graph API</a> and the <a href="https://facebook.cmail20.com/t/j-l-ckhkjhy-thhhlitldt-t/">Instagram Basic Display API</a>, 29 June 2020) Instagram accounts that use Instagram Legacy API will need to be reconnected in order for them to continue updating.
							</span>
                            </div>

                        </div>
                        <div class="user-token" style="word-break: break-all;" data-token="<?php echo esc_attr( $key ); ?>"><b><?php esc_html_e( 'Access token:', 'xstore' ) ?></b> <?php echo esc_html( $key ); ?></div>
                        <span class="user-remove red-color"><?php echo esc_html__('Delete', 'xstore'); ?></span>
                    </div>
                </div>
			<?php endforeach; ?>
		<?php else : ?>
			<?php $no_users_class = ''; ?>
		<?php endif; ?>
    </div>

    <div class="et-col-5 etheme-instagram-settings">
        <p>
            <label for="instagram_time"><?php esc_html_e('Check for new posts every', 'xstore'); ?></label>
        </p>
        <p class="etheme-instagram-refresh">
            <input id="instagram_time" name="instagram_time" type="text" value="<?php echo esc_attr( $api_settings['time'] ); ?>">
            <select name="instagram_time_type" id="instagram_time_type">
                <option value="min" <?php selected( $api_settings['time_type'], 'min' ); ?>><?php esc_html_e( 'mins', 'xstore' ); ?></option>
                <option value="hour" <?php selected( $api_settings['time_type'], 'hour' ); ?>><?php esc_html_e( 'hours', 'xstore' ); ?></option>
                <option value="day" <?php selected( $api_settings['time_type'], 'day' ); ?>><?php esc_html_e( 'days', 'xstore' ); ?></option>
            </select>
            <input class="etheme-instagram-save et-button no-loader" type="submit" value="save">
            <span class="hidden etheme-instagram-save-info info-success"><?php esc_html_e('Updated', 'xstore'); ?></span>
            <span class="hidden etheme-instagram-save-info info-error"><?php esc_html_e('Error, please try again later', 'xstore'); ?></span>
            <a class="etheme-instagram-reinit et-button no-loader et-button-grey" href="<?php echo admin_url('admin.php?page=et-panel-social&et_reinit_instagram=true'); ?>">
				<span class="et-loader">
	            <svg class="loader-circular" viewBox="25 25 50 50"><circle class="loader-path" cx="50" cy="50" r="12" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg>
	            </span>
                <span class="dashicons dashicons-image-rotate"></span>
		        <?php esc_html_e('Refresh instagram', 'xstore'); ?>
            </a>
        </p>
    </div>
</div>