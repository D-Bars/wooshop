(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    })
})();

window.addEventListener('scroll', function () {
    document.getElementById('header-nav').classList.toggle('headernav-scroll', window.scrollY > 135);
});

jQuery(document).ready(function($) {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('#top').fadeIn();
        } else {
            $('#top').fadeOut();
        }
    });

    $('#top').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 500);
        return false;
    });

    $(".owl-carousel-full").owlCarousel({
        margin: 20,
        responsive: {
            0: {
                items: 1
            },
            500: {
                items: 2
            },
            700: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    });

    $('body').on('adding_to_cart', function(e, btn, data){
        btn.closest('.product-card').find('.ajax-loader').fadeIn();
    });

    $('body').on('added_to_cart', function(e, response_fragments, response_cart_hash, btn){
        btn.closest('.product-card').find('.ajax-loader').fadeOut();
    });


    $('main.main').on('click', ('.quantity button'), function(){
        let btn = $(this);
        let groupedProduct = btn.closest('.woocommerce-grouped-product-list-item__quantity').length;
        let inputQty = btn.parent().find('.qty');
        let prevValue = Number(inputQty.val());
        let newValue = groupedProduct ? 0 : 1;
        if(btn.hasClass('btn-plus')){
            newValue = prevValue + 1;
        }else{
            if(!groupedProduct && prevValue > 1){
                newValue = prevValue - 1;
            }else if(groupedProduct && prevValue > 0){
                newValue = prevValue - 1;
            }
        }
        inputQty.val(newValue);
        $('.update-cart').prop('disabled', false);
    })

    $('.wishlist-icon').on('click', function(){
        let wishBtn = $(this);
        if(wishBtn.hasClass('lock')){
            alert('wait!');
            return false;
        }
        $('.wishlist-icon').addClass('lock');
        let productId = wishBtn.data('id');
        let ajaxLoader = wishBtn.closest('.product-card').find('.ajax-loader');
        $.ajax({
            url: wooeshop_wishlist_object.url,
            type: 'POST',
            data: {
                action: 'wooeshop_wishlist_action',
                nonce: wooeshop_wishlist_object.nonce,
                product_id: productId
            },
            beforeSend: function(){
                ajaxLoader.fadeIn();
            },
            success: function(res){
                $('.wishlist-icon').removeClass('lock');
                wishBtn.toggleClass('in__wishlist');
                ajaxLoader.fadeOut();
            },
            error: function(){
                $('.wishlist-icon').removeClass('lock');
                ajaxLoader.fadeOut();
                alert('Error add to wishlist');
            }
        })
    })
});

Fancybox.bind("[data-fancybox]", {
    // Your custom options
  });