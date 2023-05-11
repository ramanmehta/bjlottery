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
        <h4>Let's Register, and get points .</h4>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 loginform">
        <form id="login">
          <div class="form-group">
            <input type="text" class="form-control" id="name" name="name" placeholder="Your full name">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="username" name="username" placeholder="Choose an user name">
          </div>
          <div class="form-group">
            <input type="email" class="form-control" id="email" name="email" placeholder="Your email">
          </div>
          <div class="form-group">
            <input type="number" class="form-control" id="phone" name="phone" placeholder="Your phone">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" id="c_password" name="c_password" placeholder="Confirm Password">
          </div>
          <input type="submit" id="submit" class="pinkbtn" value="Register">
          {{-- <button type="submit" class="pinkbtn">Login</button> --}}
          <br>
          <div class="linkreg">
            <a href="#" class="lefta">Login</a>
            <a href="#" class="righta">Forget Password</a>
          </div>
          
        </form>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
  <script>
    // $("#login").validate();
    $("#login").validate({
      rules: {
        // simple rule, converted to {required:true}
        name: "required",
        username: "required",
        // compound rule
        email: {
          required: true,
          email: true,
        },
        phone: "required",
        password: "required",
        c_password: {
          required: true,
	        equalTo : "#password",
        },
      },
      messages: {
        name: "Your full name is required",
        username: "username is required",
        email: "Correct Email is required",
        password: "Password is required",
        c_password: {
          required: "Confirm password is required",
          equalTo: "Confirm password is not match",
        },
      },
      submitHandler: function() { 
        alert("Register!") 
      }


    });

    
  </script>
</body>
</html>