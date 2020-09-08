<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<title><?php echo is_front_page() ? '' : wp_title('', false).' | '; bloginfo('name'); ?></title>

	<?php wp_head(); ?>

</head>
<body <?php body_class() ?>>


<?php 
if ( ! (is_front_page() || is_home()) ) 
	get_template_part('template-parts/navigation/navbar');
?>