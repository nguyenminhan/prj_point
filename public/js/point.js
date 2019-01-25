
  window.onload = function(e){ 
    $('#customer_code').focus();
  }

  $(document).on('click', '.swal-button', function(e) {

 	location.reload();
    if($('#customer_code').val() == ''){
      $('#customer_code').focus();
    }else if ($('#transactionUuid').val() == '') {
       $('#transactionUuid').focus();
    }else{
      $('#customer_code').focus();
    }
  });

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

  	if (transactionUuid.charAt(0) !== 'A' && transactionUuid.charAt(transactionUuid.length-1) !== 'A') {
  		swal("Fail!", "Mã barcode không hợp lệ!", "warning"); 
  		return;
	}
  	// console.log($('#customer_code').val() );
  	if(customer_code == '' || transactionUuid == ''){
  		// alert('ok');
  		swal("Fail!", "Bạn không được để trống!", "warning");
  		return;
  	}
  
      // console.log(customer_code);
    if (customer_code == '') {
      $('#customer_code').focus();
    }
    // console.log(transactionUuid.length);
    // console.log(typeof(transactionUuid));
    // console.log(parseInt(transactionUuid));
    // return;
    if ( transactionUuid.length  ==13 ) {
          $.ajax({
             type:'POST',
             url:'/getpoint',
             data:{

              'transactionUuid' : localStorage.getItem("transactionUuid"),
              'customer_code' : localStorage.getItem("customer_code")
             },
             
            }).done(function (response) {
            	// console.log(response);
            	swal("Done!", "Điểm hiện tại của bạn là:"+response, "success");
            	// location.reload();
            	$('#customer_code').focus();
            	$('#transactionUuid').val(null);
 				$('#customer_code').val(null);
            	localStorage.setItem("transactionUuid",'')
              	localStorage.setItem("customer_code",'')
              	
          }).fail(function (res) {
          	// console.log(res);
             	swal("Fail!", "Mã barcode không hợp lệ!", "warning");     
           });
    }else{
      swal("Fail!", "Mã barcode không hợp lệ!", "warning");
      // $('#customer_code').focus();
        $('#transactionUuid').val(null);
        $('#customer_code').val(null);
        localStorage.setItem("transactionUuid",'')
        localStorage.setItem("customer_code",'')
    }
        
    });

    $('.panel-body').on('keyup keypress', function(e) {
       var keyCode = e.keyCode || e.which;
       if (keyCode === 13) {
           e.preventDefault();
           return false;
       }
   });

    


	

