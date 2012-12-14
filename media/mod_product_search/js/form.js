jQuery.noConflict();
jQuery(document).ready(function ($) {
	(function ($) {
		var loadingContainer = $('#loading');
		var spinOpts = {
			lines: 13, // The number of lines to draw
			length: 19, // The length of each line
			width: 6, // The line thickness
			radius: 20, // The radius of the inner circle
			corners: 1, // Corner roundness (0..1)
			rotate: 57, // The rotation offset
			color: '#fff', // #rgb or #rrggbb
			speed: 1, // Rounds per second
			trail: 60, // Afterglow percentage
			shadow: false, // Whether to render a shadow
			hwaccel: false, // Whether to use hardware acceleration
			className: 'spinner', // The CSS class to assign to the spinner
			zIndex: 2e9, // The z-index (defaults to 2000000000)
			top: 150, // Top position relative to parent in px
			left: 80 // Left position relative to parent in px
		};
		loadingContainer.spin(spinOpts);

		var span = [];
		var checkboxHeight = 25;
		var filterForm = $('#searchForm');
		var filterInputs = filterForm.find('input[type="checkbox"]');

		filterInputs.each(function (idx, el) {
			span[idx] = document.createElement('span');
			span[idx].className = el.type;

			if (el.checked === true) {
				var position = '0 -' + (checkboxHeight * 2) + 'px';
				span[idx].style.backgroundPosition = position;
			}

			el.parentNode.insertBefore(span[idx], el);

			el.toggle();

			$(el).on('change', function (e) {
				e.preventDefault();

				if (el.checked === true) {
					el.previousSibling.style.backgroundPosition = '0 -' + (checkboxHeight * 2) + 'px';
				} else {
					el.previousSibling.style.backgroundPosition = '0 0';
				}

				$(el.form).trigger('submit');
			});

			$(span[idx]).on('mouseup', function (e) {
				e.preventDefault();

				if (el.checked === true) {
					el.checked = false;
				} else {
					el.checked = true;
				}

				$(el).trigger('change');
			});
		});

		filterForm.on('submit', function (e) {
			e.preventDefault();
			loadingContainer.fadeIn(100);

			var filterVars = buildFilterVars();

			$.ajax({
				url: 'index.php',
				type: 'POST',
				dataType: 'html',
				data: {
					option: 'com_gazebos',
					view: 'producttype',
					tmpl: 'component',
					id: $('#producttype').val(),
					filter_style: filterVars.style,
					filter_shape: filterVars.shape,
					filter_material: filterVars.material,
					filter_price: filterVars.price,
					ajax: true
				},
				success: function (data) {
					setTimeout(function () {
						$('#content').html(data);
						loadingContainer.fadeOut(100);
					}, 1000);
				}
			});
		});

		var buildFilterVars = function () {
			var arr = [];
			var style = [];
			var shape = [];
			var price = [];
			var material = [];

			filterInputs.each(function (idx, el) {
				if (el.checked === true) {
					var parts = el.name.replace('[]', '').split('_');
					var selectedArray = eval(parts[1]);
					selectedArray.push(el.value);
				}
			});

			arr.style = style;
			arr.shape = shape;
			arr.price = price;
			arr.material = material;

			// Push an empty var to the array
			// so the form still get's submitted.
			arr.style.push(0);
			arr.style.push(0);
			arr.price.push(0);
			arr.material.push(0);

			return arr;
		};

	})(jQuery);
});

(function ($) {
	$('#content .producttype .removeFilter').live('click', function (e) {
		e.preventDefault();
	
		var base = $(this);
		var filterId = base.attr('rel');
		var el = $(filterId);
	
		if (el.is(':checked')) {
			el.attr('checked', false);
		} else {
			el.attr('checked', true);
		}
	
		el.trigger('change');
		base.hide();
	});
})(jQuery);