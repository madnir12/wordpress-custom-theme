<?php
/**
 * Psyclone Lite About Theme
 *
 * @package Psyclone Lite
 */

//about theme info
add_action( 'admin_menu', 'psyclone_lite_abouttheme' );
function psyclone_lite_abouttheme() {    	
	add_theme_page( __('About Theme Info', 'psyclone-lite'), __('About Theme Info', 'psyclone-lite'), 'edit_theme_options', 'psyclone_lite_guide', 'psyclone_lite_mostrar_guide');   
} 

//Info of the theme
function psyclone_lite_mostrar_guide() { 	
?>

<h1><?php esc_html_e('About Theme Info', 'psyclone-lite'); ?></h1>
<hr />  

<p><?php esc_html_e('The Psyclone Lite is a free mental health WordPress theme. This theme is free of cost and consists of numerous incredible features highly beneficial for mental health modern psychological or counseling websites. This theme is specially designed for clinic, doctor, health, Life Coach, mental, mental health, psychotherapist, psychotherapy, therapy, online psychological counselor, mental health clinics and life coach website. This WordPress theme can be easily used to publicize your website details such as the location of your chamber, your counseling services, your session timings, contact details, and much more. This professional-looking multipurpose theme is a boon for every psychologist or mental health professional. With enhanced effectiveness and accuracy of this free theme, you can make your online website noticeable and popular in no time!', 'psyclone-lite'); ?></p>

<h2><?php esc_html_e('Theme Features', 'psyclone-lite'); ?></h2>
<hr />  
 
<h3><?php esc_html_e('Theme Customizer', 'psyclone-lite'); ?></h3>
<p><?php esc_html_e('The built-in customizer panel quickly change aspects of the design and display changes live before saving them.', 'psyclone-lite'); ?></p>


<h3><?php esc_html_e('Responsive Ready', 'psyclone-lite'); ?></h3>
<p><?php esc_html_e('The themes layout will automatically adjust and fit on any screen resolution and looks great on any device. Fully optimized for iPhone and iPad.', 'psyclone-lite'); ?></p>


<h3><?php esc_html_e('Cross Browser Compatible', 'psyclone-lite'); ?></h3>
<p><?php esc_html_e('Our themes are tested in all mordern web browsers and compatible with the latest version including Chrome,Firefox, Safari, Opera, IE11 and above.', 'psyclone-lite'); ?></p>


<h3><?php esc_html_e('E-commerce', 'psyclone-lite'); ?></h3>
<p><?php esc_html_e('Fully compatible with WooCommerce plugin. Just install the plugin and turn your site into a full featured online shop and start selling products.', 'psyclone-lite'); ?></p>

<hr />  	
<p><a href="http://www.gracethemesdemo.com/documentation/psyclone/#homepage-lite" target="_blank"><?php esc_html_e('Documentation', 'psyclone-lite'); ?></a></p>

<?php } ?>