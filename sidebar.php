<div class="col-lg-4">
  <aside class="sidebar">

    <div class="widget">
      <h2>Buscar no site</h2>
      <?php get_search_form(); ?>
    </div>

    <div class="widget">
      <h2>Categorias</h2>
      <?php get_template_part('template-parts/sidebar/get_categories'); ?>
    </div>

    <?php get_template_part('template-parts/sidebar/get_tags'); ?>

    <div class="widget">
      <h2>Arquivos</h2>
      <?php get_template_part('template-parts/sidebar/get_archives'); ?>
    </div>

  </aside> <!-- /.sidebar -->
</div>