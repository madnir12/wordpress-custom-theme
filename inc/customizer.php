<?php    
/**
 *psyclone-lite Theme Customizer
 *
 * @package Psyclone Lite
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function psyclone_lite_customize_register( $wp_customize ) {	
	
	function psyclone_lite_sanitize_dropdown_pages( $page_id, $setting ) {
	  // Ensure $input is an absolute integer.
	  $page_id = absint( $page_id );	
	  // If $page_id is an ID of a published page, return it; otherwise, return the default.
	  return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
	}

	function psyclone_lite_sanitize_checkbox( $checked ) {
		// Boolean check.
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	} 
	
	function psyclone_lite_sanitize_phone_number( $phone ) {
		// sanitize phone
		return preg_replace( '/[^\d+]/', '', $phone );
	} 
	
	
	function psyclone_lite_sanitize_excerptrange( $number, $setting ) {	
		// Ensure input is an absolute integer.
		$number = absint( $number );	
		// Get the input attributes associated with the setting.
		$atts = $setting->manager->get_control( $setting->id )->input_attrs;	
		// Get minimum number in the range.
		$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );	
		// Get maximum number in the range.
		$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );	
		// Get step.
		$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );	
		// If the number is within the valid range, return it; otherwise, return the default
		return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
	}

	function psyclone_lite_sanitize_number_absint( $number, $setting ) {
		// Ensure $number is an absolute integer (whole number, zero or greater).
		$number = absint( $number );		
		// If the input is an absolute integer, return it; otherwise, return the default
		return ( $number ? $number : $setting->default );
	}
	
	// Ensure is an absolute integer
	function psyclone_lite_sanitize_choices( $input, $setting ) {
		global $wp_customize; 
		$control = $wp_customize->get_control( $setting->id ); 
		if ( array_key_exists( $input, $control->choices ) ) {
			return $input;
		} else {
			return $setting->default;
		}
	}
	
		
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.logo h1 a',
		'render_callback' => 'psyclone_lite_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.logo p',
		'render_callback' => 'psyclone_lite_customize_partial_blogdescription',
	) );
		
	 	
	//Panel for section & control
	$wp_customize->add_panel( 'psyclone_lite_optionspanel_fortheme', array(
		'priority' => 4,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Psyclone Lite Theme Settings', 'psyclone-lite' ),		
	) );

	$wp_customize->add_section('psyclone_lite_sitelayout',array(
		'title' => __('Layout Style','psyclone-lite'),			
		'priority' => 1,
		'panel' => 	'psyclone_lite_optionspanel_fortheme',          
	));		
	
	$wp_customize->add_setting('psyclone_lite_layoutoption',array(
		'sanitize_callback' => 'psyclone_lite_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'psyclone_lite_layoutoption', array(
    	'section'   => 'psyclone_lite_sitelayout',    	 
		'label' => __('Check to Show Box Layout','psyclone-lite'),
		'description' => __('check for box layout','psyclone-lite'),
    	'type'      => 'checkbox'
     )); //Box Layout Options 
	
	$wp_customize->add_setting('psyclone_lite_colorscheme',array(
		'default' => '#de9f66',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'psyclone_lite_colorscheme',array(
			'label' => __('Color Scheme','psyclone-lite'),			
			'section' => 'colors',
			'settings' => 'psyclone_lite_colorscheme'
		))
	);
	
	$wp_customize->add_setting('psyclone_lite_secondcolor',array(
		'default' => '#b97c46',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'psyclone_lite_secondcolor',array(
			'label' => __('Second Color','psyclone-lite'),			
			'section' => 'colors',
			'settings' => 'psyclone_lite_secondcolor'
		))
	);
	
	$wp_customize->add_setting('psyclone_lite_menufontcolor',array(
		'default' => '#333333',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'psyclone_lite_menufontcolor',array(
			'label' => __('Navigation font Color','psyclone-lite'),			
			'section' => 'colors',
			'settings' => 'psyclone_lite_menufontcolor'
		))
	);
	
	
	$wp_customize->add_setting('psyclone_lite_menufontactivecolor',array(
		'default' => '#de9f66',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'psyclone_lite_menufontactivecolor',array(
			'label' => __('Navigation Hover/Active Color','psyclone-lite'),			
			'section' => 'colors',
			'settings' => 'psyclone_lite_menufontactivecolor'
		))
	);
	
	
	 //Header Contact details
	$wp_customize->add_section('psyclone_lite_contactdetails',array(
		'title' => __('Header Contact Details','psyclone-lite'),				
		'priority' => null,
		'panel' => 	'psyclone_lite_optionspanel_fortheme',
	));	
	
	$wp_customize->add_setting('psyclone_lite_phoneno',array(
		'default' => null,
		'sanitize_callback' => 'psyclone_lite_sanitize_phone_number'	
	));
	
	$wp_customize->add_control('psyclone_lite_phoneno',array(	
		'type' => 'text',
		'label' => __('Enter phone number here','psyclone-lite'),
		'section' => 'psyclone_lite_contactdetails',
		'setting' => 'psyclone_lite_phoneno'
	));
	
	$wp_customize->add_setting('psyclone_lite_emailid',array(
		'sanitize_callback' => 'sanitize_email'
	));
	
	$wp_customize->add_control('psyclone_lite_emailid',array(
		'type' => 'email',
		'label' => __('enter email id here.','psyclone-lite'),
		'section' => 'psyclone_lite_contactdetails'
	));	
	
	 $wp_customize->add_setting('psyclone_lite_appobtn',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('psyclone_lite_appobtn',array(	
		'type' => 'text',
		'label' => __('Enter button name here','psyclone-lite'),
		'setting' => 'psyclone_lite_appobtn',
		'section' => 'psyclone_lite_contactdetails'
	));	
	
	$wp_customize->add_setting('psyclone_lite_appobtnlink',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('psyclone_lite_appobtnlink',array(
		'label' => __('Add button link here','psyclone-lite'),		
		'setting' => 'psyclone_lite_appobtnlink',
		'section' => 'psyclone_lite_contactdetails'
	));	
	
	$wp_customize->add_setting('psyclone_lite_facebooklink',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'	
	));
	
	$wp_customize->add_control('psyclone_lite_facebooklink',array(
		'label' => __('Add facebook link here','psyclone-lite'),
		'section' => 'psyclone_lite_contactdetails',
		'setting' => 'psyclone_lite_facebooklink'
	));	
	
	$wp_customize->add_setting('psyclone_lite_twitterlink',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('psyclone_lite_twitterlink',array(
		'label' => __('Add twitter link here','psyclone-lite'),
		'section' => 'psyclone_lite_contactdetails',
		'setting' => 'psyclone_lite_twitterlink'
	));

	
	$wp_customize->add_setting('psyclone_lite_linkedinlink',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('psyclone_lite_linkedinlink',array(
		'label' => __('Add linkedin link here','psyclone-lite'),
		'section' => 'psyclone_lite_contactdetails',
		'setting' => 'psyclone_lite_linkedinlink'
	));
	
	$wp_customize->add_setting('psyclone_lite_instagramlink',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('psyclone_lite_instagramlink',array(
		'label' => __('Add instagram link here','psyclone-lite'),
		'section' => 'psyclone_lite_contactdetails',
		'setting' => 'psyclone_lite_instagramlink'
	));		
	
	$wp_customize->add_setting('psyclone_lite_show_contactdetails',array(
		'default' => false,
		'sanitize_callback' => 'psyclone_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'psyclone_lite_show_contactdetails', array(
	   'settings' => 'psyclone_lite_show_contactdetails',
	   'section'   => 'psyclone_lite_contactdetails',
	   'label'     => __('Check To show Header contact Section','psyclone-lite'),
	   'type'      => 'checkbox'
	 ));//Show Contact Details
	 
	 	
	//HomePage Slide Section		
	$wp_customize->add_section( 'psyclone_lite_hdrslder_settings', array(
		'title' => __('Home Page Slider Sections', 'psyclone-lite'),
		'priority' => null,
		'description' => __('Default image size for slider is 1400 x 782 pixel.','psyclone-lite'), 
		'panel' => 	'psyclone_lite_optionspanel_fortheme',           			
    ));
	
	$wp_customize->add_setting('psyclone_lite_hdrsldr1',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'psyclone_lite_sanitize_dropdown_pages'
	));
	
	$wp_customize->add_control('psyclone_lite_hdrsldr1',array(
		'type' => 'dropdown-pages',
		'label' => __('Select page for slide 1:','psyclone-lite'),
		'section' => 'psyclone_lite_hdrslder_settings'
	));	
	
	$wp_customize->add_setting('psyclone_lite_hdrsldr2',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'psyclone_lite_sanitize_dropdown_pages'
	));
	
	$wp_customize->add_control('psyclone_lite_hdrsldr2',array(
		'type' => 'dropdown-pages',
		'label' => __('Select page for slide 2:','psyclone-lite'),
		'section' => 'psyclone_lite_hdrslder_settings'
	));	
	
	$wp_customize->add_setting('psyclone_lite_hdrsldr3',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'psyclone_lite_sanitize_dropdown_pages'
	));
	
	$wp_customize->add_control('psyclone_lite_hdrsldr3',array(
		'type' => 'dropdown-pages',
		'label' => __('Select page for slide 3:','psyclone-lite'),
		'section' => 'psyclone_lite_hdrslder_settings'
	));	//frontpage Slider Section	
	
	//Slider Excerpt Length
	$wp_customize->add_setting( 'psyclone_lite_excerpt_length_hdrsldr', array(
		'default'              => 7,
		'type'                 => 'theme_mod',		
		'sanitize_callback'    => 'psyclone_lite_sanitize_excerptrange',		
	) );
	$wp_customize->add_control( 'psyclone_lite_excerpt_length_hdrsldr', array(
		'label'       => __( 'Slider Excerpt length','psyclone-lite' ),
		'section'     => 'psyclone_lite_hdrslder_settings',
		'type'        => 'range',
		'settings'    => 'psyclone_lite_excerpt_length_hdrsldr','input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );	
	
	$wp_customize->add_setting('psyclone_lite_hdrsldr_btntext',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('psyclone_lite_hdrsldr_btntext',array(	
		'type' => 'text',
		'label' => __('enter button name here','psyclone-lite'),
		'section' => 'psyclone_lite_hdrslder_settings',
		'setting' => 'psyclone_lite_hdrsldr_btntext'
	)); // slider read more button text
	
		
	$wp_customize->add_setting('psyclone_lite_show_hdrslder_settings',array(
		'default' => false,
		'sanitize_callback' => 'psyclone_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'psyclone_lite_show_hdrslder_settings', array(
	    'settings' => 'psyclone_lite_show_hdrslder_settings',
	    'section'   => 'psyclone_lite_hdrslder_settings',
	    'label'     => __('Check To Show This Section','psyclone-lite'),
	   'type'      => 'checkbox'
	 ));//Show Home Page Slider Options	
	 
	 //Three Box Services Sections
	$wp_customize->add_section('psyclone_lite_3page_settings', array(
		'title' => __('Three Column Sections','psyclone-lite'),
		'description' => __('Select pages from the dropdown for three box sections','psyclone-lite'),
		'priority' => null,
		'panel' => 	'psyclone_lite_optionspanel_fortheme',          
	));
		
	$wp_customize->add_setting('psyclone_lite_pagecol1',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'psyclone_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'psyclone_lite_pagecol1',array(
		'type' => 'dropdown-pages',			
		'section' => 'psyclone_lite_3page_settings',
	));		
	
	$wp_customize->add_setting('psyclone_lite_pagecol2',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'psyclone_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'psyclone_lite_pagecol2',array(
		'type' => 'dropdown-pages',			
		'section' => 'psyclone_lite_3page_settings',
	));
	
	$wp_customize->add_setting('psyclone_lite_pagecol3',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'psyclone_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'psyclone_lite_pagecol3',array(
		'type' => 'dropdown-pages',			
		'section' => 'psyclone_lite_3page_settings',
	));		
	
	$wp_customize->add_setting( 'psyclone_lite_excerpt_length_3page', array(
		'default'              => 7,
		'type'                 => 'theme_mod',		
		'sanitize_callback'    => 'psyclone_lite_sanitize_excerptrange',		
	) );
	$wp_customize->add_control( 'psyclone_lite_excerpt_length_3page', array(
		'label'       => __( 'four page box excerpt length','psyclone-lite' ),
		'section'     => 'psyclone_lite_3page_settings',
		'type'        => 'range',
		'settings'    => 'psyclone_lite_excerpt_length_3page','input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );	
	
	$wp_customize->add_setting('psyclone_lite_show_3page_settings',array(
		'default' => false,
		'sanitize_callback' => 'psyclone_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));		
	
	$wp_customize->add_control( 'psyclone_lite_show_3page_settings', array(
	   'settings' => 'psyclone_lite_show_3page_settings',
	   'section'   => 'psyclone_lite_3page_settings',
	   'label'     => __('Check To Show This Section','psyclone-lite'),
	   'type'      => 'checkbox'
	 ));//Show three page box sections
	 
	 
	 //Four Circle Column Sections
	$wp_customize->add_section('psyclone_lite_circle4bx_sections', array(
		'title' => __('Four Circle Column Sections','psyclone-lite'),
		'description' => __('Select pages from the dropdown for four column sections','psyclone-lite'),
		'priority' => null,
		'panel' => 	'psyclone_lite_optionspanel_fortheme',          
	));
	
	$wp_customize->add_setting('psyclone_lite_sectiontitle',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('psyclone_lite_sectiontitle',array(	
		'type' => 'text',
		'label' => __('Enter section title here','psyclone-lite'),
		'section' => 'psyclone_lite_circle4bx_sections',
		'setting' => 'psyclone_lite_sectiontitle'
	)); // Section Title text
		
	$wp_customize->add_setting('psyclone_lite_circlecol1',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'psyclone_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'psyclone_lite_circlecol1',array(
		'type' => 'dropdown-pages',			
		'section' => 'psyclone_lite_circle4bx_sections',
	));		
	
	$wp_customize->add_setting('psyclone_lite_circlecol2',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'psyclone_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'psyclone_lite_circlecol2',array(
		'type' => 'dropdown-pages',			
		'section' => 'psyclone_lite_circle4bx_sections',
	));
	
	$wp_customize->add_setting('psyclone_lite_circlecol3',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'psyclone_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'psyclone_lite_circlecol3',array(
		'type' => 'dropdown-pages',			
		'section' => 'psyclone_lite_circle4bx_sections',
	));
	
	$wp_customize->add_setting('psyclone_lite_circlecol4',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'psyclone_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'psyclone_lite_circlecol4',array(
		'type' => 'dropdown-pages',			
		'section' => 'psyclone_lite_circle4bx_sections',
	));
	
	$wp_customize->add_setting( 'psyclone_lite_excerpt_length_circlebx', array(
		'default'              => 7,
		'type'                 => 'theme_mod',		
		'sanitize_callback'    => 'psyclone_lite_sanitize_excerptrange',		
	) );
	$wp_customize->add_control( 'psyclone_lite_excerpt_length_circlebx', array(
		'label'       => __( 'circle box excerpt length','psyclone-lite' ),
		'section'     => 'psyclone_lite_circle4bx_sections',
		'type'        => 'range',
		'settings'    => 'psyclone_lite_excerpt_length_circlebx','input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );	
	
	
	$wp_customize->add_setting('psyclone_lite_show_circle4bx_sections',array(
		'default' => false,
		'sanitize_callback' => 'psyclone_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));		
	
	$wp_customize->add_control( 'psyclone_lite_show_circle4bx_sections', array(
	   'settings' => 'psyclone_lite_show_circle4bx_sections',
	   'section'   => 'psyclone_lite_circle4bx_sections',
	   'label'     => __('Check To Show This Section','psyclone-lite'),
	   'type'      => 'checkbox'
	 ));//Show Four Circle Column sections
	 
	 //Blog Posts Settings
	$wp_customize->add_panel( 'psyclone_lite_blogsettings_panel', array(
		'priority' => 3,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Blog Posts Settings', 'psyclone-lite' ),		
	) );
	
	$wp_customize->add_section('psyclone_lite_blogmeta_options',array(
		'title' => __('Blog Meta Options','psyclone-lite'),			
		'priority' => null,
		'panel' => 	'psyclone_lite_blogsettings_panel', 	         
	));		
	
	$wp_customize->add_setting('psyclone_lite_hide_blogdate',array(
		'sanitize_callback' => 'psyclone_lite_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'psyclone_lite_hide_blogdate', array(
    	'label' => __('Check to hide post date','psyclone-lite'),	
		'section'   => 'psyclone_lite_blogmeta_options', 
		'setting' => 'psyclone_lite_hide_blogdate',		
    	'type'      => 'checkbox'
     )); //Blog Post Date
	 
	 
	 $wp_customize->add_setting('psyclone_lite_hide_postcats',array(
		'sanitize_callback' => 'psyclone_lite_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'psyclone_lite_hide_postcats', array(
		'label' => __('Check to hide post category','psyclone-lite'),	
    	'section'   => 'psyclone_lite_blogmeta_options',		
		'setting' => 'psyclone_lite_hide_postcats',		
    	'type'      => 'checkbox'
     )); //blog Posts category	 
	 
	 
	 $wp_customize->add_section('psyclone_lite_postfeatured_image',array(
		'title' => __('Posts Featured image','psyclone-lite'),			
		'priority' => null,
		'panel' => 	'psyclone_lite_blogsettings_panel', 	         
	));		
	
	$wp_customize->add_setting('psyclone_lite_hide_postfeatured_image',array(
		'sanitize_callback' => 'psyclone_lite_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'psyclone_lite_hide_postfeatured_image', array(
		'label' => __('Check to hide post featured image','psyclone-lite'),
    	'section'   => 'psyclone_lite_postfeatured_image',		
		'setting' => 'psyclone_lite_hide_postfeatured_image',	
    	'type'      => 'checkbox'
     )); //Posts featured image
	
	$wp_customize->add_section('psyclone_lite_blogpost_content_settings',array(
		'title' => __('Posts Excerpt Options','psyclone-lite'),			
		'priority' => null,
		'panel' => 	'psyclone_lite_blogsettings_panel', 	         
	 ));	 
	 
	$wp_customize->add_setting( 'psyclone_lite_blogexcerptrange', array(
		'default'              => 30,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'psyclone_lite_sanitize_excerptrange',		
	) );
	
	$wp_customize->add_control( 'psyclone_lite_blogexcerptrange', array(
		'label'       => __( 'Excerpt length','psyclone-lite' ),
		'section'     => 'psyclone_lite_blogpost_content_settings',
		'type'        => 'range',
		'settings'    => 'psyclone_lite_blogexcerptrange','input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );

    $wp_customize->add_setting('psyclone_lite_blogfullcontent',array(
        'default' => 'Excerpt',     
        'sanitize_callback' => 'psyclone_lite_sanitize_choices'
	));
	
	$wp_customize->add_control('psyclone_lite_blogfullcontent',array(
        'type' => 'select',
        'label' => __('Posts Content','psyclone-lite'),
        'section' => 'psyclone_lite_blogpost_content_settings',
        'choices' => array(
        	'Content' => __('Content','psyclone-lite'),
            'Excerpt' => __('Excerpt','psyclone-lite'),
            'No Content' => __('No Excerpt','psyclone-lite')
        ),
	) ); 
	
	
	$wp_customize->add_section('psyclone_lite_postsinglemeta',array(
		'title' => __('Posts Single Settings','psyclone-lite'),			
		'priority' => null,
		'panel' => 	'psyclone_lite_blogsettings_panel', 	         
	));	
	
	$wp_customize->add_setting('psyclone_lite_hide_postdate_fromsingle',array(
		'sanitize_callback' => 'psyclone_lite_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'psyclone_lite_hide_postdate_fromsingle', array(
    	'label' => __('Check to hide post date from single','psyclone-lite'),	
		'section'   => 'psyclone_lite_postsinglemeta', 
		'setting' => 'psyclone_lite_hide_postdate_fromsingle',		
    	'type'      => 'checkbox'
     )); //Hide Posts date from single
	 
	 
	 $wp_customize->add_setting('psyclone_lite_hide_postcats_fromsingle',array(
		'sanitize_callback' => 'psyclone_lite_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'psyclone_lite_hide_postcats_fromsingle', array(
		'label' => __('Check to hide post category from single','psyclone-lite'),	
    	'section'   => 'psyclone_lite_postsinglemeta',		
		'setting' => 'psyclone_lite_hide_postcats_fromsingle',		
    	'type'      => 'checkbox'
     )); //Hide blogposts category single
		 
}
add_action( 'customize_register', 'psyclone_lite_customize_register' );

function psyclone_lite_custom_css(){ 
?>
	<style type="text/css"> 					
        a,
        #sidebar ul li a:hover,
		#sidebar ol li a:hover,							
        .Article-list h3 a:hover,
		.site-footer ul li a:hover, 
		.site-footer ul li.current_page_item a,				
        .postmeta a:hover,
        .button:hover,
		.Circle4Bx:hover h5 a,
		h2.services_title span,			
		.blog-postmeta a:hover,
		.blog-postmeta a:focus,
		blockquote::before	
            { color:<?php echo esc_html( get_theme_mod('psyclone_lite_colorscheme','#de9f66')); ?>;}					 
            
        .pagination ul li .current, .pagination ul li a:hover, 
        #commentform input#submit:hover,
        .nivo-controlNav a.active,
		.sd-search input, .sd-top-bar-nav .sd-search input,			
		a.blogreadmore,
		.Sb-Col3,
		.Circle4Bx .CircleThumb,
		.nivo-caption .slidermorebtn,
		a.ReadMoreBtn,
		.copyrigh-wrapper:before,										
        #sidebar .search-form input.search-submit,				
        .wpcf7 input[type='submit'],				
        nav.pagination .page-numbers.current,		
		.morebutton,
		.hdrTPStrip,	
		.nivo-directionNav a:hover,	
		.nivo-caption .slidermorebtn:hover		
            { background-color:<?php echo esc_html( get_theme_mod('psyclone_lite_colorscheme','#de9f66')); ?>;}
			

		
		.tagcloud a:hover,
		.logo::after,
		blockquote
            { border-color:<?php echo esc_html( get_theme_mod('psyclone_lite_colorscheme','#de9f66')); ?>;}
			
		#SiteWrapper a:focus,
		input[type="date"]:focus,
		input[type="search"]:focus,
		input[type="number"]:focus,
		input[type="tel"]:focus,
		input[type="button"]:focus,
		input[type="month"]:focus,
		button:focus,
		input[type="text"]:focus,
		input[type="email"]:focus,
		input[type="range"]:focus,		
		input[type="password"]:focus,
		input[type="datetime"]:focus,
		input[type="week"]:focus,
		input[type="submit"]:focus,
		input[type="datetime-local"]:focus,		
		input[type="url"]:focus,
		input[type="time"]:focus,
		input[type="reset"]:focus,
		input[type="color"]:focus,
		textarea:focus
            { outline:1px solid <?php echo esc_html( get_theme_mod('psyclone_lite_colorscheme','#de9f66')); ?>;}	
			
		.hdr-topstrip,
		.Sb-Col3:hover,
		.header-request-quote,
		.header-request-quote:after,
		.Sb-Col3.BX2:hover,
		.nivo-caption .slidermorebtn:hover 			
            { background-color:<?php echo esc_html( get_theme_mod('psyclone_lite_secondcolor','#b97c46')); ?>;}		
			
		
		.site-navigation a,
		.site-navigation ul li.current_page_parent ul.sub-menu li a,
		.site-navigation ul li.current_page_parent ul.sub-menu li.current_page_item ul.sub-menu li a,
		.site-navigation ul li.current-menu-ancestor ul.sub-menu li.current-menu-item ul.sub-menu li a  			
            { color:<?php echo esc_html( get_theme_mod('psyclone_lite_menufontcolor','#333333')); ?>;}	
			
		
		.site-navigation ul.nav-menu .current_page_item > a,
		.site-navigation ul.nav-menu .current-menu-item > a,
		.site-navigation ul.nav-menu .current_page_ancestor > a,
		.site-navigation ul.nav-menu .current-menu-ancestor > a, 
		.site-navigation .nav-menu a:hover,
		.site-navigation .nav-menu a:focus,
		.site-navigation .nav-menu ul a:hover,
		.site-navigation .nav-menu ul a:focus,
		.site-navigation ul li a:hover, 
		.site-navigation ul li.current-menu-item a,			
		.site-navigation ul li.current_page_parent ul.sub-menu li.current-menu-item a,
		.site-navigation ul li.current_page_parent ul.sub-menu li a:hover,
		.site-navigation ul li.current-menu-item ul.sub-menu li a:hover,
		.site-navigation ul li.current-menu-ancestor ul.sub-menu li.current-menu-item ul.sub-menu li a:hover 		 			
            { color:<?php echo esc_html( get_theme_mod('psyclone_lite_menufontactivecolor','#de9f66')); ?>;}
			
		.hdrtopcart .cart-count
            { background-color:<?php echo esc_html( get_theme_mod('psyclone_lite_menufontactivecolor','#de9f66')); ?>;}		
			
		#SiteWrapper .site-navigation a:focus		 			
            { outline:1px solid <?php echo esc_html( get_theme_mod('psyclone_lite_menufontactivecolor','#de9f66')); ?>;}	
	
    </style> 
<?php                                                                                                                                                                                                
}
         
add_action('wp_head','psyclone_lite_custom_css');	 

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function psyclone_lite_customize_preview_js() {
	wp_enqueue_script( 'psyclone_lite_customizer', get_template_directory_uri() . '/js/customize-preview.js', array( 'customize-preview' ), '19062019', true );
}
add_action( 'customize_preview_init', 'psyclone_lite_customize_preview_js' );