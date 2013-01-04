jQuery(document).ready(function($){

	var favorites = $('#favorites');

	favorites.show();

	favorites.find('.toggle').click(function (e) {
		leftPos = parseInt(favorites.css('left'));
		
		if (leftPos == 0)
		{
			favorites.animate({left: -200})
		}
		else
		{
			favorites.animate({left: 0});
		}
	});

	$('a.add2fav').live('click', function(){
		var baseId	= $(this).attr('id');
		var addId	= baseId.split('-');

		if (parseInt(favorites.css('left')) == -200)
		{
			favorites.animate({left: '+=10'}, 200, 'swing', function(){favorites.animate({left: '-=10'});});
		}

		$.post('/index.php',
			{
				option:	'com_gazebos',
				tmpl:	'component',
				task:	'product.addFavorite',
				id:		addId[1]
			},
			function(resp){
				if (resp.type == 'success') {
					$('.favorites .contents .intro').hide();
					$(resp.html).hide().appendTo('.favorites .contents').fadeIn(500);
				}
			},
			'json'
		);
	});
	$('a.rm_fav').live('click', function(){
		var baseId	= $(this).attr('id');
		var rmId	= baseId.split('-');
		
		$.post('/index.php',
			{
				option:	'com_gazebos',
				tmpl:	'component',
				task:	'product.delFavorite',
				id:		rmId[1]
			},
			function(resp){
				if (resp.type == 'success')
				{
					$('#remove-' + resp.id).parent('.info').parent('.favorite').remove();
				}
			},
			'json'
		);
	});
});