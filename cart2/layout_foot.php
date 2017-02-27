		</div>
	</div>


<script src="libs/js/jquery.js"></script>
<script src="libs/js/bootbox.min.js"></script>

<script src="libs/css/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="libs/css/bootstrap/docs-assets/js/holder.js"></script>

<script src="libs/js/bootstrap-image-gallery/js/jquery.blueimp-gallery.min.js"></script>
<script src="libs/js/bootstrap-image-gallery/js/bootstrap-image-gallery.min.js"></script>

<script>
$(document).ready(function(){

	$('#blueimp-gallery').data('useBootstrapModal', false);
	$('#blueimp-gallery').toggleClass('blueimp-gallery-controls', true);

	$(document).on('click', '#empty-cart', function(){
		bootbox.confirm({
			message: "<h4>Are you sure?</h4>",
			buttons: {
				confirm: {
					label: '<span class="glyphicon glyphicon-ok"></span> Yes',
					className: 'btn-danger'
				},
				cancel: {
					label: '<span class="glyphicon glyphicon-remove"></span> No',
					className: 'btn-primary'
				}
			},
			callback: function (result) {

				if(result==true){
					window.location.href = "empty_cart.php";
				}
			}
		});

	});

	$(document).on('mouseenter', '.product-img-thumb', function(){
		var data_img_id = $(this).attr('data-img-id');
		$('.product-img').hide();
		$('#product-img-'+data_img_id).show();
	});

	$('.add-to-cart-form').on('submit', function(){

		var id = $(this).find('.product-id').text();
		var quantity = $(this).find('.cart-quantity').val();

		window.location.href = "add_to_cart.php?id=" + id + "&quantity=" + quantity;
		return false;
	});

	$('.update-quantity-form').on('submit', function(){

		
		var id = $(this).find('.product-id').text();
		var quantity = $(this).find('.cart-quantity').val();

		
		window.location.href = "update_quantity.php?id=" + id + "&quantity=" + quantity;
		return false;
	});
});
</script>

</body>
</html>
