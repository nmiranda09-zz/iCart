$(document).ready(function() {
	qtyTicker();
	starsAnimation();
	userSelect();
});

function qtyTicker() {
	$('.qty-ticker .add').click(function () {
		$(this).prev().val(+$(this).prev().val() + 1);
	});

	$('.qty-ticker .sub').click(function () {
		if ($(this).next().val() > 1) {
			$(this).next().val(+$(this).next().val() - 1);
		}
	});
}

function addToCart() {
	var baseUrl = (window.location).href;
	var user = baseUrl.substring(baseUrl.lastIndexOf('=') + 1);
	var qty = $(".qty-ticker input").val();
	var value = $(".addto").attr("value");	
    $.ajax({
    	cache: false,
        url: "./server/addtocart.php",
        method: "POST", 
        data : "qty=" + qty + "&value=" + value + "&user=" + user,
        success: function(data) {
			setTimeout(function() {
	        	location.reload();
	    	}, 1000);
		}
    });
}

function radioValue() {
	var getValue = $("input[type=radio]:checked").attr('value');
	var vCash = $(".summary .v-cash").attr('data-needed');
	var cartTotal = $(".summary .cart-total").attr('data-needed');	
	var grandTotal = parseFloat(cartTotal) + parseFloat(getValue);

	$(".checkout-container .summary .options").html('Transport: + $' + getValue);

	$(".checkout-container .summary .grand-total").html('Grand Total: $' + grandTotal);
	$(".checkout-container .summary .grand-total").attr('data-needed', grandTotal)

}

function openModal(el) {
	var updateValue = (el.getAttribute('value'));

	$("#updateValue").attr('value', updateValue);

	document.getElementById('myModal').style.display = "block";

	$('.modal-content .close').click(function() {
		$(this).parent().parent().css('display', 'none');
	});
}

function deleteCart(el){
	var baseUrl = (window.location).href;
	var user = baseUrl.substring(baseUrl.lastIndexOf('=') + 1);
	var deleteValue = (el.getAttribute('value'));
 
	$.ajax({
	 	url : "./server/delete.php",
	 	method : "POST",
	 	data : 'deleteValue=' + deleteValue + '&user=' + user,
		success: function(data) {
			setTimeout(function() {
		    	location.reload();
		    }, 1000);
		}
 	});
}

function payment(){
	if($('input[type="radio"]').is(':checked')) {
		var baseUrl = (window.location).href;
		var id = baseUrl.substring(baseUrl.lastIndexOf('=') + 1);
		var vCash = $(".summary .v-cash").attr('data-needed');
		var cart_total = $(".summary .cart-total").attr('data-needed');
		var grandTotal = $(".checkout-container .summary .grand-total").attr('data-needed');	
		var total = parseFloat(vCash) - parseFloat(grandTotal);
		var cartStatus = 0;

		if (parseFloat(cart_total) == 0) {
			alert('You have no items in cart.')
		} else if (parseFloat(grandTotal) > parseFloat(vCash)) {
			alert('You have insufficient balance.');
		} else {
			$.ajax({
				url : "./server/updateCartStatus.php",
				method : "POST",	
				data : 'cartStatus=' + cartStatus + "&total=" + total + "&id=" + id,
				 success: function(data){
				   setTimeout(function(){
			           location.reload(); 
			      }, 3000);
				}
			});	
		}
	} else {
	  alert('Please select transport option to continue.');
	}
}

function starsAnimation() {
  	$('#stars li').on('mouseover', function(){
  		var onStar = parseInt($(this).data('value'), 10);
   
    	$(this).parent().children('li.star').each(function(e){
      		if (e < onStar) {
        		$(this).addClass('hover');
      		}
      		else {
        		$(this).removeClass('hover');
      		}
    	});
  	}).on('mouseout', function(){
    	$(this).parent().children('li.star').each(function(e){
      		$(this).removeClass('hover');
    	});
  	});
  
  	$('#stars li').on('click', function(){
		var onStar = parseInt($(this).data('value'), 10);
	    var stars = $(this).parent().children('li.star');
	    
	    for (i = 0; i < stars.length; i++) {
	      $(stars[i]).removeClass('selected');
	    }
	    
	    for (i = 0; i < onStar; i++) {
	      $(stars[i]).addClass('selected');
	    }   
  });
}

function addRate(){
	var productID = $("input#productID").val();
	var rateValue = parseInt($('#stars li.selected').last().data('value'), 10);
	var userID = $(".users-container select option:selected").val();

	$('#stars').each(function() {
		if($(this).find('li').hasClass('selected')) {
			$.ajax({
				url : "./server/rate.php",
				method : "POST",
				data: {
			    	'username_check' : 1,
			    	'userID' : userID,
			    	'productID' : productID,
			    	'rateValue' : rateValue,
			    },
				success: function(response) {
					if (response == 'true' ) {	
						alert('Sorry, you already have rated this product.')
					} else {

						setTimeout(function() {
			           		location.reload();
			       		}, 1000);
					}  
				}
			});	
		} else {
			alert('Please select a rating to proceed.');
		}
	});

} 

function saveUpdate(){
	var baseUrl = (window.location).href;
	var user = baseUrl.substring(baseUrl.lastIndexOf('=') + 1);
	var updateValue = $("button#updateValue").val();
	var qtyValue = $("input#qtyUpdate").val();
    
    $.ajax({
    	url : "./server/updateQuantity.php",
    	method : "POST",
    	data : "qtyValue=" + qtyValue + '&updateValue=' + updateValue + '&user=' + user,
    	success: function(response) {
			if (response == 'error' ) {	
				alert('Sorry, you have reached the maximum stock limit.')
			} else {
				setTimeout(function() {
	           		location.reload();
	       		}, 1000);
			}
		}
    });
}

function userSelect() {
	var baseUrl = (window.location).href;
	var urlId = baseUrl.substring(baseUrl.lastIndexOf('=') + 1);

	if($('body').hasClass('page-cart')) {
		$('.users-container select option').each(function() {
			var optionValue = $(this).attr('value');
			
			if(urlId == optionValue) {
				$(this).attr('selected','selected');
			}
		});
	} else {
		$('.users-container select option').each(function() {
			var optionValue = $(this).attr('value');

			if(urlId == optionValue) {
				$(this).attr('selected','selected');
			}
		});
	}

	var firstValue = $('.users-container select option[selected = "selected"]').attr('value');

	$.ajax({
		url : "./server/getCart_first.php",
		method : "POST",
		data: {
	    	'firstValue' : firstValue,
	    },
		success: function(data) {
			$('.cart-container').html(data);	
		}
	});

	$('.users-container select').on('change', function() {
		$('.users-container select option').each(function() {
	        	if($(this).is(':selected')) {
	        		$(this).attr('selected','selected');
	        		$(this).siblings().removeAttr('selected');
	        		var selectedValue = $(this).attr('value');

	        		$.ajax({
						url : "./server/getCart_selected.php",
						method : "POST",
						data: {
					    	'selectedValue' : selectedValue,
					    },
						success: function(data) {
							$('.cart-container').html(data);
						}
					});

					var newUrl = location.href.replace("user=" + urlId, "user=" + selectedValue);
					location.replace(newUrl);

					if($('body').hasClass('page-cart')) {
                		var newUrl = location.href.replace("id=" + urlId, "id=" + selectedValue);
						location.replace(newUrl);
					}
	        	}
	    	}
		);
	});
}

