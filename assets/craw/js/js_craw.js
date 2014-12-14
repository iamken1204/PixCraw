

$('#submit').click(function(){
	var crawler = new _crawler({
		artCode: $('#artCode').val(),
		bloCode: $('#bloCode').val(),
		url: $('#url').val()
	});
});


var _crawler = function(o) {

	$artCode = o.artCode,
	$bloCode = o.bloCode,
	$url = o.url,
	$total = 0;

	o.init = function() {
		o.checkInsert();
	}

	o.checkInsert = function() {
		if(!$artCode && !$bloCode)
			alert('請輸入搜尋參數')
		else if($artCode == 'all' || $bloCode == 'all'){
			for(i=1; i<45; i++){
				$artCode = i;
				$bloCode = i;
				o.getBlogLinks();
			}
			// alert('Done');
		}
		else{
			o.getBlogLinks();
			// alert('Done');
		}
	}

	o.getBlogLinks = function() {
		var artCount,
				bloCount;
		$.ajax({
			// async: false,
			url: $url,
			type: 'GET',
			dataType: 'json',
			data: {
				artCode: $artCode,
				bloCode: $bloCode
			},
			success: function(res, status, xhr){
				if(res.status == 'ok'){
					bloCount = res.accountList.length;
					artCount = res.articleList.length;
					if(bloCount > 0){
						$.each(res.accountList, function(key, val){
							$total++;
							$('.result').append('<b class="reText">'+val+'</b><br>');
						});
					}
					if(artCount > 0){
						$.each(res.articleList, function(key, val){
							$total++;
							$('.result').append('<b class="reText">'+val+'</b><br>');
						});
					}
					$('#count').text($total);
				}
			},
			error: function(){
				console.log('We failed!');
			},
		});
	}

	return o.init();
}