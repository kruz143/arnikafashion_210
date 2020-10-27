<?php  
	/**
	 * The template created for displaying mail chimp api options 
	 *
	 * @version 0.0.1
	 * @since 6.0.0
	 */
	// section general-mail-chimp
	Kirki::add_section( 'general-mail-chimp', array(
		'title'     => esc_html__( 'Mail Chimp API', 'xstore' ),
		'icon' 		=> 'dashicons-email-alt',
		'priority'  => $priorities['mail-chimp']
	) );

	Kirki::add_field( 'et_kirki_options', array(
		'type'     => 'text',
		'settings' => 'mail_chimp_api',
		'label'    => esc_html__( 'Mail Chimp API Key', 'xstore' ),
		'section'  => 'general-mail-chimp',
		'default'  => '',
	) );

?>