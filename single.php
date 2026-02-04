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

<div class="p-news-detail">
  <div class="p-news-detail__back-to-list">
    <a class="p-news-detail__back-to-list-button" href="/news/">一覧に戻る</a>
  </div>
  <div class="p-news-detail__main">
    <h1 class="p-news-detail__title"><?php the_title(); ?></h1>
    <div class="p-news-detail__info">
      <span class="p-news-detail__date"><?php echo get_the_date(); ?></span>
      <div class="p-news-detail__category">
        <?php
          foreach ((get_the_category()) as $cat) {
            echo '<span class="p-news-detail__category-item">' . $cat->cat_name . '</span>';
          }
        ?>
      </div>
    </div>
    <?php if (has_post_thumbnail()): ?>
      <div class="p-news-detail__eyecatch" id="js-eyecatch">
        <?php
          the_post_thumbnail('full', array(
            'alt' => get_the_title(),
            'decoding' => 'async',
            'data-parallax' => 'true',
          ));
        ?>
      </div>
    <?php endif; ?>
    <div class="p-news-detail__article-body c-wp-contents">
      <?php the_content(); ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>