
  $(document).on('keyup', '#customer_code', function(e) {
    var customer_code = $('#customer_code').val();
     // console.log(customer_code);
    localStorage.setItem('customer_code', customer_code);
    setTimeout(function(){$('#transactionUuid').focus();}, 500);
  });

  $(document).on('keyup', '#transactionUuid', function(e) {
    var transactionUuid = $('#transactionUuid').val();
    localStorage.setItem('transactionUuid', transactionUuid);
    setTimeout(function(){$('#ok').focus();}, 500);
  });
  $(document).on('click', '#ok', function(e) {
  	// swal('Không được để trống');
  	e.preventDefault();
  	  var customer_code = $('#customer_code').val();
  	  var transactionUuid = $('#transactionUuid').val();
  	// console.log($('#customer_code').val() );
  	if(customer_code == '' && transactionUuid == ''){
  		// alert('ok');
  		swal("Fail!", "Bạn không được để trống!", "warning");
  		return;
  	}
  
      // console.log(customer_code);
    if (customer_code == '') {
      $('#customer_code').focus();
    }

    // if (localStorage.getItem("customer_code") == 13 && localStorage.getItem("transactionUuid") ===13 ) {
          $.ajax({
             type:'POST',
             url:'/getpoint',
             data:{

              'transactionUuid' : localStorage.getItem("transactionUuid"),
              'customer_code' : localStorage.getItem("customer_code")
             },
             
            }).done(function (response) {
            	// console.log(response);
            	// swal("Done!", "Điểm hiện tại của bạn là:"+response, "success");
            	$('#customer_code').focus();
            	$('#transactionUuid').val(null);
 				$('#customer_code').val(null);
            	localStorage.setItem("transactionUuid",'')
              	localStorage.setItem("customer_code",'')
              	
          });

        
    });
    $('.panel-body').on('keyup keypress', function(e) {
       var keyCode = e.keyCode || e.which;
       if (keyCode === 13) {
           e.preventDefault();
           return false;
       }
   });


	

