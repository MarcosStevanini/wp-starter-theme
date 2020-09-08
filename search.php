<?php
get_header();

$search = get_search_query();

if ( isset($search) && $search != '' ) {
  $search_post_type = array('post');
  $args_total_posts = array(
    'post_type'      => $search_post_type,
    'posts_per_page' => -1,
    's'              => $search,
    '_meta_or_title' => $search
  ); // total posts search

  $posts_total    = new WP_Query($args_total_posts);
  $posts_count    = $posts_total->post_count; // total de posts
  $posts_per_page = 9;
  $pages_count    = ceil($posts_count / $posts_per_page);
  $current_page   = ( isset($_GET['pg']) && $_GET['pg'] > 1 && $_GET['pg'] <= $pages_count ) ? $_GET['pg'] : 1;

  $args = array(
    'post_type'      => $search_post_type,
    'orderby'        => 'id',
    'posts_per_page' => $posts_per_page,
    'order'          => 'DESC',
    'paged'          => $current_page,
    's'              => $search,
    '_meta_or_title' => $search);
  $query_search = new WP_Query($args);
}
?>


<section class="search">
  <div class="container">
    <?php
    if ( isset($search) && $search != '' ) :

      if ( $query_search->have_posts() ) : ?>

        <div class="row">
          <div class="col-md-12">
            <h2 class="title-search">Resultados relacionados com '<?= $search ?>'</h2>
            <?php get_search_form() ?>
            <p class="total-results"><?= $posts_count ?> resultados encontrados.</p>
            <hr>
          </div>
        </div>

        <div class="row justify-content-center">
          <?php
          /*----------  Loop  ----------*/
          while ( $query_search->have_posts() ) :
            $query_search->the_post(); ?>

            <?php get_template_part('template-parts/post/content-post') ?>

          <?php endwhile; ?>
        </div>

        <?php get_pagination($current_page, $pages_count); ?>

      <?php else: ?>

        <div class="row">
          <div class="col-md-12 text-center">
            <?php get_search_form() ?>
            <div class="alert alert-warning" role="alert">
              Nenhuma informação com o nome <b><?= $search ?></b> foi encontrada.
            </div>
          </div>
        </div>

      <?php endif; wp_reset_postdata();

    else: ?>

    <div class="row">
      <div class="col-md-12 text-center">
        <?php get_search_form() ?>
        <div class="alert alert-danger" role="alert">
          Nenhuma informação foi encontrada, você deve digitar o que busca.
        </div>
      </div>
    </div>

    <?php
    endif; ?>
  </div><!-- /.container -->
</section><!-- section end -->


<?php get_footer() ?>
