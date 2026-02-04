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
    $templates[] = "search-{$post_type}.php";
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
  $output = '<div class="c-pagination">';
  if ($prev) $output .= "<div class='c-pagination__link -prev'>{$prev}</div>";
  if ($next) $output .= "<div class='c-pagination__link -next'>{$next}</div>";
  $output .= '</div>';
  return $output;
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
}
add_action('wp_enqueue_scripts', 'show_recaptcha', 100);

/**
 * SNSリンクを表示
 */
function sangsang_render_sns_links($location = 'header') {
  $prefix = 'l-' . $location;
  $instagram_url = get_theme_mod('sangsang_instagram_url');
  $facebook_url = get_theme_mod('sangsang_facebook_url');
  $twitter_url = get_theme_mod('sangsang_twitter_url');
  $line_url = get_theme_mod('sangsang_line_url');
  $tiktok_url = get_theme_mod('sangsang_tiktok_url');

  if ($instagram_url || $facebook_url || $twitter_url || $line_url || $tiktok_url) {
    echo '<div class="' . esc_attr($prefix) . '__sns">';
    
    if ($instagram_url) {
      echo '<a class="' . esc_attr($prefix) . '__sns-link" href="' . esc_url($instagram_url) . '" target="_blank" rel="noopener noreferrer" aria-label="Instagram">';
      echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>';
      echo '</a>';
    }
    
    if ($facebook_url) {
      echo '<a class="' . esc_attr($prefix) . '__sns-link" href="' . esc_url($facebook_url) . '" target="_blank" rel="noopener noreferrer" aria-label="Facebook">';
      echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>';
      echo '</a>';
    }

    if ($twitter_url) {
      echo '<a class="' . esc_attr($prefix) . '__sns-link" href="' . esc_url($twitter_url) . '" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)">';
      echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>';
      echo '</a>';
    }

    if ($line_url) {
      echo '<a class="' . esc_attr($prefix) . '__sns-link" href="' . esc_url($line_url) . '" target="_blank" rel="noopener noreferrer" aria-label="LINE">';
      echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M19.365 9.863c.349 0 .63.285.63.631 0 .345-.281.63-.63.63H17.61v1.125h1.755c.349 0 .63.283.63.63 0 .344-.281.629-.63.629h-2.386c-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63h2.386c.346 0 .627.285.627.63 0 .349-.281.63-.63.63H17.61v1.125h1.755zm-3.855 3.016c0 .27-.174.51-.432.596-.064.021-.133.031-.199.031-.211 0-.391-.09-.51-.25l-2.443-3.317v2.94c0 .344-.279.629-.631.629-.346 0-.626-.285-.626-.629V8.108c0-.27.173-.51.43-.595.06-.023.136-.033.194-.033.195 0 .375.104.495.254l2.462 3.33V8.108c0-.345.282-.63.63-.63.345 0 .63.285.63.63v4.771zm-5.741 0c0 .344-.282.629-.631.629-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63.346 0 .628.285.628.63v4.771zm-2.466.629H4.917c-.345 0-.63-.285-.63-.629V8.108c0-.345.285-.63.63-.63.348 0 .63.285.63.63v4.141h1.756c.348 0 .629.283.629.63 0 .344-.282.629-.629.629M24 10.314C24 4.943 18.615.572 12 .572S0 4.943 0 10.314c0 4.811 4.27 8.842 10.035 9.608.391.082.923.258 1.058.59.12.301.079.766.038 1.08l-.164 1.02c-.045.301-.24 1.186 1.049.645 1.291-.539 6.916-4.078 9.436-6.975C23.176 14.393 24 12.458 24 10.314"/></svg>';
      echo '</a>';
    }

    if ($tiktok_url) {
      echo '<a class="' . esc_attr($prefix) . '__sns-link" href="' . esc_url($tiktok_url) . '" target="_blank" rel="noopener noreferrer" aria-label="TikTok">';
      echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>';
      echo '</a>';
    }

    echo '</div>';
  }
}

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

/**
 * コンタクトフォームのSP表示調整
 */
function sangsang_fix_contact_form_mobile_width() {
  if (is_page('contact')) {
    echo '<style>
      @media (max-width: 767px) {
        .p-contact-form {
          width: 90% !important;
        }
      }
    </style>';
  }
}
add_action('wp_head', 'sangsang_fix_contact_form_mobile_width');