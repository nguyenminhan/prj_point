// $( "#customer_code" ).change(function () {
    
//   setTimeout(function(){$('#transactionUuid').focus();}, 500)
//     // alert('3');
// });
  $(document).on('keyup', '#customer_code', function(e) {
    var customer_code = $('#customer_code').val();
     console.log(customer_code);
    localStorage.setItem('customer_code', $('#customer_code').val());
    setTimeout(function(){$('#transactionUuid').focus();}, 500);
  });

  $(document).on('keyup', '#transactionUuid', function(e) {
    var transactionUuid = $('#transactionUuid').val();
    localStorage.setItem('transactionUuid', transactionUuid);
    setTimeout(function(){$('#ok').focus();}, 500);
  });
  $(document).on('click', '#ok', function(e) {
  	e.preventDefault();

    var customer_code = $('#customer_code').val();
      console.log(customer_code);
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
              // localStorage.setItem('customer_code', '');
              // localStorage.setItem('transactionUuid', ''); 
              // $('#customer_code').focus();
              console.log(response)
          });
    // }else{
    //   console.log('l')
    // }

    // var customer_code = localStorage.getItem("customer_code") === null ? "": localStorage.getItem("customer_code");
    // var transactionUuid = localStorage.getItem("transactionUuid") === null ? "": localStorage.getItem("transactionUuid");
 //  var val_transactionUuid = $('#transactionUuid').val();
 //  var customer_code = $('#customer_code').val();

	// var length_transactionUuid = val_transactionUuid.length;
	// if ( parseInt(length_transactionUuid)  == 13 ) {
 //    // var transactionUuid = localStorage.setItem('val_transactionUuid', val_transactionUuid);
	// 	$.ajax({
 //           type:'POST',
 //           url:'/getpoint',
 //           data:{
 //            'transactionUuid' : val_transactionUuid,
 //            'customer_code' : customer_code
 //           },
           
 //        }).done(function (response) {
 //          $("#transactionUuid").val(null);
 //          $("#customer_code").val(null);  
 //          $('#transactionUuid').focus();
 //          $('#customer_code').focus();
 //          console.log(response)
 //        });
	// }else{
	// 	alert('fail');
	// }
  	
        
    });
 //  $("#id_form").on("submit", function(){
 //   //Code: Action (like ajax...)
 //   return false;
 // })

	

