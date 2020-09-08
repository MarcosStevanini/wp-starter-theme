<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
  <label>
    <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label' ) ?></span>
    <input type="search" class="search-field" 
      placeholder="Pesquisar..." 
      value="<?php echo get_search_query() ?>"
      title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>"
      name="s">
  </label>
  <button type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>"><i class="far fa-search"></i></button>
</form>
