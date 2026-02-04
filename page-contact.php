<?php
/**
 * Template Name: Contact
 */
  $page = get_page(get_the_ID());
  $search = array('-', '_');
  $replace = array(' ', ' ');
  $slug = str_replace($search, $replace, $page->post_name);
  get_header();
?>

<div class="c-under-kv" id="js-under-kv">
  <div class="c-under-kv__page-title">
    <h1 class="c-under-kv__title-small" id="js-under-kv-title"><?php echo the_title(); ?></h1>
    <span class="c-under-kv__title-large"><?php echo ucwords($slug); ?></span>
  </div>
  <ul class="c-under-kv__bread">
    <li class="c-under-kv__bread-item">
      <a class="c-under-kv__bread-item-text" href="<?php echo home_url('/'); ?>">Home</a>
    </li>
      <?php foreach(array_reverse(get_post_ancestors($post->ID)) as $parid): ?>
        <li class="c-under-kv__bread-item">
          <a
            class="c-under-kv__bread-item-text"
            href="<?php echo get_page_link($parid);?>"
          ><?php echo ucwords(str_replace($search, $replace, get_page($parid)->post_name)); ?></a>
        </li>
      <?php endforeach; ?>
    <li class="c-under-kv__bread-item -current">
      <span class="c-under-kv__bread-item-text"><?php echo ucwords($slug); ?></span>
    </li>
  </ul>
</div>

<div class="p-contact">
  <?php the_content(); ?>
</div>

<?php get_footer(); ?>
