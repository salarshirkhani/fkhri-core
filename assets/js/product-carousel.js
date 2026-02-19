;(function($){
  function init($scope){
    const $wrap = $scope.find('.fkhri-pc');
    const $cont = $wrap.find('.fkhri-pc__swiper');
    if(!$cont.length) return;

    if ($cont.data('fkhri-initialized')) return;

    const data = $cont.data('fkhri-swiper') || {};

    // عناصر اختیاری را پیدا کن
    const nextEl = $wrap.find('.fkhri-pc__next')[0] || null;
    const prevEl = $wrap.find('.fkhri-pc__prev')[0] || null;
    const pagEl  = $wrap.find('.fkhri-pc__dots')[0]  || null;

    // اگر درخواست navigation/pagination شده اما المنت‌ها نیستند، صراحتاً false بده
    const wantNav = !!data.navigation && nextEl && prevEl;
    const wantPag = !!data.pagination && pagEl;

    const opts = {
      slidesPerView: data.slidesPerView || 4,
      spaceBetween:  data.spaceBetween  || 16,
      loop: !!data.loop,
      speed: data.speed || 500,
      autoplay: data.autoplay || false,
      breakpoints: data.breakpoints || {},

      // خیلی مهم: اگر نمی‌خواهیم، false (نه undefined)
      navigation: wantNav ? { nextEl, prevEl } : false,
      pagination: wantPag ? { el: pagEl, clickable: true } : false
    };

    // فقط از رَپر المنتور استفاده کن
    const EU = elementorFrontend && elementorFrontend.utils && elementorFrontend.utils.swiper;
    if (!EU) { console.warn('Elementor swiper util not found'); return; }

    const node = $cont[0];
    if (typeof EU === 'object' && typeof EU.init === 'function') {
      EU.init(node, opts);
    } else {
      new EU(node, opts);
    }

    $cont.data('fkhri-initialized', true);
  }

  $(window).on('elementor/frontend/init', function(){
    elementorFrontend.hooks.addAction('frontend/element_ready/fkhri-product-carousel.default', init);
  });
})(jQuery);
