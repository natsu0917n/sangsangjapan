<?php
/**
 * headにmetaタグを出力
 */
add_action('wp_head', 'create_meta');

function create_meta() {
  if (is_front_page() || is_home() || is_singular()) {
    global $post;
    $meta_title = '';
    $meta_desc = '';
    $ogp_url = '';
    $ogp_img = '';
    $insert = '';

    if (is_front_page() || is_home()) {
      //トップページ
      $meta_title = get_bloginfo('name');
      $meta_desc = get_bloginfo('description');
      $ogp_url = home_url();
    } elseif (is_singular()) {
      //投稿ページ＆固定ページ
      setup_postdata($post);
      $meta_title = $post->post_title . ' | ' . get_bloginfo('name');
      $meta_desc = mb_substr(get_the_excerpt(), 0, 100);
      $ogp_url = get_permalink();
      wp_reset_postdata();
    }

    //og:type
    $ogp_type = (is_front_page() || is_home()) ? 'website' : 'article';

    //og:image
    if (is_singular() && has_post_thumbnail()) {
      $ps_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
      $ogp_img = $ps_thumb[0];
    } else {
      $ogp_img = get_template_directory_uri() . '/src/img/ogimage.jpg';
    }

    //出力するOGPタグ
    $insert .= '<title>'.esc_attr($meta_title).'</title>' . "\n";
    $insert .= '<meta property="og:image" content="'.esc_url($ogp_img).'" />' . "\n";
    $insert .= '<meta property="og:image:secure_url" content="'.esc_url($ogp_img).'" />' . "\n";
    $insert .= '<meta property="twitter:image" content="'.esc_url($ogp_img).'" />' . "\n";
    echo $insert;
  }
}

/**
 * CSS読み込み
 */
function load_css() {
  wp_enqueue_style('style', get_template_directory_uri() . '/dist/css/style.css', array(), filemtime(__dir__ . '/dist/css/style.css'));

  // 不要なCSSは読み込まないようにする
  wp_deregister_style('wp-block-library');
  wp_deregister_style('global-styles');
}
add_action('wp_enqueue_scripts', 'load_css');

/**
 * JavaScript読み込み
 */
function load_js() {
  // 共通
  wp_enqueue_script(
    '_common',
    get_template_directory_uri() . '/dist/js/common.js',
    array(),
    filemtime(__dir__ . '/dist/js/common.js'),
    true
  );

  // フロントページ
  if (is_front_page()) {
    wp_enqueue_script(
      '_front-page',
      get_template_directory_uri() . '/dist/js/front-page.js',
      array(),
      filemtime(__dir__ . '/dist/js/front-page.js'),
      true
    );
  }

  // 固定ページ
  if (is_page() && !is_front_page()) {
    wp_enqueue_script(
      '_page',
      get_template_directory_uri() . '/dist/js/page.js',
      array(),
      filemtime(__dir__ . '/dist/js/page.js'),
      true
    );
  }

  // 投稿ページ
  if (get_post_type() === 'post') {
    wp_enqueue_script(
      '_post',
      get_template_directory_uri() . '/dist/js/post.js',
      array(),
      filemtime(__dir__ . '/dist/js/post.js'),
      true
    );
  }

  // 飲食店事業ページ
  if (is_page('shops')) {
    wp_enqueue_script(
      '_shops',
      get_template_directory_uri() . '/dist/js/shops.js',
      array(),
      filemtime(__dir__ . '/dist/js/shops.js'),
      true
    );
  }
}
add_action('wp_enqueue_scripts', 'load_js');

/**
 * アイキャッチサムネイル
 */
add_theme_support('post-thumbnails');
add_image_size('thumb100',100,100,true);
add_image_size('thumb110',110,110,true);

/**
 * search-〇〇.phpを使用するための記述
 */
add_filter('template_include','custom_search_template');
function custom_search_template($template){
  if (is_search()) {
    $post_types = get_query_var('post_type');
    foreach ((array) $post_types as $post_type)
    $templates[] = 'search-{$post_type}.php';
    $templates[] = 'search.php';
    $template = get_query_template('search',$templates);
  }
  return $template;
}

/**
 * 検索結果に投稿ページのみ表示
 */
function SearchFilter($query) {
  if ($query->is_search) {
    $query->set('post_type', array('post', 'page'));
  }
  return $query;
}
add_filter('pre_get_posts','SearchFilter');

/**
 * ユーザーが検索したワードをハイライト
 */
function wps_highlight_results($text) {
  if (is_search()) {
    $sr = get_query_var('s');
    $keys = explode(" ",$sr);
    $text = preg_replace('/(' . implode('|', $keys) . ')/iu', '<span class="search-highlight">' . $sr . '</span>', $text);
  }
  return $text;
}

if (!is_admin()) {
  add_filter('the_title', 'wps_highlight_results');
  add_filter('the_content', 'wps_highlight_results');
}

/**
 * RSS
 */
add_theme_support('automatic-feed-links');

/**
 * コンテンツエディタ周り
 */
// クラシックエディタ(ビジュアルエディタ)にCSSを反映
add_theme_support('editor-style');
add_editor_style('./dist/css/editor-style.css');

// エディタのiframe内のbody要素にクラスを追加
function custom_editor_settings($initArray){
  global $typenow;
  global $post;
  $parent_id = $post->post_parent;
  if (get_post_meta($parent_id, '_wp_page_template', true) === 'page-templates/treatment-archive.php') {
    $initArray['body_class'] = 'editor-area-page c-treatment-contents';
  } elseif ($typenow == 'page') { // 固定ページの場合
    $initArray['body_class'] = 'editor-area-page';
  } else { // 投稿ページの場合
    $initArray['body_class'] = 'editor-area-post p-article-detail__body c-wp-contents';
  }
  return $initArray;
}
add_filter('tiny_mce_before_init', 'custom_editor_settings');

// キャッシュを削除
function extend_tiny_mce_before_init($mce_init){
  $mce_init['cache_suffix'] = 'v=' . time();
  return $mce_init;    
}
add_filter('tiny_mce_before_init', 'extend_tiny_mce_before_init');

// エディタにカスタムスタイルを追加
function tiny_style_formats($settings) {
  $style_formats = array(
    array(
      'title' => '見出し1',
      'block' => 'h2',
    ),
    array(
      'title' => '見出し2',
      'block' => 'h3',
    ),
    array(
      'title' => '見出し3',
      'block' => 'h4',
    ),
    array(
      'title' => '段落テキスト',
      'block' => 'p',
    ),
    array(
      'title' => 'リンクボタン',
      'inline' => 'a',
      'classes' => 'c-button',
      'attributes' => array(
        'href' => '#'
      ),
      'wrapper' => true,
    ),
    array(
      'title' => 'スタイルをリセット',
      'selector' => '*',
      'remove' => 'all',
    ),
  );
  $settings['style_formats'] = json_encode($style_formats);
  return $settings;
}
add_filter('tiny_mce_before_init', 'tiny_style_formats');

/**
 * 画像に重ねる文字の色
 */
define('HEADER_TEXTCOLOR', '');

/**
 * 画像に重ねる文字を非表示にする
 */
define('NO_HEADER_TEXT',true);

/**
 * 投稿用ファイルを読み込む
 */
get_template_part('functions/create-thread');

/**
 * カスタム背景
 */
add_theme_support( 'custom-background' );

/**
 * ページネーション
 */
function pagination_short_code() {
  $prev = get_previous_posts_link('Prev');
  $next = get_next_posts_link('Next');
  echo '<div class="c-pagination">';
  if ($prev) echo "<div class='c-pagination__link -prev'>{$prev}</div>";
  if ($next) echo "<div class='c-pagination__link -next'>{$next}</div>";
  echo '</div>';
}
add_shortcode('pagination', 'pagination_short_code');

/**
 * 更新日の追加
 */
function get_mtime($format) {
  $mtime = get_the_modified_time('Ymd');
  $ptime = get_the_time('Ymd');
  if ($ptime > $mtime) {
    return get_the_time($format);
  } elseif ($ptime === $mtime) {
    return null;
  } else {
    return get_the_modified_time($format);
  }
}

/**
 * ショートコードを外す
 */
function stinger_noshotcode($content) {
  if (!preg_match( '/\[.+?\]/', $content, $matches)) {
    return $content;
  }
  $content = str_replace($matches[0], '', $content);
  return $content;
}

/**
 * 自動生成のpタグを削除
 */
function wpautop_filter($content) {
  global $post;
  $remove_filter = false;

  $arr_types = array('page'); //ここを変更
  $post_type = get_post_type($post->ID);
  if (in_array($post_type, $arr_types)) $remove_filter = true;

  if ($remove_filter) {
    remove_filter('the_content', 'wpautop');
    remove_filter('the_excerpt', 'wpautop');
  }

  return $content;
}
add_filter('the_content', 'wpautop_filter', 9);

/**
 * ショートコード生成
 */
function my_php_Include($params = array()) {
  extract(shortcode_atts(array('file' => 'default'), $params));
  ob_start();
  include(STYLESHEETPATH . "/$file.php");
  return ob_get_clean();
}
add_shortcode('myphp', 'my_php_Include');

/**
 * パスワード保護している記事を一覧から除外
 */
function customize_main_query($query) {
  if (!is_admin() || $query->is_main_query()) {
    if ($query->is_archive()) {
      $query->set('has_password', false);
    }
  }
}
add_action('pre_get_posts', 'customize_main_query');

/**
 * タームの説明を取得する際に自動生成されるpタグを除外
 */
remove_filter('term_description','wpautop');

/**
 * `srcset`属性でもショートコードを使用可能にする
 */
add_filter('wp_kses_allowed_html', 'my_wp_kses_allowed_html', 10, 2);
function my_wp_kses_allowed_html($tags, $context) {
	$tags['source']['srcset'] = true;
	return $tags;
}

/**
 * テーマファイルを出力するショートコードを定義
 */
function return_template_directory_uri() {
  return esc_url(get_template_directory_uri());
}
add_shortcode('template_directory_uri', 'return_template_directory_uri');

// Contact Form 7で自動挿入されるPタグ、brタグを削除
add_filter('wpcf7_autop_or_not', 'wpcf7_autop_return_false');
function wpcf7_autop_return_false() {
  return false;
}

/**
 * Contact From 7にHidddenインプットを追加　
 */
add_action('wpcf7_init', 'add_custom_form_tags');
function add_custom_form_tags() {
  wpcf7_add_form_tag('page_title', 'get_page_title_form_tag_handler');
  wpcf7_add_form_tag('page_url', 'get_page_url_form_tag_handler');
}
function get_page_title_form_tag_handler($tag) {
  return '<input type="hidden" name="page_title" value="' . get_the_title() . '" />';
}

function get_page_url_form_tag_handler($tag) {
  return '<input type="hidden" name="page_url" value="' . get_permalink() . '" />';
}

/**
 * 特定のページでのみGoogle reCAPTCHAのバッジを表示
 */
function show_recaptcha() {
  $pages = array('contact');
  if (is_page($pages)) return;
  wp_deregister_script('google-recaptcha');
};
add_action('wp_enqueue_scripts', 'show_recaptcha', 100);

/**
 * SNSリンク設定をカスタマイザーに追加
 */
function sangsang_customize_register($wp_customize) {
  // SNSセクションを追加
  $wp_customize->add_section('sangsang_sns_section', array(
    'title' => 'SNSリンク設定',
    'priority' => 30,
  ));

  // Instagram URL
  $wp_customize->add_setting('sangsang_instagram_url', array(
    'default' => '',
    'sanitize_callback' => 'esc_url_raw',
  ));
  $wp_customize->add_control('sangsang_instagram_url', array(
    'label' => 'Instagram URL',
    'section' => 'sangsang_sns_section',
    'type' => 'url',
  ));

  // Facebook URL
  $wp_customize->add_setting('sangsang_facebook_url', array(
    'default' => '',
    'sanitize_callback' => 'esc_url_raw',
  ));
  $wp_customize->add_control('sangsang_facebook_url', array(
    'label' => 'Facebook URL',
    'section' => 'sangsang_sns_section',
    'type' => 'url',
  ));

  // Twitter (X) URL
  $wp_customize->add_setting('sangsang_twitter_url', array(
    'default' => '',
    'sanitize_callback' => 'esc_url_raw',
  ));
  $wp_customize->add_control('sangsang_twitter_url', array(
    'label' => 'X (Twitter) URL',
    'section' => 'sangsang_sns_section',
    'type' => 'url',
  ));

  // LINE URL
  $wp_customize->add_setting('sangsang_line_url', array(
    'default' => '',
    'sanitize_callback' => 'esc_url_raw',
  ));
  $wp_customize->add_control('sangsang_line_url', array(
    'label' => 'LINE URL',
    'section' => 'sangsang_sns_section',
    'type' => 'url',
  ));

  // TikTok URL
  $wp_customize->add_setting('sangsang_tiktok_url', array(
    'default' => '',
    'sanitize_callback' => 'esc_url_raw',
  ));
  $wp_customize->add_control('sangsang_tiktok_url', array(
    'label' => 'TikTok URL',
    'section' => 'sangsang_sns_section',
    'type' => 'url',
  ));
}
add_action('customize_register', 'sangsang_customize_register');