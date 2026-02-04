<!DOCTYPE html>
<html lang="ja">
  <head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-TE4Z39NK5T"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-TE4Z39NK5T');
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="googlebot" content="index, follow">
    <meta name="format-detection" content="telephone=no">
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.svg" type="image/svg+xml">

    <!-- Web Fonts -->
    <script>
      (function(d) {
        var config = {
          kitId: 'fak7jrx',
          scriptTimeout: 3000,
          async: true
        },
        h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
      })(document);
    </script>
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?> data-page-state="loading">
    <div class="p-transition-mask"></div>
    <header class="l-header" id="js-global-header" data-transition>
      <div class="l-header__inner" data-scroll-hide>
        <?php $tag_name = is_front_page() ? 'h1' : 'div'; ?>
        <<?php echo $tag_name; ?> class="l-header__logo">
          <a class="l-header__logo-wrap" href="<?php echo home_url('/'); ?>" translate="no">SANGSANG JAPAN</a>
        </<?php echo $tag_name; ?>>
        <button class="l-header__hamburger" id="js-hamburger" aria-label="メニュー" aria-expanded="false">
          <span class="l-header__hamburger-line"></span>
          <span class="l-header__hamburger-line"></span>
          <span class="l-header__hamburger-line"></span>
        </button>
        <nav class="l-header__navigation" id="js-navigation">
          <a
            class="l-header__navigation-item"
            href="<?php echo home_url('/'); ?>#company"
            <?php if (is_front_page()) echo 'data-anchor'; ?>
          >
            <span class="l-header__navigation-item-text" data-text="会社概要">会社概要</span>
          </a>
          <a
            class="l-header__navigation-item"
            href="<?php echo home_url('/'); ?>#services"
            <?php if (is_front_page()) echo 'data-anchor'; ?>
          >
            <span class="l-header__navigation-item-text" data-text="事業紹介">事業紹介</span>
          </a>
          <a class="l-header__navigation-item" href="<?php echo home_url(); ?>/news/">
            <span class="l-header__navigation-item-text" data-text="お知らせ">お知らせ</span>
          </a>
          <a class="l-header__navigation-item" href="<?php echo home_url(); ?>/contact/">
            <span class="l-header__navigation-item-text" data-text="お問い合わせ">お問い合わせ</span>
          </a>
        </nav>
        <?php
        $instagram_url = get_theme_mod('sangsang_instagram_url');
        $facebook_url = get_theme_mod('sangsang_facebook_url');
        $twitter_url = get_theme_mod('sangsang_twitter_url');
        $line_url = get_theme_mod('sangsang_line_url');
        $tiktok_url = get_theme_mod('sangsang_tiktok_url');

        if ($instagram_url || $facebook_url || $twitter_url || $line_url || $tiktok_url) : ?>
        <div class="l-header__sns">
          <?php if ($instagram_url) : ?>
          <a class="l-header__sns-link" href="<?php echo esc_url($instagram_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
          </a>
          <?php endif; ?>
          <?php if ($facebook_url) : ?>
          <a class="l-header__sns-link" href="<?php echo esc_url($facebook_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
          </a>
          <?php endif; ?>
          <?php if ($twitter_url) : ?>
          <a class="l-header__sns-link" href="<?php echo esc_url($twitter_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
          </a>
          <?php endif; ?>
          <?php if ($line_url) : ?>
          <a class="l-header__sns-link" href="<?php echo esc_url($line_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="LINE">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M19.365 9.863c.349 0 .63.285.63.631 0 .345-.281.63-.63.63H17.61v1.125h1.755c.349 0 .63.283.63.63 0 .344-.281.629-.63.629h-2.386c-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63h2.386c.346 0 .627.285.627.63 0 .349-.281.63-.63.63H17.61v1.125h1.755zm-3.855 3.016c0 .27-.174.51-.432.596-.064.021-.133.031-.199.031-.211 0-.391-.09-.51-.25l-2.443-3.317v2.94c0 .344-.279.629-.631.629-.346 0-.626-.285-.626-.629V8.108c0-.27.173-.51.43-.595.06-.023.136-.033.194-.033.195 0 .375.104.495.254l2.462 3.33V8.108c0-.345.282-.63.63-.63.345 0 .63.285.63.63v4.771zm-5.741 0c0 .344-.282.629-.631.629-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63.346 0 .628.285.628.63v4.771zm-2.466.629H4.917c-.345 0-.63-.285-.63-.629V8.108c0-.345.285-.63.63-.63.348 0 .63.285.63.63v4.141h1.756c.348 0 .629.283.629.63 0 .344-.282.629-.629.629M24 10.314C24 4.943 18.615.572 12 .572S0 4.943 0 10.314c0 4.811 4.27 8.842 10.035 9.608.391.082.923.258 1.058.59.12.301.079.766.038 1.08l-.164 1.02c-.045.301-.24 1.186 1.049.645 1.291-.539 6.916-4.078 9.436-6.975C23.176 14.393 24 12.458 24 10.314"/></svg>
          </a>
          <?php endif; ?>
          <?php if ($tiktok_url) : ?>
          <a class="l-header__sns-link" href="<?php echo esc_url($tiktok_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="TikTok">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
          </a>
          <?php endif; ?>
        </div>
        <?php endif; ?>
      </div>
    </header>
    <main class="l-contents" data-transition>