$("#login").validate({
    rules: {
      // simple rule, converted to {required:true}
      username: "required",
      // compound rule
      password: {
        required: true,
      }
    },messages:{
      username: "Please enter your user name",
      password: "Please enter your password",
    },

  
  });

  $('#login').submit(function(event){
    event.preventDefault();

    var formData = $(this).serialize();

    $.ajax({
      url: "http://localhost/laravel/bjlottery/api/login",
      type: "POST",
      data: formData,
      success: function(data){
        // console.log(data);
        if(data.success == false){
          $('.result').text(data.message);
        }
      }
    });
  });

