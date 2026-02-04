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
        <nav class="l-header__navigation">
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
      </div>
    </header>
    <main class="l-contents" data-transition>