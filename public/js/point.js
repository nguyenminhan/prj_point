
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
    // $('#transactionUuid').focus()
    // setTimeout(function(){$('#transactionUuid').focus();}, 2000);
  });

  $(document).on('keyup', '#transactionUuid', function(e) {
    var transactionUuid = $('#transactionUuid').val();
    localStorage.setItem('transactionUuid', transactionUuid);
    // setTimeout(function(){$('#ok').focus();}, 2000);
  });
  
  $(document).on('click', '#ok', function(e) {
  	  e.preventDefault();
  	  var customer_code = ($('#customer_code').val()).trim();
  	  var transactionUuid = ($('#transactionUuid').val()).trim();

      // if(customer_code){
      //   var value = localStorage.getItem("customer_code") === null ? "": localStorage.getItem("customer_code")
      //   $('#customer_code').val(value)
      // }
      

      if(customer_code == ''){
        swal("エラーになりました。", "会員が存在しません。", "warning");     
        return;
      }
      if(transactionUuid == ''){
        swal("エラーになりました。", "レシートIDが存在しません。", "warning");
        return;
      }

      // var check = false;
      // for (var i  in history_point) {
      //   if(history_point[i] == transactionUuid){
      //       swal("エラーになりました。", "すでにこのレシートは登録されています。", "warning");
      //       check = true;
      //       break;
      //   }
      // }

      // if (!check) {
        $.ajax({
            type:'POST',
            url:url,
            data:{
              'transactionUuid' : localStorage.getItem("transactionUuid"),
              'customer_code' : localStorage.getItem("customer_code")
            },
          }).done(function (response) {
            result = JSON.parse(response);
            if (result.error_code != 0) {
                if(result.error_code == 6) {
                  swal("エラーになりました。",result.error_msg, "warning");  
                  return;   
                }else if(result.error_code == 5){
                  swal("エラーになりました。",result.error_msg, "warning");   
                  return;
                }else if(result.error_code == 4){
                  swal("エラーになりました。",result.error_msg, "warning");   
                  return;
                }else if(result.error_code == 7){
                  swal("エラーになりました。",result.error_msg, "warning");   
                  return;
                } else if(result.error_code == 8) {
                  swal("エラーになりました。",result.error_msg, "warning");   
                  return;
                }              
            }
            swal("ポイント付与完了しました。", "今のポイントは"+result.id+"です", "success");           
            $('#customer_code').focus();
            $('#transactionUuid').val(null);
            $('#customer_code').val(null);
            localStorage.setItem("transactionUuid",'')
            localStorage.setItem("customer_code",'')
        }).fail(function (response) {
          swal("エラーになりました。","会員が存在しません。", "warning");     
        });
      // }      
   });

    $('.panel-body').on('keyup keypress', function(e) {
       var keyCode = e.keyCode || e.which;
       if (keyCode === 13) {
           e.preventDefault();
           return false;
       }
   });

    


	

