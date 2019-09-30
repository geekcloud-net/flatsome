Flatsome.behavior('wishlist', {
  attach: function (context) {
    jQuery('.wishlist-button', context).each(function (index, element) {
      'use strict'

      jQuery(element).on('click', function (e) {
        if (jQuery(this).parent().find('.yith-wcwl-wishlistexistsbrowse').hasClass('show')) {
          var link = jQuery(this).parent().find('.yith-wcwl-wishlistexistsbrowse a').attr('href')
          window.location.href = link
          return
        }

        jQuery(this).addClass('loading')
        jQuery(this).parent().find('.add_to_wishlist').click()
        e.preventDefault()
      })
    })
  }
})

jQuery(document).ready(function () {
  var flatsomeAddToWishlist = function () {
    jQuery('.wishlist-button').removeClass('loading')
    jQuery('.wishlist-button').addClass('wishlist-added')

    jQuery.ajax({
      beforeSend: function () {

      },
      complete: function () {

      },
      data: {
        action: 'flatsome_update_wishlist_count',
      },
      success: function (data) {
        jQuery('i.wishlist-icon').addClass('added')
        if (data == 0) {
          jQuery('i.wishlist-icon').removeAttr('data-icon-label')
        }
        else if (data == 1) {
          jQuery('i.wishlist-icon').attr('data-icon-label', '1')
        }
        else {
          jQuery('i.wishlist-icon').attr('data-icon-label', data)
        }
        setTimeout(function () {
          jQuery('i.wishlist-icon').removeClass('added')
        }, 500)
      },

      url: yith_wcwl_l10n.ajax_url,
    })
  }

  jQuery('body').on('added_to_wishlist removed_from_wishlist', flatsomeAddToWishlist)
})
