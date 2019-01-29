
  window.onload = function(e){ 
    $('#customer_code').focus();
  }

  $(document).on('click', '.swal-button', function(e) {
   	location.reload();
    localStorage.setItem("transactionUuid",'')
    localStorage.setItem("customer_code",'')
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
    localStorage.setItem('customer_code', customer_code);
    setTimeout(function(){$('#transactionUuid').focus();}, 500);
  });

  $(document).on('keyup', '#transactionUuid', function(e) {
    var transactionUuid = $('#transactionUuid').val();
    localStorage.setItem('transactionUuid', transactionUuid);
    setTimeout(function(){$('#ok').focus();}, 500);
  });
  
  $(document).on('click', '#ok', function(e) {
  	  e.preventDefault();
  	  var customer_code = ($('#customer_code').val()).trim();
  	  var transactionUuid = ($('#transactionUuid').val()).trim();



      if(customer_code == ''){
        swal("エラーになりました。", "会員が存在しません。", "warning");     
        return;
      }
      // else{
      //   var val = localStorage.getItem("customer_code") === null ? "": localStorage.getItem("customer_code");
      //   console.log(val);
      //   $('#customer_code').val(val);
      // }
      if(transactionUuid == ''){
        swal("エラーになりました。", "レシートIDが存在しません。", "warning");
        return;
      }

      var check = false;
      for (var i  in history_point) {
        if(history_point[i] == transactionUuid){
          swal("エラーになりました。", "すでにこのレシートは登録されています。", "warning");
          check = true;
          break;
      }
    }
      if (!check) {
        $.ajax({
             type:'POST',
             url:url,
             data:{
                'transactionUuid' : localStorage.getItem("transactionUuid"),
                'customer_code' : localStorage.getItem("customer_code")
             },
             
            }).done(function (response) {
  
              swal("Done!", "今のポイントは"+response+"です", "success");
              $('#customer_code').focus();
              $('#transactionUuid').val(null);
              $('#customer_code').val(null);
              localStorage.setItem("transactionUuid",'')
              localStorage.setItem("customer_code",'')
                
          }).fail(function (res) {
              swal("エラーになりました。", "会員が存在しません。", "warning");     
          });
      }
// console.log( customer_code + ' is valid: ' + Barcoder.validate( customer_code ) );
//   console.log( transactionUuid + ' is valid: ' + Barcoder.validate( transactionUuid ) );

//   return;
 //  	if (transactionUuid.charAt(0) !== 'A' && transactionUuid.charAt(transactionUuid.length-1) !== 'A') {
 //  		swal("Fail!", "Mã barcode không hợp lệ!", "warning"); 
 //  		return;
	// }
  	// console.log($('#customer_code').val() );
  	
    // if(Barcoder.validate(transactionUuid) == true ){
          
    // }else{
    //   swal("Fail!", "Mã barcode không hợp lệ!", "warning");
    //     $('#transactionUuid').val(null);
    //     $('#customer_code').val(null);
    //     localStorage.setItem("transactionUuid",'')
    //     localStorage.setItem("customer_code",'')
    // }
        
    });

    $('.panel-body').on('keyup keypress', function(e) {
       var keyCode = e.keyCode || e.which;
       if (keyCode === 13) {
           e.preventDefault();
           return false;
       }
   });

    


	

