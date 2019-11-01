<script src="vendor/jquery/jquery.js"></script>
<link href="vendor/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">
<script src="vendor/bootstrap/dist/js/bootstrap.bundle.js"></script>
<link rel="stylesheet" type="text/css" href="vendor/bootstrap/dist/css/bootstrap.css">
<script src="vendor/datatables/datatables.js"></script>
<link href="vendor/datatables/datatables.css" rel="stylesheet" type="text/css">
<script src="vendor/select2/js/select2.full.js"></script>
<link href="vendor/select2/css/select2.css" rel="stylesheet" type="text/css">
<link href="./css.css" rel="stylesheet" type="text/css">
<!------ Include the above in your HEAD tag ---------->
<script>
function verificaLogin(){
    var user = $("#login").val();
    var pass = $("#password").val();
    var error = 0;
    var msg = "[ERROS ENCONTRADOS]: \n\n";

    if(user == ""){
        error+=1;
        msg += "- Preencha o campo login.\n";
    }

    if(pass == ""){
        error+=1;
        msg += "- Preencha o campo password.\n";
    }

    if(error > 0){
        alert(msg);
        return false;
    }else{
        $.ajax({
            url: './verificaLogin.php',
            datatType: 'text',
            type: "POST",
            data: {
                user:user,
                pass:pass
            },
            success: function(obj){
                if(obj > 0){
                    window.location.href = './console.php';
                }else{
                    alert('Usuário não encontrado.');
                }
            }
        });
    }
}
</script>
<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- name -->
        <div class="fadeIn first">
          <br>
          <span class="badge badge-secondary" style="font-size: 45px;font-weight: bold;">SIS</span><span style="font-size: 40px;font-weight: bold;">PROF</span>
          <br><br>
        </div>

        <!-- Login Form -->
        <input type="text" id="login" class="fadeIn second" name="login" placeholder="login">
        <input type="password" id="password" class="fadeIn third" name="password" placeholder="password">
        <input type="button" class="fadeIn fourth" value="Acessar" onclick="verificaLogin();">
        
        <!-- Icon -->
        <div class="fadeIn first">
          <img src="./img/logo-sedf.png" id="icon" alt="User Icon" />
          <br><br>
        </div>
    </div>
</div>