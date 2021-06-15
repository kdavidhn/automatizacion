function telfijo(){

	var celular, telfijo, cel, numcuenta, telemp, tel, telefonoemp;
	celular = document.getElementById("txt_telefono_celular");
	numcuenta = document.getElementById("txt_cuenta");
	telfijo = document.getElementById("txt_telefono_fijo");
	labora = document.getElementById("cb_maestria");
	telefonoemp = document.getElementById("txt_telefono_empresa");
	
celular.oninvalid = function(event) { event.target.setCustomValidity('Username should only contain lowercase letters. e.g. john'); }
