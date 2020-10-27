<?php  
	/**
	 * The template created for displaying blog page options 
	 *
	 * @version 0.0.1
	 * @since 6.0.0
	 */
	
	// section blog-blog_page
	Kirki::add_section( 'blog-blog_page', array(
	    'title'          => esc_html__( 'Blog Layout', 'xstore' ),
	    'panel' => 'blog',
	    'icon' => 'dashicons-schedule'
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'radio-image',
			'settings'    => 'blog_layout',
			'label'       => esc_html__( 'Blog Layout', 'xstore' ),
			'description' => esc_html__( 'Choose the type of the layout for the blog page.', 'xstore' ),
			'section'     => 'blog-blog_page',
			'default'     => 'default',
			'choices'     => $blog_layout,
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'select',
			'settings'    => 'blog_columns',
			'label'       => esc_html__( 'Columns', 'xstore' ),
			'description' => esc_html__( 'Choose the number of columns for the posts at the blog page.', 'xstore' ),
			'section'     => 'blog-blog_page',
			'default'     => 3,
			'choices'     => array(
				2 => '2',
                3 => '3',
                4 => '4',
			),
			'active_callback' => array(
				array(
					'setting'  => 'blog_layout',
					'operator' => 'in',
					'value'    => array( 'grid', 'grid2' ),
				),
			)
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'toggle',
			'settings'    => 'blog_full_width',
			'label'       => esc_html__( 'Full width', 'xstore' ),
			'description' => esc_html__( 'Turn on to stretch blog page container.', 'xstore' ),
			'section'     => 'blog-blog_page',
			'default'     => 0,
			'active_callback' => array(
				array(
					'setting'  => 'blog_layout',
					'operator' => 'in',
					'value'    => array( 'grid', 'grid2' ),
				),
			)
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'toggle',
			'settings'    => 'blog_masonry',
			'label'       => esc_html__( 'Masonry', 'xstore' ),
			'description' => esc_html__( 'Turn on placing posts in optimal position based on available vertical space.', 'xstore' ),
			'section'     => 'blog-blog_page',
			'default'     => 1,
			'active_callback' => array(
				array(
					'setting'  => 'blog_layout',
					'operator' => 'in',
					'value'    => array( 'grid', 'grid2' ),
				),
			)
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'select',
			'settings'    => 'blog_page_banner_pos',
			'label'       => esc_html__( 'Blog Page Banner position', 'xstore' ),
			'description' => esc_html__('Controls the position of the blog page banner.', 'xstore'),
			'section'     => 'blog-blog_page',
			'default'     => 1,
			'choices'     => array(
				1 => esc_html__( 'At the top of the page', 'xstore' ),
                2 => esc_html__( 'At the bottom of the page', 'xstore' ),
                3 => esc_html__( 'Above all the blog content', 'xstore' ),
                4 => esc_html__( 'Above all the blog content (full-width)', 'xstore' ),
                0 => esc_html__( 'Disable', 'xstore' ),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'editor',
			'settings'    => 'blog_page_banner',
			'label'       => esc_html__( 'Blog Page Banner content', 'xstore' ),
			'description' => esc_html__( 'This is an editor control.', 'xstore' ),
			'section'     => 'blog-blog_page',
			'default'     => '',
			'active_callback' => array(
				array(
					'setting'  => 'blog_page_banner_pos',
					'operator' => '!=',
					'value'    => 0,
				),
			)
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'radio-image',
			'settings'    => 'blog_sidebar',
			'label'       => esc_html__( 'Sidebar position', 'xstore' ),
			'description' => esc_html__( 'Choose the position of the sidebar for the blog page, posts and simple pages. Every page has also an individual option to change the position of the sidebar.', 'xstore' ),
			'section'     => 'blog-blog_page',
			'default'     => 'right',
			'choices'     => $sidebars,
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'toggle',
			'settings'    => 'only_blog_sidebar',
			'label'       => esc_html__( 'Show sidebar only on blog page', 'xstore' ),
			'description' => esc_html__( 'Turn on to show the sidebar on blog page only and keep it disabled for the simple pages.', 'xstore' ),
			'section'     => 'blog-blog_page',
			'default'     => 0,
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'toggle',
			'settings'    => 'sticky_sidebar',
			'label'       => esc_html__( 'Enable sticky sidebar', 'xstore' ),
			'description' => esc_html__( 'Turn on to make the sidebar permanently visible while scrolling at the blog page.', 'xstore' ),
			'section'     => 'blog-blog_page',
			'default'     => 0,
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'select',
			'settings'    => 'blog_sidebar_for_mobile',
			'label'       => esc_html__( 'Sidebar position for mobile', 'xstore' ),
			'section'     => 'blog-blog_page',
			'default'     => 'bottom',
			'choices'     => array(
				'top' => esc_html__( 'Top', 'xstore' ),
                'bottom' => esc_html__( 'Bottom', 'xstore' ),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'select',
			'settings'    => 'blog_hover',
			'label'       => esc_html__( 'Blog image hover', 'xstore' ),
			'description' => esc_html__( 'Choose the design type for the image at the blog page.', 'xstore' ),
			'section'     => 'blog-blog_page',
			'default'     => 'zoom',
			'choices'     => array(
				'zoom' => esc_html__( 'Default', 'xstore' ),
                'default' => esc_html__( 'Mask hover', 'xstore' ),
                'animated' => esc_html__( 'Animated', 'xstore' ),
                'none' => esc_html__( 'None', 'xstore' ),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'toggle',
			'settings'    => 'blog_byline',
			'label'       => esc_html__( 'Show "byline" on the blog', 'xstore' ),
			'description' => esc_html__( 'Turn on to show the date of post creation, the name of the writer, number of comments and views.', 'xstore' ),
			'section'     => 'blog-blog_page',
			'default'     => 1,
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'toggle',
			'settings'    => 'blog_categories',
			'label'       => esc_html__( 'Show "category" label on posts', 'xstore' ),
			'section'     => 'blog-blog_page',
			'default'     => 1,
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'slider',
			'settings'    => 'excerpt_length',
			'label'       => esc_html__( 'Excerpt length (words)', 'xstore' ),
			'description' => esc_html__( 'Controls the number of words in the post summary with a link to the whole entry. Important: Does not work for post content created using WPBakery Page builder.', 'xstore' ),
			'section'     => 'blog-blog_page',
			'default'     => 25,
			'choices'     => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'slider',
			'settings'    => 'excerpt_length_sliders',
			'label'       => esc_html__( 'Excerpt length for posts sliders (words)', 'xstore' ),
			'description' => esc_html__( 'Controls the number of words in the post summary with a link to the whole entry. Important: Does not work for post content created using WPBakery Page builder.', 'xstore' ),
			'section'     => 'blog-blog_page',
			'default'     => 25,
			'choices'     => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'     => 'text',
			'settings' => 'excerpt_words',
			'label'    => esc_html__( 'Excerpt symbols', 'xstore' ),
			'description' => esc_html__( 'Add a symbol that you want to display at the end of the post excerpt.', 'xstore' ),
			'section'  => 'blog-blog_page',
			'default'  => '...',
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'select',
			'settings'    => 'read_more',
			'label'       => esc_html__( 'Continue reading type', 'xstore' ),
			'description' => esc_html__( 'Choose the design type of the continue reading text.', 'xstore'),
			'section'     => 'blog-blog_page',
			'default'     => 'link',
			'choices'     => array(
				'link' => esc_html__('Link', 'xstore' ),
                'btn' => esc_html__('Button', 'xstore' ),
                'off' => esc_html__('Disable', 'xstore' ),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'toggle',
			'settings'    => 'views_counter',
			'label'       => esc_html__( 'Enable views counter', 'xstore' ),
			'description' => esc_html__( 'Turn on to enable the post views counter.', 'xstore' ),
			'section'     => 'blog-blog_page',
			'default'     => 1,
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'select',
			'settings'    => 'blog_navigation_type',
			'label'       => esc_html__( 'Navigation type', 'xstore' ),
			'description' => esc_html__( 'Choose the type of the navigation at the blog page.', 'xstore' ),
			'section'     => 'blog-blog_page',
			'default'     => 'pagination',
			'choices'     => array(
				'pagination' => esc_html__( 'Pagination', 'xstore' ),
                'button' => esc_html__( 'More Button', 'xstore' ),
                'lazy' => esc_html__( 'Lazy Loading', 'xstore' ),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'select',
			'settings'    => 'blog_pagination_align',
			'label'       => esc_html__( 'Pagination align', 'xstore' ),
			'description' => esc_html__( 'Choose the alignment of the pagination.', 'xstore' ),
			'section'     => 'blog-blog_page',
			'default'     => 'right',
			'choices'     => array(
				'left' => esc_html__( 'Left', 'xstore' ),
                'center' => esc_html__( 'Center', 'xstore' ),
                'right' => esc_html__( 'Right', 'xstore' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'blog_navigation_type',
					'operator' => '==',
					'value'    => 'pagination',
				),
			)
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'toggle',
			'settings'    => 'blog_pagination_prev_next',
			'label'       => esc_html__( 'Enable prev/next pagination links', 'xstore' ),
			'description' => esc_html__( 'Turn on to enable the previous and next links.', 'xstore' ),
			'section'     => 'blog-blog_page',
			'default'     => 0,
			'active_callback' => array(
				array(
					'setting'  => 'blog_navigation_type',
					'operator' => '==',
					'value'    => 'pagination',
				),
			)
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'     => 'text',
			'settings' => 'blog_images_size',
			'label'    => esc_html__( 'Image sizes for blog', 'xstore' ),
			'description' => esc_html__( 'Controls the size of the post featured image at the blog page. Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme. Alternatively enter size in pixels. Example: 200x100 (Width x Height).', 'xstore' ),
			'section'  => 'blog-blog_page',
			'default'  => 'large',
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'     => 'text',
			'settings' => 'blog_related_images_size',
			'label'    => esc_html__( 'Image sizes for related articles', 'xstore' ),
			'description' => esc_html__( 'Controls the size of the featured image of the related posts at the single post page. Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme. Alternatively enter size in pixels. Example: 200x100 (Width x Height).', 'xstore' ),
			'section'  => 'blog-blog_page',
			'default'  => 'medium',
		) );
		
?>