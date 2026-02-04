    </main>
    <footer class="l-footer" data-transition>
      <div class="l-footer__inner">
        <a class="l-footer__logo" href="<?php echo home_url('/'); ?>" translate="no">SANGSANG JAPAN</a>
        <nav class="l-footer__navigation">
          <a
            class="l-footer__navigation-item"
            href="<?php echo home_url('/'); ?>#company"
            <?php if (is_front_page()) echo 'data-anchor'; ?>
          >
            <span class="l-footer__navigation-item-text" data-text="会社概要">会社概要</span>
          </a>
          <a
            class="l-footer__navigation-item"
            href="<?php echo home_url('/'); ?>#services"
            <?php if (is_front_page()) echo 'data-anchor'; ?>
          >
            <span class="l-footer__navigation-item-text" data-text="事業紹介">事業紹介</span>
          </a>        
          <a class="l-footer__navigation-item" href="<?php echo home_url(); ?>/news/">
            <span class="l-footer__navigation-item-text" data-text="お知らせ">お知らせ</span>
          </a>        
          <a class="l-footer__navigation-item" href="<?php echo home_url(); ?>/contact/">
            <span class="l-footer__navigation-item-text" data-text="お問い合わせ">お問い合わせ</span>
          </a>   
        </nav>
        <span class="l-footer__copyright" translate="no">(c) <?php echo date('Y'); ?> SANGSANG JAPAN</span>
      </div>
    </footer>

    <?php wp_footer(); ?>
  </body>
</html>