jQuery(document).ready(function ($) {

	var MqL = 1170;

	moveNavigation();

	$(window).on('resize', function () {
		(!window.requestAnimationFrame)
			? setTimeout(moveNavigation, 300)
			: window.requestAnimationFrame(moveNavigation);
	});

	$('.cd-nav-trigger').on('click', function (event) {
		event.preventDefault();

		if ($('.cd-main-content').hasClass('nav-is-visible')) {
			closeNav();
			$('.cd-overlay').removeClass('is-visible');
		} else {
			$(this).addClass('nav-is-visible');
			$('.cd-main-header').addClass('nav-is-visible');
			$('.cd-main-content').addClass('nav-is-visible').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
				$('body').addClass('overflow-hidden');
			});
			toggleSearch('close');
			$('.cd-overlay').addClass('is-visible');
		}
	});

	$('.cd-search-trigger').on('click', function (event) {
		event.preventDefault();
		toggleSearch();
		closeNav();
	});

	$('.go-back').on('click', function () {
		$(this).parent('ul').addClass('is-hidden').parent('.has-children').parent('ul').removeClass('moves-out');
	});

	if ($('#demo1').length) {
		$('#demo1').skdslider({
			delay: 5000,
			animationSpeed: 2000,
			showNextPrev: true,
			showPlayButton: true,
			autoSlide: true,
			animationType: 'fading'
		});
	}

	const backToTop = $('#backToTop');
	const sliderHeight = $('.home-slider').outerHeight() || 300;

	$(window).on('scroll', function () {
		if ($(window).scrollTop() > sliderHeight) {
			backToTop.fadeIn();
		} else {
			backToTop.fadeOut();
		}
	});

	backToTop.on('click', function (e) {
		e.preventDefault();

		$('html, body').animate({
			scrollTop: 0
		}, 600);
	});

	$('.post-like-button').each(function () {
		const button = $(this);
		const postId = button.data('post-id');

		if (window.localStorage && localStorage.getItem('merotheme_liked_' + postId)) {
			button.addClass('liked').prop('disabled', true);
			button.find('span').text('Liked');
		}
	});

	$('.post-like-button').on('click', function () {
		const button = $(this);
		const postId = button.data('post-id');
		const article = button.closest('article');
		const count = article.find('.post-like-count');

		if (button.prop('disabled')) {
			return;
		}

		button.prop('disabled', true).addClass('is-loading');

		$.post(merothemeLikes.ajaxUrl, {
			action: 'merotheme_like_post',
			nonce: merothemeLikes.nonce,
			post_id: postId
		}).done(function (response) {
			if (response.success) {
				count.text(response.data.likes);
				button.removeClass('is-loading').addClass('liked');
				button.find('span').text('Liked');

				if (window.localStorage) {
					localStorage.setItem('merotheme_liked_' + postId, '1');
				}
			} else {
				button.prop('disabled', false).removeClass('is-loading');
			}
		}).fail(function () {
			button.prop('disabled', false).removeClass('is-loading');
		});
	});

	const bars = $('.skill-bar span');

	bars.each(function () {
		const bar = $(this);
		const target = parseInt(bar.attr('data-percent'));
		let count = 0;
		bar.css('width', '0%'); //increase width from 0% before animation
		setTimeout(function () {
			bar.css('width', target + '%');
		}, 100);

		const interval = setInterval(function () {
			if (count >= target) {
				clearInterval(interval);
			} else {
				count++;
				bar.text(count + '%');
			}
		}, 20);
	});

	function closeNav() {
		$('.cd-nav-trigger').removeClass('nav-is-visible');
		$('.cd-main-header').removeClass('nav-is-visible');
		$('.cd-primary-nav').removeClass('nav-is-visible');
		$('.has-children ul').addClass('is-hidden');
		$('.has-children a').removeClass('selected');
		$('.moves-out').removeClass('moves-out');
		$('.cd-main-content').removeClass('nav-is-visible').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
			$('body').removeClass('overflow-hidden');
		});
	}

	function toggleSearch(type) {
		if (type === 'close') {
			$('.cd-search').removeClass('is-visible');
			$('.cd-search-trigger').removeClass('search-is-visible');
			$('.cd-overlay').removeClass('search-is-visible');
		} else {
			$('.cd-search').toggleClass('is-visible');
			$('.cd-search-trigger').toggleClass('search-is-visible');
			$('.cd-overlay').toggleClass('search-is-visible');

			if ($(window).width() > MqL && $('.cd-search').hasClass('is-visible')) {
				$('.cd-search').find('input[type="search"]').focus();
			}

			$('.cd-search').hasClass('is-visible')
				? $('.cd-overlay').addClass('is-visible')
				: $('.cd-overlay').removeClass('is-visible');
		}
	}

	function checkWindowWidth() {
		var e = window;
		var a = 'inner';

		if (!('innerWidth' in window)) {
			a = 'client';
			e = document.documentElement || document.body;
		}

		return e[a + 'Width'] >= MqL;
	}

	function moveNavigation() {
		var navigation = $('.cd-nav');
		var desktop = checkWindowWidth();

		if (desktop) {
			navigation.detach();
			navigation.insertBefore('.cd-header-buttons');
		} else {
			navigation.detach();
			navigation.insertAfter('.cd-main-content');
		}
	}

});
