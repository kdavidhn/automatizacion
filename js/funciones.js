


 function ltr(e){
        key=e.keyCode || e.which;
        tec=String.fromCharCode(key).toLowerCase();
        letras="1234567890";
        especiales="8-17-37-38-46-164";
        teclado_esp=false;

        for(var i in especiales){
            if(key==especiales[i]){
                teclado_esp=true;break;
            }
        }
if (letras.indexOf(tec)==-1 && !teclado_esp){
return false; 
}
    }

     function p(es){
        var valor = "";
        valor = es.value.replace(/^0*1*3*4*5*6*7*8*9*/, '');

        es.value = valor;
      }




    $(document).on('ready', function() {
            $('#show-hide-passwd').on('click', function(e) {
                e.preventDefault();
                var current = $(this).attr('action');
                if (current == 'hide') {
                    $(this).prev().attr('type','text');
                    $(this).removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close').attr('action','show');
                }
                if (current == 'show') {
                    $(this).prev().attr('type','password');
                    $(this).removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open').attr('action','hide');
                }
            })
        })

      $(document).on('ready', function() {
            $('#show-hide-passwd2').on('click', function(e) {
                e.preventDefault();
                var current = $(this).attr('action');
                if (current == 'hide') {
                    $(this).prev().attr('type','text');
                    $(this).removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close').attr('action','show');
                }
                if (current == 'show') {
                    $(this).prev().attr('type','password');
                    $(this).removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open').attr('action','hide');
                }
            })
        })

      $(document).on('ready', function() {
            $('#show-hide-passwd3').on('click', function(e) {
                e.preventDefault();
                var current = $(this).attr('action');
                if (current == 'hide') {
                    $(this).prev().attr('type','text');
                    $(this).removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close').attr('action','show');
                }
                if (current == 'show') {
                    $(this).prev().attr('type','password');
                    $(this).removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open').attr('action','hide');
                }
            })
        })


    $(document).on('ready', function() {
            $('#clave_usuario').on('click', function(e) {
                e.preventDefault();
                var current = $(this).attr('action');
                if (current == 'hide') {
                    $(this).prev().attr('type','text');
                    $(this).removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close').attr('action','show');
                }
                if (current == 'show') {
                    $(this).prev().attr('type','password');
                    $(this).removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open').attr('action','hide');
                }
            })
        })

    $(document).on('ready', function() {
            $('#confirmar_clave_usuario').on('click', function(e) {
                e.preventDefault();
                var current = $(this).attr('action');
                if (current == 'hide') {
                    $(this).prev().attr('type','text');
                    $(this).removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close').attr('action','show');
                }
                if (current == 'show') {
                    $(this).prev().attr('type','password');
                    $(this).removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open').attr('action','hide');
                }
            })
        })


 function ValidaMail($Correo_electronico) {
    
    if (ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([_a-zA-Z0-9-]+\.)*[a-zA-Z0-9-]{2,200}\.[a-zA-Z]{2,6}$", $Correo_electronico ) ) 
    { 
        return true; 
    } 
    else 
    { 
        return false; 
    } 
}


function comprobar(esto, e, id){

      var record=0;
      var igual=1;
      var letraRecord;
      var b=0;
      var letra="";

      var key=e.keyCode || e.which;
      var teclado = String.fromCharCode(key).toLowerCase();
      var letras="abcdefghijklmnñopqrstuvwxyz";
      var especiales="8-37-38-46-164";
      var teclado_especial=false;

      for(var i in especiales){
        if(key==especiales[i]){
          teclado_especial=true;break;
        }
      }

      if(letras.indexOf(teclado)==-1 && !teclado_especial){
        return false;
      }
      
      for (a=1;a<esto.length;a++){
      
        if (esto.charAt(a)==esto.charAt(b)){
          igual=igual+1;
          letra=esto.charAt(a);
        } else {
          if(igual>record){
          record=igual;
          letraRecord=letra;
          }
          igual=1
        }
        b=a
        }

      if(igual>record){
      record=igual;
      letraRecord=letra;
      }
      if (record>2) {
        //alert("La letra que más se repite es la "+letraRecord+" que aparece seguida "+record+" veces.");


      var texto = document.getElementById(id);
      texto.value = texto.value.substring(0, texto.value.length - 1);
      }
      } 


var getDadta = function()
{
    var nombreusuario = document.getElementById("nombreusuario").value;
    var res=nombreusuario;
    var str = '';
    var ref = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for (var i=0; i<2; i++)
    str += ref.charAt(Math.floor(Math.random()*ref.length));
    document.getElementById("user").value=str+res;
}



var getDadtaclave = function()
{
    
    var str = '';
    var ref = 'abcdefghijklmnopkrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890@#$%&/?¡¿*+-.,;';
    for (var i=0; i<8; i++)
    str += ref.charAt(Math.floor(Math.random()*ref.length));
    document.getElementById("contrasenau,confirmar_contrasenau").value=str;
}





        //No permite Espacio
        function Espacio(campo, event) {

            CadenaaReemplazar = " ";
            CadenaReemplazo = "";
            CadenaTexto = campo.value;
            CadenaTextoNueva = CadenaTexto.split(CadenaaReemplazar).join(CadenaReemplazo);
            campo.value = CadenaTextoNueva;

        }

        //No permite doble Espacio
        function DobleEspacio(campo, event) {

            CadenaaReemplazar = "  ";
            CadenaReemplazo = " ";
            CadenaTexto = campo.value;
            CadenaTextoNueva = CadenaTexto.split(CadenaaReemplazar).join(CadenaReemplazo);
            campo.value = CadenaTextoNueva;

        }

        //Solo permite letras
             function Letras(e) {
                 tecla = (document.all) ? e.keyCode : e.which;

                 //Tecla de retroceso para borrar, siempre la permite
                 if (tecla == 8) {
                     return true;
                 }

                 // Patron de entrada, en este caso solo acepta  letras
                 patron = /[A-Z a-z]/;
                 tecla_final = String.fromCharCode(tecla);
                 return patron.test(tecla_final);
             }

             //Solo permite Numeros
             function Numeros(e) {
                 tecla = (document.all) ? e.keyCode : e.which;

                 //Tecla de retroceso para borrar, siempre la permite
                if (tecla == 8) {
                     return true;
                 }

                 // Patron de entrada, en este caso solo acepta  letras
                 patron = /[0-9]/;
                 tecla_final = String.fromCharCode(tecla);
                 return patron.test(tecla_final);
             }
             
 function Depto(e) {
                 tecla = (document.all) ? e.keyCode : e.which;

                 //Tecla de retroceso para borrar, siempre la permite
                if (tecla == 8) {
                     return true;
                 }

                 // Patron de entrada, en este caso solo acepta  letras
                 patron = /[a-zA-Z0-9-]/;
                 tecla_final = String.fromCharCode(tecla);
                 return patron.test(tecla_final);
             }

             function Cont(e) {
                 tecla = (document.all) ? e.keyCode : e.which;

                 //Tecla de retroceso para borrar, siempre la permite
                if (tecla == 8) {
                     return true;
                 }

                 // Patron de entrada, en este caso solo acepta  letras
                 patron = /[a-zA-Z0-9.@ ]/;
                 tecla_final = String.fromCharCode(tecla);
                 return patron.test(tecla_final);
             }

              function identid(esto, e, id){

      var record=0;
      var igual=1;
      var letraRecord;
      var b=0;
      var letra="";

      var key=e.keyCode || e.which;
      var teclado = String.fromCharCode(key).toLowerCase();
      var letras="1234567890";
      var especiales="8-37-38-46-164";
      var teclado_especial=false;

      for(var i in especiales){
        if(key==especiales[i]){
          teclado_especial=true;break;
        }
      }

      if(letras.indexOf(teclado)==-1 && !teclado_especial){
        return false;
      }
      
      for (a=1;a<esto.length;a++){
      
        if (esto.charAt(a)==esto.charAt(b)){
          igual=igual+1;
          letra=esto.charAt(a);
        } else {
          if(igual>record){
          record=igual;
          letraRecord=letra;
          }
          igual=1
        }
        b=a
        }

      if(igual>record){
      record=igual;
      letraRecord=letra;
      }
      if (record>3) {
        //alert("La letra que más se repite es la "+letraRecord+" que aparece seguida "+record+" veces.");


      var texto = document.getElementById(id);
      texto.value = texto.value.substring(0, texto.value.length - 1);
      }
      } 

      function pierdeFoco(e){
        var valor = "";
        valor = e.value.replace(/^2*3*4*5*6*7*8*9*/, '');

        e.value = valor;
      }


//telefono celular
function cel(esto, e, id){

      var record=0;
      var igual=1;
      var letraRecord;
      var b=0;
      var letra="";

      var key=e.keyCode || e.which;
      var teclado = String.fromCharCode(key).toLowerCase();
      var letras="1234567890";
      var especiales="8-37-38-46-164";
      var teclado_especial=false;

      for(var i in especiales){
        if(key==especiales[i]){
          teclado_especial=true;break;
        }
      }

      if(letras.indexOf(teclado)==-1 && !teclado_especial){
        return false;
      }
      
      for (a=1;a<esto.length;a++){
      
        if (esto.charAt(a)==esto.charAt(b)){
          igual=igual+1;
          letra=esto.charAt(a);
        } else {
          if(igual>record){
          record=igual;
          letraRecord=letra;
          }
          igual=1
        }
        b=a
        }

      if(igual>record){
      record=igual;
      letraRecord=letra;
      }
      if (record>3) {
        //alert("La letra que más se repite es la "+letraRecord+" que aparece seguida "+record+" veces.");


      var texto = document.getElementById(id);
      texto.value = texto.value.substring(0, texto.value.length - 1);
      }
      } 

      function pierde(e){
        var valor = "";
        valor = e.value.replace(/^0*1*2*4*5*6*7*/, '');

        e.value = valor;
      }
