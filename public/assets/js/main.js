$(function() {
    
	    $.get(
			'/dashboard/gettimes',
			'week_day=' + $('#week_day_id').val() + '&teacher=' + $('#teacher_id').val(),
			function (data) { 
				if (data.status == 'ok') {
                    $('#l_time_id >').remove();
                    for (let com in data.data) {
                        $('#l_time_id').append($('<option value="' + data.data[com] + '">' + data.data[com] + '</option>'));
                    }  
				}
                
			},
			'json'
		)
    
    $(document).on('change','[rel=dh_field]',function(e) {
	    $.get(
			'/dashboard/gettimes',
			'week_day=' + $('#week_day_id').val() + '&teacher=' + $('#teacher_id').val(),
			function (data) { 
				if (data.status == 'ok') {
                    $('#l_time_id >').remove();
                    for (let com in data.data) {
                        $('#l_time_id').append($('<option value="' + data.data[com] + '">' + data.data[com] + '</option>'));
                    }  
				} /*else
					displayError(data.msg);*/
                
			},
			'json'
		)
    });
});