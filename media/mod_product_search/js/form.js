jQuery.noConflict();
jQuery(document).ready(function ($) {
	(function ($) {
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
					ajax: true
				},
				success: function (data) {
					$('#ajaxLoader').show();
					setTimeout(function () {
						$('#content').html(data);
						$('#ajaxLoader').hide();
					}, 3000);
					
				}
			});
		});

		var successCallback = function (data) {
		};

		var buildFilterVars = function () {
			var arr = [];
			var style = [];
			var shape = [];
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
			arr.material = material;

			arr.style.push(0);
			arr.shape.push(0);
			arr.material.push(0);

			return arr;
		};

	})(jQuery);
});