/**
 * Description: JavaScript for Shops page
 */

/*
  ヘッダーの色を変更
---------------------------------------------------*/
(() => {
  /**
   * 変数・定数
   */
  const header = document.querySelector('#js-global-header');
  const intersectionTarget = document.querySelector('#js-shops');
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
    rootMargin: '0px 0px -100%',
    threshold: 0,
  });
  observer.observe(intersectionTarget);
})();

/*
  詳細ボタンホバー時に店舗をハイライト
---------------------------------------------------*/
(() => {
  /**
   * 変数・定数
   */
  const buttons = document.querySelectorAll('.js-shops-more');

  /**
   * ホバーイベント
   */
  const setState = (event) => {
    const parent = event.target.closest('.p-shops__item');
    if (event.type === 'mouseover') {
      parent.classList.add('-on');
    } else {
      parent.classList.remove('-on');
    }
  };

  /**
   * イベントリスナー
   */
  buttons.forEach((button) => {
    button.addEventListener('mouseover', setState);
    button.addEventListener('mouseleave', setState);
  });
})();
