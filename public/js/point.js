

  $(document).on('click', '#ok', function(e) {

  	e.preventDefault();
  	var val_transactionUuid = $('#transactionUuid').val();
	var length_transactionUuid = val_transactionUuid.length;
	if ( parseInt(length_transactionUuid)  == 13 ) {
		$.ajax({
           type:'POST',
           url:'/getpoint',
           data:$('form').serialize(),
           success:function(data) {
              console.log(data);
           }
        });
	}else{
		alert('fail');
	}
  	
        
    });
 //  $("#id_form").on("submit", function(){
 //   //Code: Action (like ajax...)
 //   return false;
 // })

	

