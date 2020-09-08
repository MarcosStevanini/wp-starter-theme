<?php
/**
 * Add HTML5 theme support.
 */
function wp_after_setup_theme() {
  add_theme_support( 'html5', array( 'search-form', 'style', 'script' ) );
}
add_action( 'after_setup_theme', 'wp_after_setup_theme' );


/**
 * Wp head add The OpenGraph
 */
function get_og_protocol() { 
	$src = '';

	if ( has_post_thumbnail(get_the_ID()) ) {

		$src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), "full" )[0];

	} elseif ( function_exists('get_field') ) {
		
		$src = get_field('wpdevhelperWPHead-apple_touch_icon-iphone', 'option');

	}
	?>
	<meta property="og:image" content="<?php echo $src ?>"/>  
	<meta property="og:title" content="<?php echo is_front_page() ? '' : wp_title('', false).' | '; bloginfo('name'); ?>"/>  
	<meta property="og:url" content="<?php the_permalink() ?>" />
	<meta property="og:type" content="<?php echo is_single() ? 'article' : 'website' ?>" />
	<meta property="og:locale" content="<?php bloginfo( 'language' ) ?>">
	<meta property="og:site_name" content="<?php bloginfo( 'name' ) ?>">
<?php
}
add_action('wp_head', 'get_og_protocol', 2);


/**
 * UPDATE WORDPRESS LOGIN LOGO DARK
 */
function wp_custom_logo_in_login() { ?>
<style type="text/css">
#login h1 a, .login h1 a {background-image:url('https://comet-space.nyc3.digitaloceanspaces.com/assets/default/logo-inova-circle-pink.png');background-repeat:no-repeat;background-size: 120px;height:120px;width:120px;}body{background:#141414!important}.login #backtoblog a,.login #nav a{color:#adadad!important}.login #login_error,.login .message,.login .success,.login form{border-radius:10px}.wp-core-ui .button-primary{background:#000!important;border-color:#000!important;box-shadow:none!important;color:#fff!important;text-decoration:none!important;text-shadow:none!important;border-radius:0!important;}input[type=text]:focus, input[type=password]:focus {  border-color: #ff0083 !important;
  box-shadow: none !important;}
</style>
<?php } add_action( 'login_enqueue_scripts', 'wp_custom_logo_in_login' );


/**
 * remove some styles
 */
function wc_remove_block_library_css(){
	if (!is_admin()) {
		wp_dequeue_style( 'wc-block-style' );
		wp_dequeue_style( 'wp-block-library' );
	}
} 
add_action( 'wp_enqueue_scripts', 'wc_remove_block_library_css' );


/**
 * Show the page name
 */
function the_title_page() {
	if (is_404()) {
		echo 'Página não encontrada';

	} elseif (is_tag()) {
		single_tag_title();
		
	} elseif (is_category()) {
		single_cat_title();

	} elseif (is_tax()) {
		$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
		echo $term->name;

	} elseif (is_day()) {
		echo "Arquivo de " . get_the_time('j \d\e F \d\e Y');

	} elseif (is_month()) {
		echo "Arquivo de " . get_the_time('F \d\e Y');

	} elseif (is_year()) {
		echo "Arquivo de " . get_the_time('Y');

	} elseif (is_author()) {
		echo "Arquivo do autor";

	} elseif (isset($_GET['p']) && !empty($_GET['p'])) {
		echo "Arquivo do blog";

	} elseif (is_search()) {
		echo "Resultados da pesquisa";
		
	} else {
		the_title();
	}
}


/**
 * Support Facebook comments
 */
function support_comments_facebook($order = 'footer', $num_posts = 9, $language = 'pt_BR') {
	if (is_single()) :
		if ($order == 'post') : ?>

			<div class="comment-box">
				<div class="fb-comments" data-href="<?php the_permalink() ?>" data-width="100%" data-numposts="<?= $num_posts ?>"></div>
			</div>  

		<?php elseif ($order == 'footer') : ?>

			<div id="fb-root"></div>
			<script async defer crossorigin="anonymous" src="https://connect.facebook.net/<?= $language ?>/sdk.js#xfbml=1&version=v7.0"></script>

			<script>
				jQuery(function() {
					function fluidComments() {
						var $myWrap = $(".comment-box");
						width = $myWrap.width();

						$(".fb-comments").attr("data-width", width);
						if ($(".fb-comments iframe").length == 1) FB.XFBML.parse();
					}

					$(function () {
						fluidComments();
					});

					var progresso;
					window.onresize = function () {
						clearTimeout(progresso);
						progresso = setTimeout(fluidComments, 100);
					};
				});
			</script>
		
	<?php endif;
	endif;
}


/**
 * Pagination in loop posts
 */
function get_pagination($current_page, $pages_count, $maxLinks = 2) {
	wp_reset_query();
	$args = '';

	if (is_search()) {
		$args .= 's=' . get_search_query() . '&';
		$url = get_bloginfo('url');

	} elseif (is_category()) {
		$url = get_category_link(get_queried_object()->term_id);

	} elseif(is_tax()) {
		$url = get_term_link(get_queried_object()->term_id);
		
	} elseif (is_tag()) {
		$url = get_tag_link(get_queried_object()->term_id);
	
	} elseif (is_day()) {
		$url = get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d'));
	
	} elseif (is_month()) {
		$url = get_month_link(get_the_time('Y'), get_the_time('m'));
	
	} elseif (is_year()) {
		$url = get_year_link(get_the_time('Y'));
	
	} elseif (is_author()) {
		$url = get_author_posts_url(get_queried_object()->term_id);
		
	} else {
		$url  = get_the_permalink(get_the_ID());
	}

	$url = esc_url($url) . '?' . $args;
	
	if( $pages_count > 0 ) : ?>
		<nav aria-label="Page navigation">
			<ul class="pagination">
				<?php
				echo '<li class="page-item"><a class="page-link" href="'.$url.'pg=1" aria-label="Previous"><span>&laquo;</span></a></li>';
				
				for($i = $current_page - $maxLinks; $i <= $current_page - 1; $i++):
					if($i >= 1):
						echo '<li><a class="page-link" href="'.$url.'pg='.$i.'">'.$i.'</a></li>';
					endif;
				endfor;

				echo '<li class="page-item active"><a class="page-link" href="'.$url.'pg='.$current_page.'"> '.$current_page.'</a></li>';
				
				for($i = $current_page + 1; $i <= $current_page + $maxLinks; $i++):
					if($i <= $pages_count):
						echo '<li class="page-item"><a class="page-link" href="'.$url.'pg='.$i.'">'.$i.'</a></li>';
					endif;
				endfor;

				echo '<li class="page-item"><a class="page-link" href="'.$url.'pg='.$pages_count.'" aria-label="Next"><span>&raquo;</span></a></li>';
				?>
			</ul>
		</nav>
<?php endif;
}


/**
 * Supost Thumbnals
*/
add_theme_support( 'post-thumbnails' );
