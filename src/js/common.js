/**
 * Description: JavaScript for Global
 */

/*
  Import Modules
---------------------------------------------------*/
import simpleParallax from 'simple-parallax-js';
import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

/*
  Global Variable
---------------------------------------------------*/
const html = document.documentElement;
const body = document.body;
const ua = window.navigator.userAgent.toLowerCase();
window.PAGE_TRANSITION_DELAY = 300;

/*
  Common
---------------------------------------------------*/
/**
 * 外部リンク処理
 */
(() => {
  const links = document.querySelectorAll('a[target="_blank"]:not([data-referrer])');
  if (links[0]) {
    links.forEach((link) => {
      link.setAttribute('rel', 'nofollow noreferrer');
    });
  }
})();

/**
 * ビューポート
 */
(() => {
  const viewport = window.matchMedia('(max-width: 767px)').matches
    ? 'width=device-width, initial-scale=1, maximum-scale=1'
    : 'width=1366, initial-scale=1, viewport-fit=cover';
  const meta = document.querySelector('meta[name="viewport"]');
  meta.content = viewport;
})();

/**
 * ブラウザ判定
 */
(() => {
  if (ua.indexOf('msie') != -1 || ua.indexOf('trident') != -1) {
    html.classList.add('-ie');
  } else if (ua.indexOf('edge') != -1) {
    html.classList.add('-edge');
  } else if (ua.indexOf('chrome') != -1) {
    html.classList.add('-chrome');
  } else if (ua.indexOf('safari') != -1) {
    html.classList.add('-safari');
  } else if (ua.indexOf('firefox') != -1) {
    html.classList.add('-firefox');
  } else if (ua.indexOf('opera') != -1) {
    html.classList.add('-opera');
  }

  if (ua.indexOf('ipad') != -1 || (ua.indexOf('macintosh') != -1 && 'ontouchend' in document)) {
    html.classList.add('-ipad');
  }
})();

/**
 * 動的に`vh`を計算
 */
if (window.matchMedia('(max-width: 767px)').matches) {
  const setFillSize = () => {
    const vh = window.innerHeight * 0.01;
    const vw = window.innerWidth * 0.01;
    html.style.setProperty('--vh', `${vh}px`);
    html.style.setProperty('--vw', `${vw}px`);
  };

  // 画面のサイズ変動があった時に再計算
  window.addEventListener('resize', setFillSize);

  // 初期化
  setFillSize();
}

/**
 * リサイズ時にページを更新
 */
(() => {
  let timer = false;
  let initialWidth = window.innerWidth;

  window.addEventListener('resize', () => {
    if (timer) clearTimeout(timer);

    timer = setTimeout(() => {
      if (initialWidth !== window.innerWidth) location.reload();
      initialWidth = window.innerWidth;
    }, 300);
  });
})();

/*
  Transition
---------------------------------------------------*/
(() => {
  /**
   * 変数・定数
   */
  const links = document.querySelectorAll('a:not([target="_blank"]):not([data-anchor])');

  /**
   * Enter
   */
  setTimeout(() => (body.dataset.pageState = 'entered'), PAGE_TRANSITION_DELAY);

  /**
   * Leave
   */
  if (links[0]) {
    links.forEach((link) => {
      link.addEventListener('click', (event) => {
        const target = event.target;
        const url = target.href ? target.href : target.closest('a:not([target="_blank"])').href;
        event.preventDefault();
        body.dataset.pageState = 'leave';
        setTimeout(() => (window.location = url), 1200);
      });
    });
  }

  /**
   * スマホ時に「戻る」ボタンクリック時に遷移エフェクトが止まってしまうのを解消
   */
  window.onpageshow = function (event) {
    if (event.persisted) {
      window.location.reload();
    }
  };
})();

/*
  Global Header
---------------------------------------------------*/
/**
 * ハンバーガーメニュー
 */
(() => {
  const hamburger = document.getElementById('js-hamburger');
  const navigation = document.getElementById('js-navigation');

  if (hamburger && navigation) {
    hamburger.addEventListener('click', () => {
      const isOpen = html.classList.toggle('-navigation-open');
      hamburger.setAttribute('aria-expanded', isOpen);

      // メニューが開いた時にスクロールを無効化
      if (isOpen) {
        body.style.overflow = 'hidden';
      } else {
        body.style.overflow = '';
      }
    });

    // ナビゲーションリンクをクリックしたらメニューを閉じる
    const navLinks = navigation.querySelectorAll('a');
    navLinks.forEach((link) => {
      link.addEventListener('click', () => {
        html.classList.remove('-navigation-open');
        hamburger.setAttribute('aria-expanded', 'false');
        body.style.overflow = '';
      });
    });
  }
})();

/**
 * スクロール方向に応じてスタイルを付与
 */
(() => {
  /**
   * 変数・定数
   */
  let startPosition = 0;
  let windowScrollPosition = 0;
  const targets = document.querySelectorAll('[data-scroll-hide]');

  /**
   * イベントリスナー
   */
  window.addEventListener('scroll', () => {
    windowScrollPosition = html.scrollTop || body.scrollTop;
    const style =
      windowScrollPosition >= startPosition ? 'opacity: 0; translate: 0 -20px;' : 'opacity: 1; translate: 0;';
    if (windowScrollPosition >= 300 && !html.classList.contains('-navigation-open')) {
      // ページ上部より300px以上スクロールされている且つ
      // HTMLタグに`-navigation-open`クラスが存在しない場合に処理を実行
      targets.forEach((target) => target.setAttribute('style', style));
      startPosition = windowScrollPosition;
    }
  });
})();

/*
  Fade in
---------------------------------------------------*/
(() => {
  /**
   * 変数・定数
   */
  const elements = document.querySelectorAll('[data-scroll]');

  /**
   * GSAP実行
   */
  if (elements[0]) {
    elements.forEach((element) => {
      const timeline = gsap.timeline({
        defaults: {
          duration: 1,
          ease: 'cubic-bezier(0, 0.6, 0.4, 1)',
        },
        scrollTrigger: {
          trigger: element,
          start: window.matchMedia('(max-width: 767px)').matches ? 'top bottom+=10%' : 'center bottom',
          end: 'center top',
        },
      });

      timeline.from(element, {
        opacity: 0,
        y: window.matchMedia('(max-width: 767px)').matches ? 20 : 40,
      });

      timeline.to(element, {
        opacity: 1,
        y: 0,
      });
    });
  }
})();

/*
  Parallax
---------------------------------------------------*/
(() => {
  const images = document.querySelectorAll('[data-parallax]');
  if (images[0]) {
    images.forEach((image) => {
      new simpleParallax(image, {
        scale: 1.15,
        orientation: 'down',
      });
    });
  }
})();
