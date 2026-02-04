<?php get_header(); ?>

<div class="p-top-kv" id="js-kv-section">
  <div class="p-top-kv__catch">
    <span class="p-top-kv__catch-small">記憶に残る一瞬を、永遠に。</span>
    <div class="p-top-kv__catch-large">
      <span class="p-top-kv__catch-large-line">Turn Fleeting</span>
      <span class="p-top-kv__catch-large-line">Moments into Forever.</span>
    </div>
  </div>
  <div class="p-top-kv__background">
    <div class="p-top-kv__background-image -left">
      <img
        src="<?php echo get_template_directory_uri(); ?>/dist/images/webp/bg_top_kv_03.webp"
        height="683"
        width="768"
        loading="eager"
        data-parallax
      >
    </div>
    <div class="p-top-kv__background-image -right">
      <img
        src="<?php echo get_template_directory_uri(); ?>/dist/images/webp/bg_top_kv_04.webp"
        height="683"
        width="768"
        loading="eager"
        data-parallax
      >
    </div>
  </div>
  <a
    class="p-top-kv__scroll-down"
    href="#about"
    aria-hidden="true"
    data-anchor
  >
    <div class="p-top-kv__scroll-down-circle"></div>
  </a>
</div>

<section class="p-top-about" id="about">
  <span class="p-top-about__heading">私たちについて</span>
  <div class="p-top-about__main">
    <div class="p-top-about__lead">
      <h2 class="p-top-about__lead-large">
        Design that moves, <br aria-hidden="true">
        joy you hold.
      </h2>
      <span class="p-top-about__lead-small">
        心を動かすデザインと、<br aria-hidden="true">
        手に取る喜びを。
      </span>
    </div>
    <p class="p-top-about__contents">
      見るだけでなく、手に取り、身につけ、五感で楽しむ体験を創造します。厳選された素材と熟練のクリエイターの情熱が生み出す一つひとつのアイテムに、<br>
      私たちの想いを込めています。細部にまでこだわったデザインとクオリティが、日常に彩りを添える特別な瞬間を演出。ファンの皆さまの心に残る、<br>
      かけがえのないコレクションづくりのお手伝いをすることが、私たちの最大の喜びです。アーティストの世界観から生まれる感動と驚きを、<br>
      ぜひ体験してください。
    </p>
  </div>
</section>

<section class="p-top-services" id="services">
  <div class="p-top-services__head">
    <div class="p-top-services__heading">
      <span class="p-top-services__heading-small">事業内容</span>
      <h2 class="p-top-services__heading-large">Services</h2>
    </div>
    <span class="p-top-services__lead">
      独特の世界観を創造し<br aria-hidden="true">
      高揚感あふれる感動を提供
    </span>
  </div>
  <div class="p-top-services__main">
    <div class="p-top-services__item">
      <a class="p-top-services__item-image -link" href="<?php echo home_url(); ?>/shops/">
        <img
          src="<?php echo get_template_directory_uri(); ?>/dist/images/webp/img_top_services_item_03.webp"
          alt="飲食店事業"
          height="410"
          width="546"
          loading="lazy"
          data-parallax
        >
      </a>
      <div class="p-top-services__item-contents">
        <h3 class="p-top-services__item-heading">グッズ制作</h3>
        <p class="p-top-services__item-description">アーティストの世界観と確かな品質が融合した、多彩なオリジナルグッズを展開。韓国を代表するアイドルたちの魅力を活かした独創的なデザインと、細部までこだわり抜いたクオリティで、ファンの心に響くコレクション体験を創造します。</p>
      </div>
    </div>
    <div class="p-top-services__item">
      <div class="p-top-services__item-image">
        <img
          src="<?php echo get_template_directory_uri(); ?>/dist/images/webp/img_top_services_item_04.webp"
          alt="お弁当デリバリー事業"
          height="410"
          width="546"
          loading="lazy"
          data-parallax
        >
      </div>
      <div class="p-top-services__item-contents">
        <h3 class="p-top-services__item-heading">イベント/POPUP</h3>
        <p class="p-top-services__item-description">リアルとバーチャルが交差する、没入型のファン体験空間を展開。期間限定のポップアップストアやファンイベントを通じて、アーティストとファンをつなぐ特別な場を創出。記憶に残る感動の瞬間と、新たなコミュニティの広がりを生み出します。</p>
      </div>
    </div>
  </div>
  <div class="p-top-services__background" id="js-services-background"></div>
</section>

<section class="p-top-news">
  <div class="p-top-news__inner">
    <div class="p-top-news__head">
      <div class="p-top-news__heading">
        <span class="p-top-news__heading-small">お知らせ</span>
        <h2 class="p-top-news__heading-large">News</h2>
      </div>
      <div class="p-top-news__more">
        <a class="c-button" href="<?php echo home_url(); ?>/news/">すべて見る</a>
      </div>
    </div>
    <div class="p-top-news__main">
      <?php
        $the_query = new WP_Query(array(
          'post_type' => 'post',
          'posts_per_page' => 3,
          'post_status' => 'publish',
          'has_password' => false,
        ));
  
        if ($the_query->have_posts()):
        while ($the_query->have_posts()):
        $the_query->the_post();
      ?>
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
      <?php endwhile; endif; wp_reset_postdata(); ?>
    </div>
  </div>
  <div class="p-top-news__marquee">
    <div class="p-top-news__marquee-inner">
      <div class="p-top-news__marquee-wrap">
        <?php for ($i = 0; $i <= 2; $i++): ?>
          <div class="p-top-news__marquee-text">
            <span class="p-top-news__marquee-text-large">Feel the moment, keep the magic.</span>
            <span class="p-top-news__marquee-text-small">心震える瞬間と、永遠に残る感動を</span>
          </div>
        <?php endfor; ?>
      </div>
    </div>
  </div>
</section>

<section class="p-top-company" id="company">
  <div class="p-top-company__inner">
    <div class="p-top-company__heading">
      <span class="p-top-company__heading-small">会社概要</span>
      <h2 class="p-top-company__heading-large">Company</h2>
    </div>
    <table class="p-top-comapny__main">
      <tr class="p-top-company__row">
        <th class="p-top-company__row-head">会社名</th>
        <td class="p-top-company__row-data">株式会社SANGSANG JAPAN</td>
      </tr>
      <tr class="p-top-company__row">
        <th class="p-top-company__row-head">住所</th>
        <td class="p-top-company__row-data">
          〒107-0061 東京都港区北青山3-6-7</td>
      </tr>
      <tr class="p-top-company__row">
        <th class="p-top-company__row-head">電話番号</th>
        <td class="p-top-company__row-data">
          03-5778-5203</td>
      </tr>
      <tr class="p-top-company__row">
        <th class="p-top-company__row-head">設立</th>
        <td class="p-top-company__row-data">2021年5月19日</td>
      </tr>
      <!-- <tr class="p-top-company__row">
        <th class="p-top-company__row-head">資本金</th>
        <td class="p-top-company__row-data">0,000万円（資本準備金を含む）</td>
      </tr> -->
      <tr class="p-top-company__row">
        <th class="p-top-company__row-head">事業内容</th>
        <td class="p-top-company__row-data">グッズ制作 / イベント企画</td>
      </tr>
      <tr class="p-top-company__row">
        <th class="p-top-company__row-head">役員</th>
        <td class="p-top-company__row-data">代表取締役　金城　賢</td>
      </tr>
    </table>
  </div>
</section>

<?php get_footer(); ?>