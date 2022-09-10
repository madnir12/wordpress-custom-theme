<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div class="container">
 *
 * @package Psyclone Lite
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
<?php endif; ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
?>
<a class="skip-link screen-reader-text" href="#tabber-BX">
<?php esc_html_e('Skip to content', 'psyclone-lite' ); ?>
</a>
<?php
$psyclone_lite_show_contactdetails 	   			= esc_attr( get_theme_mod('psyclone_lite_show_contactdetails', false) ); 
$psyclone_lite_show_hdrslder_settings 	  		= esc_attr( get_theme_mod('psyclone_lite_show_hdrslder_settings', false) );
$psyclone_lite_show_3page_settings      	= esc_attr( get_theme_mod('psyclone_lite_show_3page_settings', false) );
$psyclone_lite_show_circle4bx_sections      		= esc_attr( get_theme_mod('psyclone_lite_show_circle4bx_sections', false) );
?>
<div id="SiteWrapper" <?php if( get_theme_mod( 'psyclone_lite_layoutoption' ) ) { echo 'class="boxlayout"'; } ?>>
<?php
if ( is_front_page() && !is_home() ) {
	if( !empty($psyclone_lite_show_hdrslder_settings)) {
	 	$innerpage_cls = '';
	}
	else {
		$innerpage_cls = 'innerpage_header';
	}
}
else {
$innerpage_cls = 'innerpage_header';
}
?>

<div id="masthead" class="site-header <?php echo esc_attr($innerpage_cls); ?> "> 
      <?php if( $psyclone_lite_show_contactdetails != ''){ ?> 
      <div class="hdrTPStrip">
          <div class="container">   
                 <div class="left">
            <?php $psyclone_lite_phoneno = get_theme_mod('psyclone_lite_phoneno');
                if( !empty($psyclone_lite_phoneno) ){ ?>              
                <div class="hdr-ctn-info">
                    <i class="fas fa-phone fa-rotate-90"></i>
                    <?php echo esc_html($psyclone_lite_phoneno); ?>
                </div>       
            <?php } ?>
            
             <?php $email = get_theme_mod('psyclone_lite_emailid');
                if( !empty($email) ){ ?>                
                <div class="hdr-ctn-info">
                    <i class="far fa-envelope"></i>
                    <a href="<?php echo esc_url('mailto:'.sanitize_email($email)); ?>"><?php echo sanitize_email($email); ?></a>
                </div>            
            <?php } ?>           
            </div>
            
              <div class="right">
            	 <div class="hdr-tp-social">                                                
					   <?php $psyclone_lite_facebooklink = get_theme_mod('psyclone_lite_facebooklink');
                        if( !empty($psyclone_lite_facebooklink) ){ ?>
                        <a class="fab fa-facebook-f" target="_blank" href="<?php echo esc_url($psyclone_lite_facebooklink); ?>"></a>
                       <?php } ?>
                    
                       <?php $psyclone_lite_twitterlink = get_theme_mod('psyclone_lite_twitterlink');
                        if( !empty($psyclone_lite_twitterlink) ){ ?>
                        <a class="fab fa-twitter" target="_blank" href="<?php echo esc_url($psyclone_lite_twitterlink); ?>"></a>
                       <?php } ?>
                
                      <?php $psyclone_lite_linkedinlink = get_theme_mod('psyclone_lite_linkedinlink');
                        if( !empty($psyclone_lite_linkedinlink) ){ ?>
                        <a class="fab fa-linkedin" target="_blank" href="<?php echo esc_url($psyclone_lite_linkedinlink); ?>"></a>
                      <?php } ?> 
                      
                      <?php $psyclone_lite_instagramlink = get_theme_mod('psyclone_lite_instagramlink');
                        if( !empty($psyclone_lite_instagramlink) ){ ?>
                        <a class="fab fa-instagram" target="_blank" href="<?php echo esc_url($psyclone_lite_instagramlink); ?>"></a>
                      <?php } ?> 
                  </div><!--end .hdr-tp-social-->
                   <?php
                $psyclone_lite_appobtn = get_theme_mod('psyclone_lite_appobtn');
                if( !empty($psyclone_lite_appobtn) ){ ?>        
                <?php $psyclone_lite_appobtnlink = get_theme_mod('psyclone_lite_appobtnlink');
                if( !empty($psyclone_lite_appobtnlink) ){ ?>              
                  <div class="header-request-quote">
                        <a target="_blank" href="<?php echo esc_url($psyclone_lite_appobtnlink); ?>">
                        	<?php echo esc_html($psyclone_lite_appobtn); ?>            
                        </a>
                 </div>          
             <?php }} ?> 
               </div>    
        		 <div class="clear"></div> 
          </div><!-- .container --> 
      </div><!-- .hdrTPStrip -->      
   <?php } ?>   

    <div class="container">
      <div class="LgoNav-Strip">  
        <div class="logo">
           <?php psyclone_lite_the_custom_logo(); ?>
            <div class="site_branding">
                <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
                <?php $description = get_bloginfo( 'description', 'display' );
                if ( $description || is_customize_preview() ) : ?>
                    <p><?php echo esc_html($description); ?></p>
                <?php endif; ?>
            </div>
         </div><!-- logo --> 
         
          <div class="RightNavMenu"> 
             <div id="navigationpanel"> 
                 <nav id="main-navigation" class="site-navigation" role="navigation" aria-label="Primary Menu">
                    <button type="button" class="menu-toggle">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <?php
                    	wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'nav-menu',
                    ) );
                    ?>
                </nav><!-- #main-navigation -->  
            </div><!-- #navigationpanel -->   
          </div><!-- .RightNavMenu --> 
         <div class="clear"></div>
       </div><!-- .LgoNav-Strip -->  
    </div><!-- .container -->  
 
 <div class="clear"></div> 
</div><!--.site-header --> 
 
<?php 
if ( is_front_page() && !is_home() ) {
if($psyclone_lite_show_hdrslder_settings != '') {
	for($i=1; $i<=3; $i++) {
	  if( get_theme_mod('psyclone_lite_hdrsldr'.$i,false)) {
		$slider_Arr[] = absint( get_theme_mod('psyclone_lite_hdrsldr'.$i,true));
	  }
	}
?> 
<div class="HomepageSlider">              
<?php if(!empty($slider_Arr)){ ?>
<div id="slider" class="nivoSlider">
<?php 
$i=1;
$slidequery = new WP_Query( array( 'post_type' => 'page', 'post__in' => $slider_Arr, 'orderby' => 'post__in' ) );
while( $slidequery->have_posts() ) : $slidequery->the_post();
$image = wp_get_attachment_url( get_post_thumbnail_id($post->ID)); 
$thumbnail_id = get_post_thumbnail_id( $post->ID );
$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true); 
?>
<?php if(!empty($image)){ ?>
<img src="<?php echo esc_url( $image ); ?>" title="#slidecaption<?php echo esc_attr( $i ); ?>" alt="<?php echo esc_attr($alt); ?>" />
<?php }else{ ?>
<img src="<?php echo esc_url( get_template_directory_uri() ) ; ?>/images/slides/slider-default.jpg" title="#slidecaption<?php echo esc_attr( $i ); ?>" alt="<?php echo esc_attr($alt); ?>" />
<?php } ?>
<?php $i++; endwhile; ?>
</div>   

<?php 
$j=1;
$slidequery->rewind_posts();
while( $slidequery->have_posts() ) : $slidequery->the_post(); ?>                 
    <div id="slidecaption<?php echo esc_attr( $j ); ?>" class="nivo-html-caption">         
     <h2><?php the_title(); ?></h2>
     <p><?php $excerpt = get_the_excerpt(); echo esc_html( psyclone_lite_string_limit_words( $excerpt, esc_attr(get_theme_mod('psyclone_lite_excerpt_length_hdrsldr','7')))); ?></p>
		<?php
        $psyclone_lite_hdrsldr_btntext = get_theme_mod('psyclone_lite_hdrsldr_btntext');
        if( !empty($psyclone_lite_hdrsldr_btntext) ){ ?>
            <a class="slidermorebtn" href="<?php the_permalink(); ?>"><?php echo esc_html($psyclone_lite_hdrsldr_btntext); ?></a>
        <?php } ?>  
                        
    </div>   
<?php $j++; 
endwhile;
wp_reset_postdata(); ?>   
<?php } ?>
</div><!-- .HomepageSlider -->    
<?php } } ?> 

<?php if ( is_front_page() && ! is_home() ) { ?> 
     
 <?php if( $psyclone_lite_show_3page_settings != ''){ ?> 
   <section id="ThreeColumn-Section-1">
     <div class="container"> 
         <div class="box-equal-height">
          <?php 
                for($n=1; $n<=3; $n++) {    
                if( get_theme_mod('psyclone_lite_pagecol'.$n,false)) {      
                    $queryvar = new WP_Query('page_id='.absint(get_theme_mod('psyclone_lite_pagecol'.$n,true)) );		
                    while( $queryvar->have_posts() ) : $queryvar->the_post(); ?>     
                     <div class="Sb-Col3 BX<?php echo esc_attr( $n ); ?>">   
                         <div class="topboxbg ">
							  <?php if(has_post_thumbnail() ) { ?>
                                <div class="Col3-icon">
                                  <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>                                
                                </div>        
                               <?php } ?>
                               <div class="shortinfo">
                               <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                               
                               <p><?php $excerpt = get_the_excerpt(); echo esc_html( psyclone_lite_string_limit_words( $excerpt, esc_attr(get_theme_mod('psyclone_lite_excerpt_length_3page','7')))); ?></p>
                               </div> 
                        </div>
                     </div>
                    <?php endwhile;
                    wp_reset_postdata();                                  
                } } ?>                                 
               <div class="clear"></div>  
     	 </div><!-- .box-equal-height -->
       </div><!-- .container -->
    </section><!-- #ThreeColumn-Section-1 -->
  <?php } ?> 
  
   <?php if( $psyclone_lite_show_circle4bx_sections != ''){ ?> 
   <section id="Circle-4Column-Section-2">
     <div class="container"> 
        <?php
        $psyclone_lite_sectiontitle = get_theme_mod('psyclone_lite_sectiontitle');
        if( !empty($psyclone_lite_sectiontitle) ){ ?>
            <h3><?php echo esc_html($psyclone_lite_sectiontitle); ?></h3>
        <?php } ?> 
          <?php 
                for($n=1; $n<=4; $n++) {    
                if( get_theme_mod('psyclone_lite_circlecol'.$n,false)) {      
                    $queryvar = new WP_Query('page_id='.absint(get_theme_mod('psyclone_lite_circlecol'.$n,true)) );		
                    while( $queryvar->have_posts() ) : $queryvar->the_post(); ?>     
                     <div class="Circle4Bx <?php if($n % 4 == 0) { echo "last_column"; } ?>">   
							  <?php if(has_post_thumbnail() ) { ?>
                                <div class="CircleThumb">
                                  <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>                                
                                </div>        
                               <?php } ?>
                               <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                               <p><?php $excerpt = get_the_excerpt(); echo esc_html( psyclone_lite_string_limit_words( $excerpt, esc_attr(get_theme_mod('psyclone_lite_excerpt_length_circlebx','7')))); ?></p>
                     </div>
                    <?php endwhile;
                    wp_reset_postdata();                                  
                } } ?>                                 
               <div class="clear"></div>  
      </div><!-- .container -->
    </section><!-- #Circle-4Column-Section-2-->
  <?php } ?> 
<?php } ?>