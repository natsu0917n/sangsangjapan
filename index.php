<?php get_header(); ?>

<div class="c-under-kv" id="js-under-kv">
  <div class="c-under-kv__page-title">
    <h1 class="c-under-kv__title-small" id="js-under-kv-title">お知らせ</h1>
    <span class="c-under-kv__title-large">News</span>
  </div>
  <ul class="c-under-kv__bread">
    <li class="c-under-kv__bread-item">
      <a class="c-under-kv__bread-item-text" href="<?php echo home_url('/'); ?>">Home</a>
    </li>
    <li class="c-under-kv__bread-item -current">
      <span class="c-under-kv__bread-item-text">News</span>
    </li>
  </ul>
</div>

<div class="p-news-list">
  <aside class="p-news-list__side">
    <span class="p-news-list__side-category-item -current">すべて</span>
    <?php 
      $args = array(
        'orderby' => 'menu_order',
        'parent' => 0,
      );
      $categories = get_categories($args);
      if (is_array($categories)) {
        foreach ($categories as $category) {
          $cat_id = $category->cat_ID;
          $cat_title = $category->cat_name;
          $cat_url = get_category_link($cat_id);
          echo "<a class='p-news-list__side-category-item' href='{$cat_url}'>{$cat_title}</a>";
        }
      }
    ?>
  </aside>
  <div class="p-news-list__main">
    <div class="p-news-list__articles">
      <?php if (have_posts()): while (have_posts()): the_post(); ?>
        <a class="c-article" href="<?php the_permalink(); ?>">
          <div class="c-article__thumbnail">
            <div class="c-article__thumbnail-inner">
              <?php if (has_post_thumbnail()) : ?>
                <?php
                  the_post_thumbnail('large', array(
                    'alt' => get_the_title(),
                    'decoding' => 'async',
                    'data-parallax' => '',
                  ));
                ?>
              <?php else: ?>
                <img
                  src="<?php echo get_template_directory_uri(); ?>/src/images/img_article_thumbnail_blank.svg"
                  alt="<?php the_title(); ?>"
                  height="179"
                  width="238"
                  loading="lazy"
                >
              <?php endif; ?>
            </div>
          </div>
          <div class="c-article__contents">
            <div class="c-article__info">
              <time class="c-article__date" datetime="<?php echo get_the_date(); ?>"><?php echo get_the_date(); ?></time>
              <div class="c-article__category">
                <?php
                  foreach ((get_the_category()) as $cat) {
                    $category_name = ucfirst($cat->cat_name);
                    echo "<span class='c-article__category-item'>{$category_name}</span>";
                  }
                ?>
              </div>
            </div>
            <span class="c-article__title"><?php the_title(); ?></span>
          </div>
        </a>
      <?php endwhile; endif; ?>
    </div>
    <?php do_shortcode('[pagination]') ?>
  </div>
</div>

<?php get_footer(); ?>