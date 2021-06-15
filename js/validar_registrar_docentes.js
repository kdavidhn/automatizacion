/*=======================================================
=  VALIDACION LOGIN MAYUSCULAS Y PARAMETROS CONTRASEÑA =
=========================================================*/
function myFunction1(){                    
    var a = document.getElementById("user");
    a.value = a.value.toUpperCase();
    }
    
              function mostrarPassword(){
    
                var cambio = document.getElementById("password");
                
                if(cambio.type == "password"){
                  
                  cambio.type = "text";
                  
                  $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                
                }else{
                  
                  cambio.type = "password";
                  
                  $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                }
              } 
            
              $(document).ready(function () {
    
                //CheckBox mostrar contraseña
                $('#ShowPassword').click(function () {
                  
                  $('#password').attr('type', $(this).is(':checked') ? 'text' : 'password');
    
                });
    
              });
    
    
    
    
    /*=============================================
    =   MAYUSCULAS REGISTRO Y EDITAR USUARIO          =
    =============================================*/
    
    function myFunction2(){                    
    var a = document.getElementById("nuevoNombre");
    a.value = a.value.toUpperCase();
    }
    
    function myFunction12(){                    
      var a = document.getElementById("nuevoApellido");
      a.value = a.value.toUpperCase();
      }
    
    function myFunction3(){                    
    var a = document.getElementById("nuevoUsuario");
    a.value = a.value.toUpperCase();
    }
    
    function myFunction4(){                    
    var a = document.getElementById("editarNombre");
    a.value = a.value.toUpperCase();
    }
    
    function myFunction5(){                    
    var a = document.getElementById("editarUsuario");
    a.value = a.value.toUpperCase();
    }
    
    /*=============================================
    =  MOSTRAR CONTRASEÑA USUARIO         =
    =============================================*/
    
    function mostrarPassword2(){
        var cambio = document.getElementById("password");
        if(cambio.type == "password"){
          cambio.type = "text";
          $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
        }else{
          cambio.type = "password";
          $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
        }
      } 
      
      $(document).ready(function () {
      //CheckBox mostrar contraseña
      $('#ShowPassword').click(function () {
        $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
      });
    });
    
    function mostrarPassword3(){
        var cambio = document.getElementById("editarPassword");
        if(cambio.type == "password"){
          cambio.type = "text";
          $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
        }else{
          cambio.type = "password";
          $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
        }
      } 
      
      $(document).ready(function () {
      //CheckBox mostrar contraseña
      $('#ShowPassword').click(function () {
        $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
      });
    });
    
    
    
    /*=============================================
    =            MAYUSCULAS MODULO recuperarA     =
    =============================================*/
    function myFunction6(){                    
    var a = document.getElementById("recUsuario");
    a.value = a.value.toUpperCase();
    }
     
    /*=============================================
    =  VER CONTRASEÑAS EN RECUPERAR CONTRASEÑA    =
    =============================================*/
    function mostrarPassword4(){
        var cambio = document.getElementById("Bnueva");
        if(cambio.type == "password"){
          cambio.type = "text";
          $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
        }else{
          cambio.type = "password";
          $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
        }
      } 
      
      $(document).ready(function () {
      //CheckBox mostrar contraseña
      $('#ShowPassword').click(function () {
        $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
      });
    });
    
    
    function mostrarPassword5(){
        var cambio = document.getElementById("Bconfirmar");
        if(cambio.type == "password"){
          cambio.type = "text";
          $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
        }else{
          cambio.type = "password";
          $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
        }
      } 
      
      $(document).ready(function () {
      //CheckBox mostrar contraseña
      $('#ShowPassword').click(function () {
        $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
      });
    });
    
     
    
    
    /*=============================================
    =            MAYUSCULAS MODULO PARAMETRO    =
    =============================================*/
    function myFunction7(){                    
    var a = document.getElementById("nuevoParametro");
    a.value = a.value.toUpperCase();
    }
    
    function myFunction8(){                    
    var a = document.getElementById("editarParametro");
    a.value = a.value.toUpperCase();
    }
    
    /*=============================================
    =            MAYUSCULAS MODULO OBJETOS    =
    =============================================*/
    function myFunction9(){                    
    var a = document.getElementById("nuevoObjeto");
    a.value = a.value.toUpperCase();
    }
    function myFunction10(){                    
    var a = document.getElementById("nuevaDescripcionObjeto");
    a.value = a.value.toUpperCase();
    }
    
    /*=============================================
    =    VALIDAION QUE SOLO PERMITA UN ESPACIO          =
    =============================================*/
    
    
    function validate(s){
    if (/^(\w+\s?)*\s*$/.test(s)){
      return s.replace(/\s+$/,  '');
    }
    return 'NOT ALLOWED';
    }
    
    validate('test ing')      //'test ing'
    validate('testing')       //'testing'
    validate(' testing')      //'NOT ALLOWED'
    validate('testing ')      //'testing'
    validate('testing  ')     //'testing'
    validate('testing   ')    //'test ing'
    
    
    /*=============================================
     VALIDACION QUE SOLO PERMITA LETRAS Y NUMEROS             
    =============================================*/
    
    function letrasynumeros(e){
        
        key=e.keyCode || e.wich;
    
        teclado= String.fromCharCode(key).toUpperCase();
    
        letras= "ABCDEFGHIJKLMNOPQRSTUVWXYZÑ1234567890";
        
        especiales ="8-37-38-46-164";
    
        teclado_especial=false;
    
        for (var i in especiales) {
          
          if(key==especiales[i]){
            teclado_especial= true;break;
          }
        }
    
        if (letras.indexOf(teclado)==-1 && !teclado_especial) {
          return false;
        }
    
    }
    
    /*=====  End of Section comment block  ======*/
    
    
    /*==============================================
    =     VALIDACION SOLO LETRAS            =
    ==============================================*/
    function sololetras(e){
        
        key=e.keyCode || e.wich;
    
        teclado= String.fromCharCode(key).toUpperCase();
    
        letras= " ABCDEFGHIJKLMNOPQRSTUVWXYZÑ";
        
        especiales ="8-37-38-46-164";
    
        teclado_especial=false;
    
        for (var i in especiales) {
          
          if(key==especiales[i]){
            teclado_especial= true;break;
          }
        }
    
        if (letras.indexOf(teclado)==-1 && !teclado_especial) {
          return false;
        }
    
    }
    
    /*==============================================
    =        VALIDACION SOLO NUMEROS           =
    ==============================================*/
    function solonumeros(e){
        
        key=e.keyCode || e.wich;
    
        teclado= String.fromCharCode(key).toUpperCase();
    
        letras= "1234567890";
        
        especiales ="8-37-38-46-164";
    
        teclado_especial=false;
    
        for (var i in especiales) {
          
          if(key==especiales[i]){
            teclado_especial= true;break;
          }
        }
    
        if (letras.indexOf(teclado)==-1 && !teclado_especial) {
          return false;
        }
    
    }
    

    //no permite dobre espacio
    function DobleEspacio(campo, event) {

      CadenaaReemplazar = "  ";
      CadenaReemplazo = " ";
      CadenaTexto = campo.value;
      CadenaTextoNueva = CadenaTexto.split(CadenaaReemplazar).join(CadenaReemplazo);
      campo.value = CadenaTextoNueva;
    
    }
    
    
    
    
    