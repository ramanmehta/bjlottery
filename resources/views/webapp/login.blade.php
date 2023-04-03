<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <title>Lucky Draw</title>
  <meta name="description" content="Figma htmlGenerator">
  <meta name="author" content="htmlGenerator">


  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  {{-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
  <title>Lucky Draw</title>
  <link href="https://fonts.googleapis.com/css?family=Source+Sans Pro&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Skranji&display=swap" rel="stylesheet">
  <!-- Latest compiled and minified CSS -->

  <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
  
  <!------ Include the above in your HEAD tag ---------->
  <link rel="stylesheet" href="{{ asset('public/webapp/css/styles.css') }}">
  
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4 top-bg">
        <h4>Bj Lottery Lucky draw </h4>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 top-bg">
        <h4>Bj Lottery Lucky draw </h4>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 draw-heading">
        <div class="result"></div>
        {{-- <p class="result"></p> --}}
        <h4>Let's sign in , and redeem your daily claim .</h4>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 loginform">
        <form id="login" method="post">
          @csrf
          <div class="form-group">
            <input type="text" class="form-control" id="username" name="username" placeholder="Username">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
          </div>
          <input type="submit" id="submit" class="pinkbtn" value="Login">
          {{-- <button type="submit" class="pinkbtn">Login</button> --}}
          <br>
          <a href="#" class="lefta">Register</a>
          <a href="#" class="righta">Forget Password</a>
        </form>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
  <script src="{{ asset('public/webapp/js/api.js') }}"></script>
  <script>
    // $("#login").validate();
    // $("#login").validate({
    //   rules: {
    //     // simple rule, converted to {required:true}
    //     username: "required",
    //     // compound rule
    //     password: {
    //       required: true,
    //     }
    //   },messages:{
    //     username: "Please enter your user name",
    //     password: "Please enter your password",
    //   },
    //   submitHandler: function() { 
    //     alert("Submitted!") 
    //   }


    // });

    
  </script>
</body>
</html>