/**
 * Description: JavaScript for Global
 */

/*
  Import Modules
---------------------------------------------------*/
import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

/*
  KV section
---------------------------------------------------*/
/**
 * ヘッダーの色を変更
 */
(() => {
  /**
   * 変数・定数
   */
  const header = document.querySelector('#js-global-header');
  const intersectionTarget = document.querySelector('#js-kv-section');
  const activeClass = '-on';

  /**
   * 状態変化関数
   */
  const setHeaderClass = (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        header.classList.add(activeClass);
      } else {
        header.classList.remove(activeClass);
      }
    });
  };

  /**
   * Intersection Observerを定義
   */
  const observer = new IntersectionObserver(setHeaderClass, {
    root: null,
    rootMargin: '0px 0px 0px',
    threshold: 0,
  });
  observer.observe(intersectionTarget);
})();

/*
  Services section
---------------------------------------------------*/
/**
 * スクロールに応じて背景を拡大（PC表示時）
 */
if (window.matchMedia('(min-width: 768px)').matches) {
  /**
   * 変数・定数
   */
  const background = document.querySelector('#js-services-background');

  /**
   * アニメーション
   */
  const timeline = gsap.timeline({
    defaults: {
      duration: 1,
      ease: 'cubic-bezier(0, 0.6, 0.4, 1)',
    },
    scrollTrigger: {
      trigger: background,
      start: 'top bottom',
      end: 'top+=300 center',
      scrub: true,
      // markers: true,
    },
  });

  timeline.from(background, {
    borderRadius: 50,
    right: 30,
    left: 30,
  });

  timeline.to(background, {
    borderRadius: 0,
    right: 0,
    left: 0,
  });
}
