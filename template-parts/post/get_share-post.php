<div class="share-post">
  <span>Compartilhe</span>
  <ul>
    <li>
      <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>
    </li>
    <li>
      <a href="https://twitter.com/intent/tweet?text=<?php the_title() ?>%2E%20notícia%20completa%20em%3A%20&tw_p=tweetbutton&url=<?php the_permalink() ?>" class="twitter-share-button" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
    </li>
    <li>
      <a href="https://pinterest.com/pin/create/button/?url=<?php the_permalink() ?>&media=<?= has_post_thumbnail() ? wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "medium" )[0] : '' ?>&description=<?php the_title() ?>" target="_blank" rel="noopener"><i class="fab fa-pinterest-p"></i></a>
    </li>
    <li>
      <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink() ?>&title=&summary=<?php the_title() ?>&source=" target="_blank" rel="noopener"><i class="fab fa-linkedin-in"></i></a>
    </li>
  </ul>
</div>