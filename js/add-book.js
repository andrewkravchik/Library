$('#newbook').on('submit', function(e){
	
	$(this).attr("disabled", "disabled");
	e.preventDefault();

	var form = $(this),
		url  = form.attr("action"),
		type = form.attr("method"),
		data = {};

	form.find('[name]').each(function (index, value){
		var el = $(this);
		
		name = el.attr('name');
		value = el.val();

		data[name] = value;
	});

	//console.log(data);

	$.ajax({
		url: url,
		type: type,
		data: data,
		dataType: "json",
		async: true,
		success: function(data, textStatus, jqXHR){
			//var jqXHRtoString = '-----------------------\n<br/>';
				/*$.each(jqXHR, function(key, element) {
	    			//alert('key: ' + key + '\n' + 'value: ' + element);
	    			$jqXHRtoString += 'key_name - ' + key + ', ';
	    			$jqXHRtoString += 'element(value) - ' + element + '. \n<br/>';
				});*/
			//$('#result').html(jqXHRtoString);
			$('#result').html(jqXHR.responseJSON.message);

			//$('#result').html('Ваша книга добавлена');
			//$('#result').html(JSON.parse(jqXHR.responseText));
			//$('#result').removeClass('alert-warning');
			//$('#result').html($.parseJSON(response.responseText));
			//console.log('Echo success\n');

			//var response = $.parseJSON(jqXHR.responseText);

			// Всплывающее инфо-окно
			$('#result').removeClass('invisible');
			$('#result').addClass('visible');

			//console.log(jqXHR);
		},
		error: function(jqXHR, textStatus, errorThrown){
			//$('#result').html(JSON.parse(jqXHR.responseText));
			//$('#result').html(jqXHR.responseText);
			$('#result').html( jqXHR.responseJSON.message);
			//$('#result').removeClass('alert-info');
			//$('#result').addClass('alert-warning');

			//$('#result').html($.parseJSON(response.responseText));
			//console.log('Echo error\n');

			$('#result').removeClass('invisible');
			$('#result').addClass('visible');

			// Изменяем цвет алерта на красный если пользователь не заполнил все поля
			$alertsStyles = $('#result').attr('class');

			$('#result').attr('class', $alertsStyles + ' alert-danger');

			//console.log(jqXHR);
			//console.log('\n');

			//var response = $.parseJSON(jqXHR.responseText);

			//$('#result').html(jqXHR.responseText);
			//console.log(response);
			//console.log('\n');

			//console.log(jqXHR);
			//console.log(jqXHR.length);
			//console.log('\n------------------------------\n');
			//console.log(textStatus);
			//console.log('\n');
			//console.log(errorThrown);
		}
	});

	//return false;
});