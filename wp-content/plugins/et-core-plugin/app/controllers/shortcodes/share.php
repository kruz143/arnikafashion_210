<?php
namespace ETC\App\Controllers\Shortcodes;

use ETC\App\Controllers\Shortcodes;

/**
 * Share shortcode.
 *
 * @since      1.4.4
 * @package    ETC
 * @subpackage ETC/Controllers/Shortcodes
 */
class Share extends Shortcodes {

	function hooks() {}

	public static function share_shortcode( $atts, $content = null ) {

		$socials = function_exists('etheme_get_option') ? etheme_get_option('socials') : array();

		if ( ! is_array( $socials ) || count( $socials ) < 1 ) {
			return;
		}

		extract(shortcode_atts(array(
			'title'  => '',
			'text' => '',
			'tooltip' => 1,
			'twitter' => in_array( 'share_twitter', $socials ),
			'facebook' =>  in_array( 'share_facebook', $socials ),
			'vk' =>  in_array( 'share_vk', $socials ),
			'pinterest' =>  in_array( 'share_pinterest', $socials ),
			'mail' =>  in_array( 'share_mail', $socials ),
			'linkedin' =>  in_array( 'share_linkedin', $socials ),
			'whatsapp' =>  in_array( 'share_whatsapp', $socials ),
			'skype' =>  in_array( 'share_skype', $socials ),
			'copy_click' => etheme_get_option('socials_copy_to_clipboard'),
			'class' => ''
		), $atts));

		global $post;
		
		if(!isset($post->ID)) return;
		
		$html = '';
		$permalink = get_permalink($post->ID);
		$tooltip_class = '';
		if($tooltip) {
			$tooltip_class = 'title-toolip';
		}
		if ( $copy_click )
			$tooltip_class .= ' copy-to-clipboard';
		$image =  wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'small' );
		if ( isset($image[0]) ){
			$image = $image[0];
		} else {
			$image = '';
		}
		$post_title = rawurlencode(get_the_title($post->ID));
		$post_title = ( ! empty( $text ) ) ? $text : $post_title;
		if($title) $html .= '<span class="share-title">'.$title.'</span>';
		$html .= '
		<ul class="menu-social-icons '.$class.'">
		';
		if($twitter == 1) {
			$html .= '
			<li>
			<a href="https://twitter.com/share?url='.$permalink.'&text='.$post_title.'" class="'.$tooltip_class.'" title="'.__('Twitter', 'xstore-core').'" target="_blank" rel="noopener">
			<i class="et-icon et-twitter"></i>
			</a>
			</li>
			';
		}

		if($facebook == 1) {
			$html .= '
			<li>
			<a href="https://www.facebook.com/sharer.php?u='.$permalink.'&amp;images='.$image.'" class="'.$tooltip_class.'" title="'.__('Facebook', 'xstore-core').'" target="_blank" rel="noopener">
			<i class="et-icon et-facebook"></i>
			</a>
			</li>
			';
		}

		if($vk == 1) {
			$html .= '
			<li>
			<a href="https://vk.com/share.php?url='.$permalink.'&image='.$image.'?&title='.$post_title.'" class="'.$tooltip_class.'" title="'.__('VK', 'xstore-core').'" target="_blank" rel="noopener">
			<i class="et-icon et-vk"></i>
			</a>
			</li>
			';
		}

		if($pinterest == 1) {
			$html .= '
			<li>
			<a href="https://pinterest.com/pin/create/button/?url='.$permalink.'&amp;media='.$image.'&amp;description='.$post_title.'" class="'.$tooltip_class.'" title="'.__('Pinterest', 'xstore-core').'" target="_blank" rel="noopener">
			<i class="et-icon et-pinterest"></i>
			</a>
			</li>
			';
		}

		if($mail == 1) {
			$html .= '
			<li>
			<a href="mailto:enteryour@addresshere.com?subject='.$post_title.'&amp;body='. __('Check%20this%20out:%20', 'xstore-core' ) .$permalink.'" class="'.$tooltip_class.'" title="'.__('Mail to friend', 'xstore-core').'" target="_blank" rel="noopener">
			<i class="et-icon et-message"></i>
			</a>
			</li>
			';
		}

		if($linkedin == 1) {
			$html .= '
			<li>
			<a href="https://www.linkedin.com/shareArticle?mini=true&url='.$permalink.'&title='.$text.'" class="'.$tooltip_class.'" title="'.__('linkedin', 'xstore-core').'" target="_blank" rel="noopener">
			<i class="et-icon et-linkedin"></i>
			</a>
			</li>
			';
		}

		if($whatsapp == 1) {
			$html .= '
			<li>
			<a href="whatsapp://send?text='.$permalink.'" class="'.$tooltip_class.'" title="'.__('whatsapp', 'xstore-core').'" target="_blank" rel="noopener">
			<i class="et-icon et-whatsapp"></i>
			</a>
			</li>
			';
		}

		if($skype == 1) {
			$html .= '
			<li>
			<a href="https://web.skype.com/share?url='.$permalink.'" title="'.__('skype', 'xstore-core').'" target="_blank" rel="noopener">
			<i class="et-icon et-skype"></i>
			</a>
			</li>
			';
		}

		$html .= '
		</ul>
		';
		return $html;
	}
}