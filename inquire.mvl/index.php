<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
error_reporting(E_ERROR);

define('CONF_ABSOLUTE_PATH', getcwd());
define('MAIN_FOLDER', CONF_ABSOLUTE_PATH.'/');
define('SMARTY_PATH', MAIN_FOLDER.'smarty/libs/');
define('SMARTY_PLUGINS', MAIN_FOLDER.'smarty/plugins/');
define('CLASSES_PATH', MAIN_FOLDER.'classes/');
define('VILLA_XML_PATH', MAIN_FOLDER.'villa-xml/');
define('SITEMAP_PATH', MAIN_FOLDER.'sitemaps/');
define('ERROR_TEMPLATE', MAIN_FOLDER.'templates/404/');

require CLASSES_PATH.'stringv.php';
require CLASSES_PATH.'mobile.php';
require CLASSES_PATH.'villaClasses.php';
require CLASSES_PATH.'formClass.php';
require CLASSES_PATH.'ratesClass.php';
require SMARTY_PATH.'Smarty.class.php';

$website = new villa(); /* Instance of villa class */
$vid = isset($_GET['villaID'])?$_GET['villaID']:'';

$countries = $website->curly_tops('DisplayAllCountries',"",TRUE,FALSE,"","","prod");
/* Get Country by IP */
$timeTokenHash = $website->curly_tops('Security_GetTimeToken',"",TRUE,FALSE,"","","prod");
if(!is_array($timeTokenHash))
	$timeTokenHash = html_entity_decode($timeTokenHash);
	
$params['p_ToHash'] = 'villaprtl|Xr4g2RmU|'.$timeTokenHash[0];
$hashString = $website->prepare_Security_GetMD5Hash($params);
$md5Hash = $website->curly_tops('Security_GetMD5Hash',$hashString,TRUE,FALSE);

$qString = 'p_Token='.$md5Hash[0].'&p_UserID=VILLAPRTL&p_IPAddress='.$website->get_ip();
$ipByCountry = $website->curlIP($qString,TRUE);
if(!is_array($ipByCountry))
	$ipByCountry = html_entity_decode($ipByCountry);

$defaultCountry = $ipByCountry['ID'];
$defaultCode = $ipByCountry['PhoneCode'];
/* End get country by IP */

/* Sample Villa and Villa IDs */
$villas = array("TamanAhimsa"=>"Taman Ahimsa", "YlangYlang"=>"The Ylang Ylang", "Sava7"=>"Villa Aqua Phuket", "Luna2PrivateHotel"=>"Noku Beach House", "P00212"=>"Villa Nautilus Phuket", "P00227"=>"Villa Music Phuket", "Asta"=>"Villa Asta", "P00233"=>"Villa 1880");
/* End Sample Villa data */

$defaultHeading = 'Booking Form';
$defaultContent = 'form';

if( isset($_POST['btnSend']) ):
	$v_email = array("email"=>trim($_POST['txtEmail']));
	$p_Params = json_encode($v_email);
	$fparams = [];
	$fparams = $_POST;
	$request = "p_Params=".$p_Params;
	$isValidEmail = $website->cheeze_curls("isValidEmailAddress",$request,TRUE,FALSE,"","","prod");
	
	if( $isValidEmail[0] == 'True' ):
		$fparams['rurl'] = $referrer;
		$fparams['db'] = 'uat';
		$fparams['villaID'] = $_POST['villaID']!=""?$_POST['villaID']:$_POST['select_villa'];
		$newBooking = $website->reserve_process($fparams);
		if ($newBooking['@attributes']['status'] != 'error'):
			$data['sendToAnalytics'] = TRUE;
			$defaultHeading = 'Enquiry Sent';
			$content = $newBooking['thank_you_message'];
			$defaultContent = 'typage';
		endif;
	endif;
endif;
?>
<!doctype html>
<html lang="en-US" class="no-js">
<head> 
<meta charset="UTF-8" />  
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="pingback" href="https://samuiluxurycollection.com/xmlrpc.php" />
<title><?php echo $defaultHeading; ?> ∣ Bespoke Holiday Villa Rentals by SILK</title>
<script type="text/javascript">
  WebFontConfig = {"google":{"families":["Montserrat:r:latin,latin-ext","Open+Sans:r,i,b,bi:latin,latin-ext"]}};
  (function() {
    var wf = document.createElement('script');
    wf.src = 'https://samuiluxurycollection.com/wp-content/mu-plugins/wpcomsh/vendor/automattic/custom-fonts/js/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
	})();
</script><style id="jetpack-custom-fonts-css"></style>

<link rel='dns-prefetch' href='//s0.wp.com' />
<link rel='dns-prefetch' href='//secure.gravatar.com' />
<link rel='dns-prefetch' href='//fonts.googleapis.com' />
<link rel='dns-prefetch' href='//s.w.org' />
<link rel="alternate" type="application/rss+xml" title="Samui Luxury Collection &raquo; Feed" href="https://samuiluxurycollection.com/feed/" />
<link rel="alternate" type="application/rss+xml" title="Samui Luxury Collection &raquo; Comments Feed" href="https://samuiluxurycollection.com/comments/feed/" />
		
		<style type="text/css">
img.wp-smiley,
img.emoji {
	display: inline !important;
	border: none !important;
	box-shadow: none !important;
	height: 1em !important;
	width: 1em !important;
	margin: 0 .07em !important;
	vertical-align: -0.1em !important;
	background: none !important;
	padding: 0 !important;
}
</style>
<link rel='stylesheet' id='wpcom-text-widget-styles-css'  href='https://samuiluxurycollection.com/wp-content/mu-plugins/wpcomsh/vendor/automattic/text-media-widget-styles/css/widget-text.css?ver=20170607' type='text/css' media='all' />
<link rel='stylesheet' id='contact-form-7-css'  href='https://samuiluxurycollection.com/wp-content/plugins/contact-form-7/includes/css/styles.css?ver=5.0.5' type='text/css' media='all' />
<link rel='stylesheet' id='king-countdowner-css'  href='https://samuiluxurycollection.com/wp-content/plugins/easy-countdowner/assets/TimeCircles.css?ver=1.0' type='text/css' media='all' />
<link rel='stylesheet' id='rs-plugin-settings-css'  href='https://samuiluxurycollection.com/wp-content/plugins/revslider/public/assets/css/settings.css?ver=5.4.6.3.1' type='text/css' media='all' />
<style id='rs-plugin-settings-inline-css' type='text/css'>
#rs-demo-id {}
</style>
<link rel='stylesheet' id='ce_responsive-css'  href='https://samuiluxurycollection.com/wp-content/plugins/simple-embed-code/css/video-container.min.css?ver=4.9.8' type='text/css' media='all' />
<link rel='stylesheet' id='bootstrap-css'  href='https://samuiluxurycollection.com/wp-content/themes/nixe/css/bootstrap.css?ver=4.9.8' type='text/css' media='all' />
<link rel='stylesheet' id='nixe-style-all-css'  href='https://samuiluxurycollection.com/wp-content/themes/nixe/css/style.css?ver=4.9.8' type='text/css' media='all' />
<link rel='stylesheet' id='fontello-css'  href='https://samuiluxurycollection.com/wp-content/themes/nixe/css/fontello/css/fontello.css?ver=4.9.8' type='text/css' media='all' />
<link rel='stylesheet' id='jquery-owl-carousel-css'  href='https://samuiluxurycollection.com/wp-content/themes/nixe/css/owl-carousel.css?ver=4.9.8' type='text/css' media='all' />
<link rel='stylesheet' id='lightgallery-css'  href='https://samuiluxurycollection.com/wp-content/themes/nixe/css/lightgallery.min.css?ver=4.9.8' type='text/css' media='all' />
<link rel='stylesheet' id='datepicker-css'  href='https://samuiluxurycollection.com/wp-content/themes/nixe/css/datepicker.css?ver=4.9.8' type='text/css' media='all' />
<link rel='stylesheet' id='js_composer_front-css'  href='https://samuiluxurycollection.com/wp-content/plugins/js_composer/assets/css/js_composer.min.css?ver=5.4.4' type='text/css' media='all' />
<link rel='stylesheet' id='nixe-theme-style-css'  href='https://samuiluxurycollection.com/wp-content/themes/nixe/style.css?ver=4.9.8' type='text/css' media='all' />
<link rel='stylesheet' id='nixe-dynamic-css'  href='https://samuiluxurycollection.com/wp-content/uploads/nixe/dynamic-style-2905.css?ver=180517094730' type='text/css' media='all' />
<link rel='stylesheet' id='nixe-google-fonts-css'  href='//fonts.googleapis.com/css?family=Poppins%3A600%7COpen+Sans%3Aregular%7CLibre+Baskerville%3Aitalic&#038;subset=latin&#038;ver=1.0.0' type='text/css' media='all' />
<link rel='stylesheet' id='social-logos-css'  href='https://c0.wp.com/p/jetpack/6.8/_inc/social-logos/social-logos.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='jetpack_css-css'  href='https://c0.wp.com/p/jetpack/6.8/css/jetpack.css' type='text/css' media='all' />
<script type='text/javascript' src='https://c0.wp.com/c/4.9.8/wp-includes/js/jquery/jquery.js'></script>
<script type='text/javascript' src='https://c0.wp.com/c/4.9.8/wp-includes/js/jquery/jquery-migrate.min.js'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/themes/nixe/js/pace.js?ver=4.9.8'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/themes/nixe/js/modernizr.min.js?ver=4.9.8'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/plugins/easy-countdowner/assets/TimeCircles.js?ver=1.0'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/plugins/revslider/public/assets/js/jquery.themepunch.tools.min.js?ver=5.4.6.3.1'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/plugins/revslider/public/assets/js/jquery.themepunch.revolution.min.js?ver=5.4.6.3.1'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/plugins/revslider/public/assets/js/extensions/revolution.extension.actions.min.js?ver=5.4.6.3.1'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/plugins/revslider/public/assets/js/extensions/revolution.extension.carousel.min.js?ver=5.4.6.3.1'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/plugins/revslider/public/assets/js/extensions/revolution.extension.kenburn.min.js?ver=5.4.6.3.1'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/plugins/revslider/public/assets/js/extensions/revolution.extension.layeranimation.min.js?ver=5.4.6.3.1'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/plugins/revslider/public/assets/js/extensions/revolution.extension.migration.min.js?ver=5.4.6.3.1'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/plugins/revslider/public/assets/js/extensions/revolution.extension.navigation.min.js?ver=5.4.6.3.1'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/plugins/revslider/public/assets/js/extensions/revolution.extension.parallax.min.js?ver=5.4.6.3.1'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/plugins/revslider/public/assets/js/extensions/revolution.extension.slideanims.min.js?ver=5.4.6.3.1'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/plugins/revslider/public/assets/js/extensions/revolution.extension.video.min.js?ver=5.4.6.3.1'></script>
<script type='text/javascript' src='https://c0.wp.com/p/jetpack/6.8/_inc/build/postmessage.min.js'></script>
<script type='text/javascript' src='https://c0.wp.com/p/jetpack/6.8/_inc/build/jquery.jetpack-resize.min.js'></script>
<link rel='https://api.w.org/' href='https://samuiluxurycollection.com/wp-json/' />
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="https://samuiluxurycollection.com/xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="https://samuiluxurycollection.com/wp-includes/wlwmanifest.xml" /> 

<link rel="canonical" href="https://samuiluxurycollection.com/booking-form/" />
<link rel='shortlink' href='https://wp.me/P9lwWy-KR' />
<link rel="alternate" type="application/json+oembed" href="https://samuiluxurycollection.com/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fsamuiluxurycollection.com%2Fbooking-form%2F" />
<link rel="alternate" type="text/xml+oembed" href="https://samuiluxurycollection.com/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fsamuiluxurycollection.com%2Fbooking-form%2F&#038;format=xml" />

<link rel='dns-prefetch' href='//widgets.wp.com'/>
<link rel='dns-prefetch' href='//s0.wp.com'/>
<link rel='dns-prefetch' href='//0.gravatar.com'/>
<link rel='dns-prefetch' href='//1.gravatar.com'/>
<link rel='dns-prefetch' href='//2.gravatar.com'/>
<link rel='dns-prefetch' href='//jetpack.wordpress.com'/>
<link rel='dns-prefetch' href='//s1.wp.com'/>
<link rel='dns-prefetch' href='//s2.wp.com'/>
<link rel='dns-prefetch' href='//public-api.wordpress.com'/>
<link rel='dns-prefetch' href='//i0.wp.com'/>
<link rel='dns-prefetch' href='//i1.wp.com'/>
<link rel='dns-prefetch' href='//i2.wp.com'/>
<link rel='dns-prefetch' href='//c0.wp.com'/>
<style type='text/css'>img#wpstats{display:none}</style>
<!--[if lt IE 9]><script src="https://samuiluxurycollection.com/wp-content/themes/nixe/js/html5shiv.min.js"></script><![endif]-->
<meta name="generator" content="Powered by Nixe Creative Multi Concept WordPress Theme TV:1.4.4 PV:1.4.3" />
<meta name="generator" content="Powered by WPBakery Page Builder - drag and drop page builder for WordPress."/>
<!--[if lte IE 9]><link rel="stylesheet" type="text/css" href="https://samuiluxurycollection.com/wp-content/plugins/js_composer/assets/css/vc_lte_ie9.min.css" media="screen"><![endif]--><meta name="description" content="Holiday Villa Rentals on Koh Samui • Curated and Managed by Local Experts • Concierge • Guest Service • Insider Tips • In-Villa Chef • Private Pool • Free WiFi" />
<meta name="generator" content="Powered by Slider Revolution 5.4.6.3.1 - responsive, Mobile-Friendly Slider Plugin for WordPress with comfortable drag and drop interface." />

<!-- Jetpack Open Graph Tags -->
<meta property="og:type" content="article" />
<meta property="og:title" content="Booking Form ∣ Bespoke Holiday Villa Rentals by SILK" />
<meta property="og:url" content="https://samuiluxurycollection.com/booking-form/" />
<meta property="og:description" content="Holiday Villa Rentals on Koh Samui • Curated and Managed by Local Experts • Concierge • Guest Service • Insider Tips • In-Villa Chef • Private Pool • Free WiFi" />
<meta property="article:published_time" content="2016-06-15T02:05:11+00:00" />
<meta property="article:modified_time" content="2018-02-15T08:15:10+00:00" />
<meta property="og:site_name" content="Samui Luxury Collection" />
<meta property="og:image" content="https://i0.wp.com/samuiluxurycollection.com/wp-content/uploads/2018/02/palm-tree.png?fit=1600%2C1600&amp;ssl=1" />
<meta property="og:image:width" content="1600" />
<meta property="og:image:height" content="1600" />
<meta property="og:locale" content="en_US" />
<meta name="twitter:site" content="@SILKKohSamui" />
<meta name="twitter:text:title" content="Booking Form" />
<meta name="twitter:image" content="https://i0.wp.com/samuiluxurycollection.com/wp-content/uploads/2018/02/palm-tree.png?fit=240%2C240&amp;ssl=1" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:description" content="Visit the post for more." />

<!-- End Jetpack Open Graph Tags -->
<link rel="icon" href="https://i0.wp.com/samuiluxurycollection.com/wp-content/uploads/2018/02/palm-tree.png?fit=32%2C32&#038;ssl=1" sizes="32x32" />
<link rel="icon" href="https://i0.wp.com/samuiluxurycollection.com/wp-content/uploads/2018/02/palm-tree.png?fit=192%2C192&#038;ssl=1" sizes="192x192" />
<link rel="apple-touch-icon-precomposed" href="https://i0.wp.com/samuiluxurycollection.com/wp-content/uploads/2018/02/palm-tree.png?fit=180%2C180&#038;ssl=1" />
<meta name="msapplication-TileImage" content="https://i0.wp.com/samuiluxurycollection.com/wp-content/uploads/2018/02/palm-tree.png?fit=270%2C270&#038;ssl=1" />
<script type="text/javascript">function setREVStartSize(e){
				try{ var i=jQuery(window).width(),t=9999,r=0,n=0,l=0,f=0,s=0,h=0;					
					if(e.responsiveLevels&&(jQuery.each(e.responsiveLevels,function(e,f){f>i&&(t=r=f,l=e),i>f&&f>r&&(r=f,n=e)}),t>r&&(l=n)),f=e.gridheight[l]||e.gridheight[0]||e.gridheight,s=e.gridwidth[l]||e.gridwidth[0]||e.gridwidth,h=i/s,h=h>1?1:h,f=Math.round(h*f),"fullscreen"==e.sliderLayout){var u=(e.c.width(),jQuery(window).height());if(void 0!=e.fullScreenOffsetContainer){var c=e.fullScreenOffsetContainer.split(",");if (c) jQuery.each(c,function(e,i){u=jQuery(i).length>0?u-jQuery(i).outerHeight(!0):u}),e.fullScreenOffset.split("%").length>1&&void 0!=e.fullScreenOffset&&e.fullScreenOffset.length>0?u-=jQuery(window).height()*parseInt(e.fullScreenOffset,0)/100:void 0!=e.fullScreenOffset&&e.fullScreenOffset.length>0&&(u-=parseInt(e.fullScreenOffset,0))}f=u}else void 0!=e.minHeight&&f<e.minHeight&&(f=e.minHeight);e.c.closest(".rev_slider_wrapper").css({height:f})					
				}catch(d){console.log("Failure at Presize of Slider:"+d)}
			};</script>
<noscript><style type="text/css"> .wpb_animate_when_almost_visible { opacity: 1; }</style></noscript></head>
<body class="page-template-default page page-id-2905 rt-loading rt-loading-active  sticky-header header-lines nixe-dark-header nixe-dark-sticky-header nixe-dark-mobile-header header-search-button nixe-default-header-width-header-width nixe-default-footer-width-footer-width wpb-js-composer js-comp-ver-5.4.4 vc_responsive">
		
		<!-- loader -->
		<div id="loader-wrapper"> 
			<div class="part-1"></div>
			<div class="part-2"></div> 
			<div class="line-1"></div> 
			<div class="line-2"></div> 
			<div class="part-logo"><div><img width="150" height="52" class="loading-logo" src="https://i2.wp.com/samuiluxurycollection.com/wp-content/uploads/2018/02/SILK-Color-Logos-3.png?fit=150%2C52&#038;ssl=1" alt="Samui Luxury Collection" srcset="https://i2.wp.com/samuiluxurycollection.com/wp-content/uploads/2018/02/SILK-Color-Logos-3.png?fit=150%2C52&ssl=1 1.3x" /></div></div>
		</div>
		<!-- / #loader -->
	
<!-- background wrapper -->
<div id="container">   
 
	<header class="top-header" data-color="dark" data-sticky-color="dark" data-mobile-color="dark">
		<div class="header-elements">
		
						<!-- mobile menu button -->
			<div class="mobile-menu-button icon-menu"></div>
			
			
			<!-- logo -->
					

			<div id="logo" class="site-logo">
				 <a href="https://samuiluxurycollection.com/" title="Samui Luxury Collection"><img width="150" height="52" src="https://i2.wp.com/samuiluxurycollection.com/wp-content/uploads/2018/02/SILK-Color-Logos-3.png?fit=150%2C52&#038;ssl=1" alt="Samui Luxury Collection" class="dark-logo logo-image" srcset="https://i2.wp.com/samuiluxurycollection.com/wp-content/uploads/2018/02/SILK-Color-Logos-3.png?fit=150%2C52&ssl=1 1.3x" /><img width="150" height="52" src="https://i2.wp.com/samuiluxurycollection.com/wp-content/uploads/2018/02/SILK-Color-Logos-3.png?fit=150%2C52&#038;ssl=1" alt="Samui Luxury Collection" class="dark-logo-sticky logo-sticky-image logo-image" srcset="https://i2.wp.com/samuiluxurycollection.com/wp-content/uploads/2018/02/SILK-Color-Logos-3.png?fit=150%2C52&ssl=1 1.3x" /></a> 		
			</div><!-- / end #logo -->
			
						<div class="header-slogan">
				<span>
							
					Bespoke Holiday Villa Rentals									</span>
			</div>			
			
			<div class="header-right">
						

				<!-- navigation holder -->
									
						    
								
													<nav>
								<ul id="navigation" class="menu"><li id='menu-item-3037'  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children" data-depth='0'><a  href="#">LUXURY HOLIDAY VILLAS</a> 
<ul class="sub-menu">
<li id='menu-item-3369'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/bespoke-holiday-villa-collection/">All Luxury Holiday Villas</a> </li>
<li id='menu-item-3105'  class="menu-item menu-item-type-taxonomy menu-item-object-room_categories" data-depth='1'><a  href="https://samuiluxurycollection.com/villas/beachfront-villas/">Beachfront Villas</a> </li>
<li id='menu-item-3106'  class="menu-item menu-item-type-taxonomy menu-item-object-room_categories" data-depth='1'><a  href="https://samuiluxurycollection.com/villas/ocean-view-villas/">Ocean View Villas</a> </li>
<li id='menu-item-3155'  class="menu-item menu-item-type-taxonomy menu-item-object-room_categories" data-depth='1'><a  href="https://samuiluxurycollection.com/villas/kids-friendly-villas/">Kids Friendly Villas</a> </li>
<li id='menu-item-3107'  class="menu-item menu-item-type-taxonomy menu-item-object-room_categories" data-depth='1'><a  href="https://samuiluxurycollection.com/villas/pet-friendly-rooms/">Pet Friendly Villas</a> </li>
</ul>
</li>
<li id='menu-item-3122'  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children" data-depth='0'><a  href="#">EXPERIENCES</a> 
<ul class="sub-menu">
<li id='menu-item-3047'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/activities/">Activities</a> </li>
<li id='menu-item-4240'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/foodie-experiences/">Foodie Experiences</a> </li>
<li id='menu-item-3054'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/weddings/">Weddings &#038; Events</a> </li>
</ul>
</li>
<li id='menu-item-4451'  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children" data-depth='0'><a  href="#">ABOUT US</a> 
<ul class="sub-menu">
<li id='menu-item-4441'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/about-us/">Few Words About SILK</a> </li>
<li id='menu-item-3049'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/our-team/">Our Team</a> </li>
<li id='menu-item-3050'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/testimonials/">Testimonials</a> </li>
<li id='menu-item-3956'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/media-press/">Media &#038; Press</a> </li>
<li id='menu-item-4137'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/list-with-us/">List With Us</a> </li>
<li id='menu-item-3048'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/contact-us/">Contact Us</a> </li>
</ul>
</li>
<li id='menu-item-3026'  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children" data-depth='0'><a  href="#">GALLERY</a> 
<ul class="sub-menu">
<li id='menu-item-3960'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/koh-samui-photo-gallery/">Koh Samui</a> </li>
<li id='menu-item-4135'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/villa-inspiration/">Villa Inspiration</a> </li>
<li id='menu-item-3962'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/guest-photo-gallery/">Guest Photo Gallery</a> </li>
</ul>
</li>
<li id='menu-item-3060'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='0'><a  href="https://samuiluxurycollection.com/visit-samui-magazine/">BLOG</a> </li>
</ul> 
							</nav>
												
				
				<a href="#" class="nixe-search-button"><span class="icon-search-1"></span></a>
				

			</div><!-- / end .header-right -->
		</div>

				 
		<!-- mobile menu -->
		<div class="mobile-nav">
				<!-- navigation holder -->
				<nav>
					<ul id="mobile-navigation" class="menu"><li id='mobile-menu-item-3037'  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children" data-depth='0'><a  href="#">LUXURY HOLIDAY VILLAS</a> 
<ul class="sub-menu">
<li id='mobile-menu-item-3369'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/bespoke-holiday-villa-collection/">All Luxury Holiday Villas</a> </li>
<li id='mobile-menu-item-3105'  class="menu-item menu-item-type-taxonomy menu-item-object-room_categories" data-depth='1'><a  href="https://samuiluxurycollection.com/villas/beachfront-villas/">Beachfront Villas</a> </li>
<li id='mobile-menu-item-3106'  class="menu-item menu-item-type-taxonomy menu-item-object-room_categories" data-depth='1'><a  href="https://samuiluxurycollection.com/villas/ocean-view-villas/">Ocean View Villas</a> </li>
<li id='mobile-menu-item-3155'  class="menu-item menu-item-type-taxonomy menu-item-object-room_categories" data-depth='1'><a  href="https://samuiluxurycollection.com/villas/kids-friendly-villas/">Kids Friendly Villas</a> </li>
<li id='mobile-menu-item-3107'  class="menu-item menu-item-type-taxonomy menu-item-object-room_categories" data-depth='1'><a  href="https://samuiluxurycollection.com/villas/pet-friendly-rooms/">Pet Friendly Villas</a> </li>
</ul>
</li>
<li id='mobile-menu-item-3122'  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children" data-depth='0'><a  href="#">EXPERIENCES</a> 
<ul class="sub-menu">
<li id='mobile-menu-item-3047'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/activities/">Activities</a> </li>
<li id='mobile-menu-item-4240'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/foodie-experiences/">Foodie Experiences</a> </li>
<li id='mobile-menu-item-3054'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/weddings/">Weddings &#038; Events</a> </li>
</ul>
</li>
<li id='mobile-menu-item-4451'  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children" data-depth='0'><a  href="#">ABOUT US</a> 
<ul class="sub-menu">
<li id='mobile-menu-item-4441'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/about-us/">Few Words About SILK</a> </li>
<li id='mobile-menu-item-3049'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/our-team/">Our Team</a> </li>
<li id='mobile-menu-item-3050'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/testimonials/">Testimonials</a> </li>
<li id='mobile-menu-item-3956'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/media-press/">Media &#038; Press</a> </li>
<li id='mobile-menu-item-4137'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/list-with-us/">List With Us</a> </li>
<li id='mobile-menu-item-3048'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/contact-us/">Contact Us</a> </li>
</ul>
</li>
<li id='mobile-menu-item-3026'  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children" data-depth='0'><a  href="#">GALLERY</a> 
<ul class="sub-menu">
<li id='mobile-menu-item-3960'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/koh-samui-photo-gallery/">Koh Samui</a> </li>
<li id='mobile-menu-item-4135'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/villa-inspiration/">Villa Inspiration</a> </li>
<li id='mobile-menu-item-3962'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/guest-photo-gallery/">Guest Photo Gallery</a> </li>
</ul>
</li>
<li id='mobile-menu-item-3060'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='0'><a  href="https://samuiluxurycollection.com/visit-samui-magazine/">BLOG</a> </li>
</ul>    
				</nav>
		</div>
		
	</header>



	<!-- main contents -->
	<div id="main_content">
			
<div  class="content_row row vc_row wpb_row  default-style fullwidth rt-flex-wrapper full-height-row align-columns column-align-middle rt-flex-wrapper has-bg-overlay has-bg-image" style="background-image: url(https://i1.wp.com/samuiluxurycollection.com/wp-content/uploads/2016/06/starfish-bg-1.jpg?fit=1133%2C800&ssl=1);background-repeat: no-repeat;background-size: cover;background-attachment: scroll;background-position: right bottom;">
	<div class="content-row-video-overlay" style="background-color:rgba(0,0,0,0.15)"></div>

	<div class="content_row_wrapper align-contents content-align-middle default" style="padding-top:100px;padding-bottom:100px;">
	<div id="asdasd" class="vc_col-sm-12 wpb_column vc_column_container custom_bg" >
	<div class="vc_column-inner">
		<div class="wpb_wrapper"  style="padding-top:80px;padding-bottom:80px;padding-left:40px;padding-right:40px;background-color: #ffffff;">
			<div class="rt_heading_wrapper style-3">
						<h3 class="rt_heading  style-3"><?php echo $defaultHeading; ?></h3> 
					</div><div class="vc_empty_space"   style="height: 50px" ><span class="vc_empty_space_inner"></span></div>
                    
<div role="form" class="wpcf7" id="wpcf7-f2687-p2905-o1" lang="en-US" dir="ltr">
<div class="screen-reader-response"></div>
<!-- Start Main Content -->
<?php if($defaultContent == 'form'): ?>
<form action="/reservation-sent.html" id="aspnetForm" name="aspnetForm" method="post">
    <div style="display: none;">
    <input type="hidden" id="villaID" name="villaID" value="<?php echo $vid;?>"/>
    <input type="hidden" id="hidVillaName" name="hidVillaName" value=""/>
    <input type="hidden" id="reserve" name="reserve" value=""/>
    <input type="hidden" id="hfrurl" name="hfrurl" value=""/>
    <input type="hidden" id="hidToken" name="hidToken" value="<?php echo $md5Hash[0];?>"/>
    <input type="hidden" id="hid_cip" name="hid_cip" value="<?php echo $website->get_ip();?>"/>
    </div>
    <table class="form-table">
        <tr>
            <td colspan="2">
              <label>Name (*):</label>
              <span class="wpcf7-form-control-wrap your-name">
                <input name="txtFirstname" type="text" maxlength="25" id="txtFirstname" class="inputbox required wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" placeholder="Given Name" required pattern="[a-zA-Z0-9\s]+" oninvalid="this.setCustomValidity('Please enter alpha numeric characters')" oninput="this.setCustomValidity('')"/>
                </span>
              <span class="wpcf7-form-control-wrap your-name">
                <input name="txtLastName" type="text" maxlength="25" id="txtLastName" class="inputbox required" placeholder="Family Name" required pattern="[a-zA-Z0-9\s]+" oninvalid="this.setCustomValidity('Please enter alpha numeric characters')" oninput="this.setCustomValidity('')"/>
                </span>
            </td>
            </tr>
        <tr>
            <td colspan="2">
              <label>Email (*):</label>
                <span class="wpcf7-form-control-wrap your-email">
                <input type="email" pattern="(?!(^[.-].*|[^@]*[.-]@|.*\.{2,}.*)|^.{254}.)([a-zA-Z0-9!#$%&'*+\/=?^_`{|}~.-]+@)(?!-.*|.*-\.)([a-zA-Z0-9-]{1,63}\.)+[a-zA-Z]{1,15}" id="txtEmail" name="txtEmail" value="" maxlenght="25" class="inputbox email required" placeholder="you@yourdomain.com" required oninvalid="this.setCustomValidity('Please enter a valid email address')" oninput="this.setCustomValidity('')"/>
                </span></td>
            </tr>
        <tr>
          <td colspan="2">
          	<label>Dates:</label>
            <input name="txtArrivalDate" type="text" id="txtArrivalDate" class="inputbox" readonly placeholder="Arrival Date" required value=""/>
            <input name="txtDepartDate" type="text" id="txtDepartDate" class="inputbox" readonly placeholder="Departure Date" required value=""/>
            <label style="min-width:50px !important;">Dates are flexible:</label><input type="checkbox" id="date_flex" name="date_flex" value="Y">
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <label>Select a Villa:</label>
            <span class="wpcf7-form-control-wrap room">
            <select name="select_villa" id="select_villa" class="wpcf7-form-control wpcf7-room_list" aria-invalid="false">
              <?php foreach( $villas as $key => $value ):?>
              <?php $select = (!empty($vid)&&$vid==$key)?'selected="selected"':'';?>
              <option value="<?php echo $key;?>" <?php echo $select;?>><?php echo $value;?></option>
              <?php endforeach;?>
            </select>
            </span>
       		</td>
        </tr>
        <tr>
        <td colspan="2">
          <label>Country(*):</label>
          <span class="wpcf7-form-control-wrap country-of-residence">
            <select id="selCountry" name="selCountry" onChange="changeCode()">
            <?php
			for($c=0; $c<sizeof($countries['COUNTRY']); $c++):
				if($countries['COUNTRY'][$c]['CountryID'] == $defaultCountry):
					echo '<option value="'.$countries['COUNTRY'][$c]['CountryID'].'" selected="selected">'.$countries['COUNTRY'][$c]['Country'].'</option>';
				else:
					echo '<option value="'.$countries['COUNTRY'][$c]['CountryID'].'">'.$countries['COUNTRY'][$c]['Country'].'</option>';
				endif;
			endfor;
			?>
            </select>
          </span></td>
        </tr>
        <tr>
          	<td colspan="2">
                <label>Phone (*):</label>
                
                <input type="text" id="txtPhoneAreaCode" name="txtPhoneAreaCode" value="<?php echo $defaultCode;?>" readonly class="prefix" style="width:8%;" />
                <input type="text" id="txtPhoneNumber" name="txtPhoneNumber" value="" pattern="\d*" maxlenght="25" class="inputbox required" placeholder="Enter your phone no." required />
                <label for="txtAltNumber" style="min-width:50px;">Alt. Phone:</label>
                <input type="text" id="txtAltPhoneAreaCode" name="txtAltPhoneAreaCode" value="<?php echo $defaultCode;?>" readonly class="prefix" style="width:8%;" />
                <input type="text" id="txtAltNumber" name="txtAltNumber" value="" pattern="\d*" maxlenght="25" class="inputbox required" placeholder="Enter your alt. no.">
                
        	</td>
        </tr>
        
    <tr>
    <td width="141"><label style="min-width:90px;">No. of Guests:</label></td>
    <td width="645"><label style="min-width:50px;">Adults:</label>
      <select name="numAdult" id="numAdult" class="wpcf7-form-control wpcf7-select" aria-invalid="false">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="10+">10+</option>
      </select>
      <label style="min-width:60px;">Children (2-11):</label>
      <select name="numChildren" id="numChildren" class="wpcf7-form-control wpcf7-select" aria-invalid="false">
        <option value="0">0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="10+">10+</option>
      </select>
      <label style="min-width:60px;">Infants (2-11yrs):</label>
      <select id="numInfant" name="numInfant" class="wpcf7-form-control wpcf7-select" aria-invalid="false">
        <option value="0">0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="10+">10+</option>
      </select>
     </td>
    </tr>
    <tr>
    <td colspan="2"><hr/></td>
    </tr>
    <tr>
    <td colspan="2">
    	<label>Should this villa not be available, would you like details on other similar villas?:</label>
        <input type="checkbox" id="alternatives" name="alternatives" value="Y">
    </td>
    </tr>
    <tr>
      <td colspan="2"><label for="txtMessage">Questions and special requests:</label></td>
    </tr>
    <tr>
    <td colspan="3">
    <textarea name="txtMessage" rows="5" cols="20" id="txtMessage" class="inputbox_textarea" placeholder="Place your requests, message here..." pattern="[a-zA-Z0-9\s]+" maxlength="550" style="margin: 0px;width: 690px;height:150px;"></textarea>
    </td>
    </tr>
    <tr>
    <td colspan="3"><input type="submit" id="btnSend" name="btnSend" value="Send" class="" /></td>
    </tr>
    </table>
<div class="wpcf7-response-output wpcf7-display-none"></div>
</form>
<?php else:?>
	<?php echo $content; ?>
<?php endif;?>
<!-- End Main Content -->
</div>
		</div>
	</div>
	</div>

</div>
</div>

							

			

			

				

	 

</div><!-- / end #main_content -->

<!-- footer -->
<footer id="footer" class="clearfix footer">
	<section class="footer_widgets content_row row clearfix footer border_grid fixed_heights footer_contents fullwidth"><div class="content_row_wrapper clearfix default-footer-width">
	<div id="footer-column-1" class="col col-xs-12 col-md-6 widgets_holder">
		<div class="column-inner">
<div class="footer_widget widget widget_text"><h5>Stay Connected</h5>			<div class="textwidget"><p>Subscribe to our email newsletters and receive exclusive access to our ‘little black book’ – filled with unique travel experiences, the most luxurious private holiday villa rentals, news and events with flair.

Come on a journey with us and receive your backstage pass to the finest Koh Samui has to offer! </p>
<br />
<div role="form" class="wpcf7" id="wpcf7-f2736-o2" lang="en-US" dir="ltr">
<div class="screen-reader-response"></div>
<form action="/booking-form/#wpcf7-f2736-o2" method="post" class="wpcf7-form" novalidate>
<div style="display: none;">
<input type="hidden" name="_wpcf7" value="2736" />
<input type="hidden" name="_wpcf7_version" value="5.0.5" />
<input type="hidden" name="_wpcf7_locale" value="en_US" />
<input type="hidden" name="_wpcf7_unit_tag" value="wpcf7-f2736-o2" />
<input type="hidden" name="_wpcf7_container_post" value="0" />
</div>
<div class="row subscription-form inline">
<div class="col col-xs-6 col-sm-8"><span class="wpcf7-form-control-wrap your-email"><input type="email" name="your-email" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" aria-required="true" aria-invalid="false" placeholder="Your Email" /></span></div>
<div class="col col-xs-6 col-sm-4"><input type="submit" value="Subscribe" class="wpcf7-form-control wpcf7-submit" /></div>
</div>
<div class="wpcf7-response-output wpcf7-display-none"></div></form></div></div>
		</div>		</div>
	</div>
	<div id="footer-column-2" class="col col-xs-12 col-md-3 widgets_holder">
		<div class="column-inner">
<div class="footer_widget widget widget_social_media_icons"><ul class="social_media"><li class="mail"><a class="icon-mail" target="_self" href="mailto:stay@samuiluxury.villas" title="Email"><span>Email</span></a></li><li class="twitter"><a class="icon-twitter" target="_blank" href="https://twitter.com/SILKKohSamui" title="Twitter"><span>Follow us on Twitter</span></a></li><li class="facebook"><a class="icon-facebook" target="_blank" href="https://www.facebook.com/samuiluxurycollection/" title="Facebook"><span>Follow us on Facebook</span></a></li><li class="gplus"><a class="icon-gplus" target="_blank" href=" https://plus.google.com/u/0/102592540637452058473" title="Google +"><span>Follow us on Google+</span></a></li><li class="linkedin"><a class="icon-linkedin" target="_blank" href="https://www.linkedin.com/company/silk-koh-samui/" title="Linkedin"><span>Career Opportunities</span></a></li><li class="instagram"><a class="icon-instagram" target="_blank" href="https://www.instagram.com/samuiluxurycollection/" title="Instagram"><span>Follow us on Instagram</span></a></li><li class="youtube-play"><a class="icon-youtube-play" target="_blank" href="https://www.youtube.com/channel/UCw3ue10iS2gi_8kNGwg34ig" title="YouTube"><span>Subscribe to our YouTube Channel</span></a></li></ul></div>		</div>
	</div>
	<div id="footer-column-3" class="col col-xs-12 col-md-3 widgets_holder">
		<div class="column-inner">
<div class="footer_widget widget widget_contact_info"><h5>Contact Info</h5><div class="with_icons style-1"><div><span class="icon icon-home"></span><div>45/22 Moo 5, Bophut Koh Samui, Suratthani, Thailand 84320</div></div><div><span class="icon icon-phone"></span><div>+66 (0) 77 423 766  </div></div><div><span class="icon icon-mobile"></span><div>+66 (0) 614 219 955</div></div><div><span class="icon icon-mail-1"></span><div><a href="mailto:stay@samuiluxury.villas">stay@samuiluxury.villas</a></div></div><div><span class="icon icon-map"></span><div><a href="https://www.google.com/maps/place/Samui+Luxury+Collection+Co.+Ltd+(SILK)/@9.566871,100.070635,14z/data=!4m5!3m4!1s0x0:0x1350519d5192f3ba!8m2!3d9.566871!4d100.070635?hl=en-US" title="Find us on map" target="_self">Find us on map</a></div></div></div></div>		</div>
	</div>
</div></section>
<div class="content_row row clearfix footer_contents footer_info_bar fullwidth"><div class="content_row_wrapper clearfix default-footer-width"><div class="copyright ">Copyright © SILK - Samui Luxury Collection Co. Ltd.</div><ul id="footer-navigation" class="menu"><li id="menu-item-3289" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3289"><a href="https://samuiluxurycollection.com/list-with-us/">List With Us</a></li>
<li id="menu-item-4462" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4462"><a href="https://owner.klik.villas">Villa Owners</a></li>
<li id="menu-item-3274" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3274"><a href="https://samuiluxurycollection.com/faqs/">FAQS</a></li>
<li id="menu-item-4094" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4094"><a href="https://samuiluxurycollection.com/terms/">Terms</a></li>
</ul> </div></div></footer><!-- / end #footer -->

</div><!-- / end #container --> 

<div class="full-screen-menu-holder">
<span class="full-screen-menu-close icon-cancel"></span>
<div class="full-screen-menu-wrapper">
<div class="full-screen-menu-contents">
<ul id="fullscreen_navigation" class="menu"><li id='fs-menu-item-3037'  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children" data-depth='0'><a  href="#">LUXURY HOLIDAY VILLAS</a> 
<ul class="sub-menu">
<li id='fs-menu-item-3369'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/bespoke-holiday-villa-collection/">All Luxury Holiday Villas</a> </li>
<li id='fs-menu-item-3105'  class="menu-item menu-item-type-taxonomy menu-item-object-room_categories" data-depth='1'><a  href="https://samuiluxurycollection.com/villas/beachfront-villas/">Beachfront Villas</a> </li>
<li id='fs-menu-item-3106'  class="menu-item menu-item-type-taxonomy menu-item-object-room_categories" data-depth='1'><a  href="https://samuiluxurycollection.com/villas/ocean-view-villas/">Ocean View Villas</a> </li>
<li id='fs-menu-item-3155'  class="menu-item menu-item-type-taxonomy menu-item-object-room_categories" data-depth='1'><a  href="https://samuiluxurycollection.com/villas/kids-friendly-villas/">Kids Friendly Villas</a> </li>
<li id='fs-menu-item-3107'  class="menu-item menu-item-type-taxonomy menu-item-object-room_categories" data-depth='1'><a  href="https://samuiluxurycollection.com/villas/pet-friendly-rooms/">Pet Friendly Villas</a> </li>
</ul>
</li>
<li id='fs-menu-item-3122'  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children" data-depth='0'><a  href="#">EXPERIENCES</a> 
<ul class="sub-menu">
<li id='fs-menu-item-3047'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/activities/">Activities</a> </li>
<li id='fs-menu-item-4240'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/foodie-experiences/">Foodie Experiences</a> </li>
<li id='fs-menu-item-3054'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/weddings/">Weddings &#038; Events</a> </li>
</ul>
</li>
<li id='fs-menu-item-4451'  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children" data-depth='0'><a  href="#">ABOUT US</a> 
<ul class="sub-menu">
<li id='fs-menu-item-4441'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/about-us/">Few Words About SILK</a> </li>
<li id='fs-menu-item-3049'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/our-team/">Our Team</a> </li>
<li id='fs-menu-item-3050'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/testimonials/">Testimonials</a> </li>
<li id='fs-menu-item-3956'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/media-press/">Media &#038; Press</a> </li>
<li id='fs-menu-item-4137'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/list-with-us/">List With Us</a> </li>
<li id='fs-menu-item-3048'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/contact-us/">Contact Us</a> </li>
</ul>
</li>
<li id='fs-menu-item-3026'  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children" data-depth='0'><a  href="#">GALLERY</a> 
<ul class="sub-menu">
<li id='fs-menu-item-3960'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/koh-samui-photo-gallery/">Koh Samui</a> </li>
<li id='fs-menu-item-4135'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/villa-inspiration/">Villa Inspiration</a> </li>
<li id='fs-menu-item-3962'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='1'><a  href="https://samuiluxurycollection.com/guest-photo-gallery/">Guest Photo Gallery</a> </li>
</ul>
</li>
<li id='fs-menu-item-3060'  class="menu-item menu-item-type-post_type menu-item-object-page" data-depth='0'><a  href="https://samuiluxurycollection.com/visit-samui-magazine/">BLOG</a> </li>
</ul><form method="get"  action="https://samuiluxurycollection.com//"  class="wp-search-form rt_form">
	<ul>
		<li><input type="text" class='search showtextback' placeholder="search" name="s" /><span class="icon-search-1"></span></li>
	</ul>
	</form></div>
</div>
</div>
<!--  -->
<!-- Jetpack Google Analytics -->
			<script type='text/javascript'>
				var _gaq = _gaq || [];
				_gaq.push(['_setAccount', 'UA-81484330-1']);
_gaq.push(['_trackPageview']);
				(function() {
					var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
					ga.src = ('https:' === document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
				})();
			</script>
	<div style="display:none">
	</div>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/themes/nixe/js/bootstrap.min.js?ver=4.9.8'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/themes/nixe/js/isotope.pkgd.min.js?ver=4.9.8'></script>
<script type='text/javascript' src='https://c0.wp.com/c/4.9.8/wp-includes/js/imagesloaded.min.js'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/themes/nixe/js/owl.carousel.min.js?ver=4.9.8'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/themes/nixe/js/jflickrfeed.min.js?ver=4.9.8'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/themes/nixe/js/customselect.min.js?ver=4.9.8'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/themes/nixe/js/lightgallery-all.min.js?ver=4.9.8'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/themes/nixe/js/placeholders.min.js?ver=4.9.8'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/plugins/js_composer/assets/lib/waypoints/waypoints.min.js?ver=5.4.4'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/themes/nixe/js/jquery.vide.min.js?ver=4.9.8'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/themes/nixe/js/bootstrap-datepicker.min.js?ver=4.9.8'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var rtframework_params = {"ajax_url":"https:\/\/samuiluxurycollection.com\/wp-admin\/admin-ajax.php","rttheme_template_dir":"https:\/\/samuiluxurycollection.com\/wp-content\/themes\/nixe","popup_blocker_message":"Please disable your pop-up blocker and click the \"Open\" link again.","wpml_lang":"","content_top_padding":"0","content_bottom_padding":"0","content_left_padding":"0","content_right_padding":"0","body_top_padding":"0","body_bottom_padding":"0","theme_slug":"nixe"};
/* ]]> */
</script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/themes/nixe/js/scripts.js?ver=4.9.8'></script>
<script type='text/javascript' src='https://c0.wp.com/p/jetpack/6.8/_inc/build/photon/photon.min.js'></script>

<script type='text/javascript' src='https://s0.wp.com/wp-content/js/devicepx-jetpack.js?ver=201849'></script>
<script type='text/javascript' src='https://secure.gravatar.com/js/gprofiles.js?ver=2018Decaa'></script>
<script type='text/javascript' src='https://c0.wp.com/p/jetpack/6.8/_inc/build/likes/queuehandler.min.js'></script>
<script type='text/javascript' src='https://samuiluxurycollection.com/wp-content/plugins/js_composer/assets/js/dist/js_composer_front.min.js?ver=5.4.4'></script>
<script type='text/javascript' src='https://stats.wp.com/e-201849.js' async='async' defer='defer'></script>
<script type='text/javascript'>
	_stq = window._stq || [];
	_stq.push([ 'view', {v:'ext',j:'1:6.8',blog:'138118550',post:'2905',tz:'7',srv:'samuiluxurycollection.com'} ]);
	_stq.push([ 'clickTrackerInit', '138118550', '2905' ]);
</script>

<script type="text/javascript">
jQuery(document).ready(function(){
    
    /* Datepicker */
    var aday = 86400000;
    var today = new Date();
    var tomorrow = new Date(today.getTime() + aday);

    var minDate = false;
    var maxDate = false;
    
    //jQuery.datepicker.setDefaults({dateFormat: "d MM yy", changeMonth: true, changeYear: true});
    jQuery("#txtArrivalDate").datepicker({
        dateFormat: "d MM yy",
        changeYear: true,
        minDate: today,
        onSelect: function (date) {
            var dt2 = jQuery('#txtDepartDate');
            minDate = jQuery(this).datepicker('getDate');
            maxDate = dt2.datepicker('getDate');

            var nextDate = new Date(minDate.getTime() + aday);

            if (!maxDate || maxDate < minDate) {
                dt2.datepicker('setDate', nextDate);
            }
            dt2.datepicker('option', 'minDate', nextDate);
        },
        onClose: function() {
            var dt2 = $('#txtDepartDate');
            if (!maxDate && minDate) {
                dt2.datepicker("show");
            }
        }
    });
    var hasDate = jQuery("#txtArrivalDate").val();
    if (hasDate) {
        tomorrow = jQuery("#txtArrivalDate").datepicker('getDate');
    }   

    jQuery("#txtDepartDate").datepicker({
        dateFormat: 'dd MM yy',
        changeMonth: false,
        changeYear: false,
        minDate: tomorrow
    });
});

function generateToken(){
	var host="http://"+window.location.hostname;
	jQuery.ajax({
		type:"POST",
		url:host+"/genToken.php",
		dataType:'text',
		error:function(data){
			console.log('Token Generation Failed. Returned: '+data)},
		success:function(data){
			jQuery("#hidToken").val(data);
		}
	});
}
function changeCode(){
	var cntry=jQuery("#selCountry").val();
	var host="http://"+window.location.hostname;
	jQuery("#txtPhoneAreaCode, #txtAltPhoneAreaCode").val('[...]');
	jQuery.ajax({
		type:"POST",url:host+"/changeCode.php",
		data:"c="+cntry,
		error:function(data){
			alert('Country Code Change Failed');
		},
		success:function(data){
			jQuery("#txtPhoneAreaCode, #txtAltPhoneAreaCode").val(data);
		}
	});
}

if(typeof document.forms['aspnetForm']!=='undefined'){
	var submitButton=document.forms['aspnetForm'].querySelector("button:not([type=button]), input[type=submit]");
	submitButton.addEventListener("click",function(event){generateToken();
	});
}

function callback()
{
	if(jQuery("#btnGeneralEnquiries").length){
		jQuery("#btnGeneralEnquiries").removeAttr("disabled");
	}
	if(jQuery("#btnSend").length){
		jQuery("#btnSend").removeAttr("disabled");
	}
}

</script>
</body>
</html>