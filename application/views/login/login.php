<?php 
    if($this->session->userdata('session_sop')!="") {
            redirect('/');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?= base_url('assets/login')?>/libraries/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login')?>/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/login')?>/libraries/xzoom/xzoom.css"/>
    <link rel="stylesheet" href="<?= base_url('assets/login')?>/libraries/gijgo/combined/css/gijgo.min.css">
    <link href="https://fonts.googleapis.com/css?family=Assistant|Playfair+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/login')?>/styles/main.css"/>
</head>
<body class="bg">

    <main>
      <div class="container">
      <div class="section-succes" style="margin-top: 150px;">
      <div class="card">      
        <form action="<?= base_url('login/act_login')?>" method="post" id="upload">
          <div class="col">
            <div class="show_error" style="margin-bottom:10px">
            </div>
            <img style="width: 400px;" src="<?= base_url('assets/login')?>/images/logo.png" alt="Logo Filkom">
            <div class="form-group">
              <input type="text" class="form-control" id="inputUsername" placeholder="Username" name="username">
              <br>
            </div>
            <div class="form-group">
              <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="password">
            </div>
            
            <div class="form-group align-items-center">           
              <div class="col d-flex align-items-center login-tengah">   
                <button class="btn btnlogin" id="send-btn">
                  Login <i class="fa fa-sign-in"></i>
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </main>
    <script src="<?= base_url('assets/login')?>/libraries/jquery/jquery-3.5.0.min.js"></script>
    <script src="<?= base_url('assets/login')?>/libraries/bootstrap/js/bootstrap.js"></script>
    <script src="<?= base_url('assets/login')?>/libraries/retina/retina.min.js"></script>
    <script src="<?= base_url('assets/login')?>/libraries/xzoom/xzoom.min.js"></script>
    <script src="<?= base_url('assets/login')?>/libraries/gijgo/combined/js/gijgo.min.js"></script>
    <script>
         $(document).ready(function(){
            $('.xzoom, .xzoom-gallery').xzoom({
                zoomwidth: 500,
                title: false,
                tint: "#333",
                xoffset: 15
            });

            $('.datepicker').datepicker({
                uilibrary: 'bootstrap4',
                icons: {
                    rightIcon: '<img src="frontend/images/ic_doe.png">'
                }
            })
         });
    </script>
    <script>
      $("#upload").submit(function(){
        var mydata = new FormData(this);
        var form = $(this);
        $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: mydata,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend : function(){
                $("#send-btn").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>  Send...");
                form.find(".show_error").slideUp().html("");
            },
                success: function(response, textStatus, xhr) {
                var str = response;
                if (str.indexOf("oke") != -1){
                    document.getElementById('upload').reset();
                    $("#send-btn").removeClass("disabled").html("Login");
                     location.href = '<?= base_url("/") ?>';
                }else{
                     $("#send-btn").removeClass("disabled").html("Login");
                    form.find(".show_error").hide().html(response).slideDown("fast");
                }
            },
            error: function(xhr, textStatus, errorThrown) {
            }
        });
        return false;
      });
    </script>
</body>
</html>