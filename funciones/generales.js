// JavaScript Document

//funcion para cargar los div del contenido
function cargar(div, ruta_pagina){
    $(div).load(ruta_pagina);
}

//funcion para hacer visible la contraseña del login
function verOcultarPass(span,input){

	var input_cambio = document.getElementById(input);
	var span_cambio = document.getElementById(span);

	if(input_cambio.type == "password"){
		input_cambio.type = "text";
		$(span).removeClass('fa fa-eye-slash').addClass('fa fa-eye icon text-primary');
	}else{
		input_cambio.type = "password";
		$(span).removeClass('fa fa-eye icon text-primary').addClass('fa fa-eye-slash');
	}

}

//ocultar objetos id= #ejemplo, class= .ejemplo
function mostrar(obj){
	$(obj).show();
}
//ocultar objetos id= #ejemplo, class= .ejemplo
function ocultar(obj){
	$(obj).hide();
}
//------------------------------------------------------------------
//---------------------INDEX --------------------------------------
//------------------------------------------------------------------
function iniciar_sesion(){
	usuario = $('#usuario').val();
	password = $('#password').val();
	if( (usuario.length > 1 && usuario.length <= 30) && (password.length > 1 && password.length <= 30) && caracEspeciales(usuario) && caracEspeciales(password)){
		
		var url = "funciones/valida_usuario.php"; // El script a dónde se realizará la petición.
		$.ajax({
			type: "POST",
			url: url,
			data: $("#formLogin").serialize(), // Adjuntar los campos del formulario enviado.
			success: function(data)
			{
				//alert(data);
				//$("#formLogin").attr("target", "NewAction");
				if(data > 0){//si no queremos redireccionar cambiar las condiciones por el comentado
					$("#formLogin").attr("action", "admin/index.php");
					$("#formLogin").submit();
				}else{
					//CONFIGURAR ERROR DE CONEXION
					var input_password = document.getElementById('password');
					var input_usuario = document.getElementById('usuario');
					$('#password').removeClass('form-control').addClass('form-control is-invalid');
					$('#usuario').removeClass('form-control').addClass('form-control is-invalid');
				}
			}
		});
	}
	else{
		var input_password = document.getElementById('password');
		var input_usuario = document.getElementById('usuario');
		$('#password').removeClass('form-control').addClass('form-control is-invalid');
		$('#usuario').removeClass('form-control').addClass('form-control is-invalid');
	}
	return false;
}

function registrar_empresa(){
	nombre = $('#nombre').val();
	usuario2 = $('#usuario2').val();	
	password2 = $('#password2').val();
	password3 = $('#password3').val();

	if( (nombre.length > 1 && nombre.length <= 50)  && caracEspeciales(nombre) ){$('#nombre').removeClass('form-control is-invalid').addClass('form-control is-valid');}
	else{$('#nombre').removeClass('form-control is-valid').addClass('form-control is-invalid'); return false;}

	if( (password2.length > 1 && password2.length <= 20)  && caracEspeciales(password2) ){$('#password2').removeClass('form-control is-invalid').addClass('form-control is-valid');}
	else{$('#password2').removeClass('form-control is-valid').addClass('form-control is-invalid'); return false;}

	if(( password3.length > 1 && password3.length <= 20)  && caracEspeciales(password3) ){$('#password3').removeClass('form-control is-invalid').addClass('form-control is-valid');}
	else{$('#password3').removeClass('form-control is-valid').addClass('form-control is-invalid'); return false;}

	if(password2 != password3){
		$('#password2').removeClass('form-control is-valid').addClass('form-control is-invalid');
		$('#password3').removeClass('form-control is-valid').addClass('form-control is-invalid'); 
		return false;
	}
	if( (usuario2.length > 1 && usuario2.length <= 30) && caracEspeciales(usuario2)){
		var datos = "usuario="+usuario2+"&id_usuario=0";
		var url = "funciones/valida_nombre_usuario.php"; // El script a dónde se realizará la petición.
		$.ajax({
			type: "POST",
			url: url,
			data: datos, // Adjuntar los campos del formulario enviado.
			success: function(data)
			{
				if(data == 0){//si es 0 no existe el usuario
					$('#usuario2').removeClass('form-control is-invalid').addClass('form-control is-valid');
					var url2 = "funciones/procesar_empresa.php"; // El script a dónde se realizará la petición.
					$.ajax({
						type: "POST",
						url: url2,
						data: $("#formRegister").serialize(), // Adjuntar los campos del formulario enviado.
						success: function(data)
						{
							if(data > 0){//si no queremos redireccionar cambiar las condiciones por el comentado
								$("#formRegister").attr("action", "admin/index.php");
								$("#formRegister").submit();
							}else{
								//CONFIGURAR ERROR DE CONEXION
								$('#usuario2').removeClass('form-control').addClass('form-control is-invalid');
							}
						}
					});
				}else{
					$('#usuario2').removeClass('form-control').addClass('form-control is-invalid');
				}
			}
		});
	}
	else{//si no tiene al menos dos letras o no pasa el filtro de caracteres especiales
	  $('#usuario2').removeClass('form-control').addClass('form-control is-invalid');
	}
	
	return false;
}

/*
function registrar_usuario(){
	//alert('hola');
	Swal.mixin({
		input: 'text',
		confirmButtonText: 'Siguiente',
		showCancelButton: true,
		progressSteps: ['1', '2', '3', '4']
		}).queue([
		{
			title: 'Empresa',
			text: 'Indique el nombre de su empresa'
		},
		{
			title: 'Usuario/Email',
			text: 'Introduzca nombre de usuario o email',
			preConfirm: (login) => {
				return fetch(`//api.github.com/users/${login}`)
				  .then(response => {
					if (!response.ok) {
					  throw new Error(response.statusText)
					}
					return response.json()
				  })
				  .catch(error => {
					Swal.showValidationMessage(
					  `Request failed: ${error}`
					)
				  })
			  }
		},
		{
			title: 'Password',
			text: 'Introduzca una clave',
			input: 'password'
		},
		{
			title: 'Repetir password',
			text: 'Repita la clave',
			input: 'password'
		}
		]).then((result) => {
		if (result.value) {
			const answers = JSON.stringify(result.value)
			Swal.fire({
			title: 'All done!',
			html: `
				Your answers:
				<pre><code>${answers}</code></pre>
			`,
			confirmButtonText: 'Lovely!'
			})
		}
	});
}
*/
//------------------------------------------------------------------
//---------------------USUARIOS --------------------------------------
//------------------------------------------------------------------
function valida_usuario(id_usuario){
	//alert(id_usuario);
	usuario = $('#usuario'+id_usuario).val();
	var input_usuario = document.getElementById('usuario'+id_usuario);
	if( (usuario.length > 1 && usuario.length <= 30) && caracEspeciales(usuario)){
		//alert('entra');
	  var url = "../funciones/valida_nombre_usuario.php"; // El script a dónde se realizará la petición.
	  $.ajax({
		type: "POST",
		url: url,
		data: $("#formLogin"+id_usuario).serialize(), // Adjuntar los campos del formulario enviado.
		success: function(data)
		{
		  //alert(data);
		  if(data == 0){//si es 0 no existe el usuario
			$('#usuario'+id_usuario).removeClass('form-control is-invalid').addClass('form-control is-valid');
			$("#botonNuevoUsuario"+id_usuario).prop('disabled', false);
		  }else{
			//if(input_usuario.classList.contains("form-control is-valid")){
			  //$('#usuario'+id_usuario).removeClass('form-control is-valid').addClass('form-control is-invalid');
			//}
			//else{
			  $('#usuario'+id_usuario).removeClass('form-control').addClass('form-control is-invalid');
			//}
			//$("#botonNuevoUsuario"+id_usuario).attr("disabled");
			$("#botonNuevoUsuario"+id_usuario).prop('disabled', true);
		  }
		}
	  });
	}
	else{//si no tiene al menos dos letras o no pasa el filtro de caracteres especiales
		//alert('else');
	  $('#usuario'+id_usuario).removeClass('form-control').addClass('form-control is-invalid');
	  $("#botonNuevoUsuario"+id_usuario).prop('disabled', true);
	}
	return false;
}

function valida_password(id_usuario){
	password = $('#password'+id_usuario).val();
	//alert(password);
	if( (password.length > 1 && password.length <= 20) && caracEspeciales(password)){
		$('#password'+id_usuario).removeClass('form-control is-invalid').addClass('form-control is-valid');
		$("#botonNuevoUsuario"+id_usuario).prop('disabled', false);
	}
	else{//si no tiene al menos dos letras o no pasa el filtro de caracteres especiales
		$('#password'+id_usuario).removeClass('form-control').addClass('form-control is-invalid');
		$("#botonNuevoUsuario"+id_usuario).prop('disabled', true);
	}
	return false;
}

function enviar_usuario(id_usuario){
	var url = "../funciones/procesar_usuario.php"; // El script a dónde se realizará la petición.
	$.ajax({
		type: "POST",
		url: url,
		data: $("#formLogin"+id_usuario).serialize(), // Adjuntar los campos del formulario enviado.
		success: function()
		{
		//alert(data);
		//recargamos la pagina
		location.reload();
		}
	});
}

function eliminar(id_usuario,usuario){
	Swal.fire({
		title: 'Deseas eliminar el usuari@ '+usuario+'?',
		text: "Se eliminarán todos los datos del sistema",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Sí, eliminar'
	}).then((result) => {
		if (result.value) {
		var datos_enviar = 'usuario=&password=&gestionar_turnos=&id_usuario='+id_usuario+'&operacion='+'D';
		var url = "../funciones/procesar_usuario.php"; // El script a dónde se realizará la petición.
		$.ajax({
			type: "POST",
			url: url,
			data: datos_enviar, // Adjuntar los campos del formulario enviado.
			success: function()
			{
			//recargamos la pagina
			location.reload();
			}
		});
		}
	})
}

//------------------------------------------------------------------
//---------------------EMPRESA --------------------------------------
//------------------------------------------------------------------
function valida_empresa(id_usuario){
	usuario = $('#usuario').val();
	datos = 'usuario='+usuario+'&id_usuario='+id_usuario+'&cuenta='+id_usuario;
	var input_usuario = document.getElementById('usuario');
	if( (usuario.length > 1 && usuario.length <= 30) && caracEspeciales(usuario)){
	  var url = "../funciones/valida_nombre_usuario.php"; // El script a dónde se realizará la petición.
	  $.ajax({
		type: "POST",
		url: url,
		data: datos, // Adjuntar los campos del formulario enviado.
		//data: $("#formLogin").serialize(), // Adjuntar los campos del formulario enviado.
		success: function(data)
		{
		  	//alert(data);
		  	if(data == 0){//si es 0 no existe el usuario
				$('#usuario').removeClass('form-control is-invalid').addClass('form-control is-valid');
				$("#botonNuevoUsuario").prop('disabled', false);
		  	}else{
				$('#usuario').removeClass('form-control').addClass('form-control is-invalid');
				$("#botonNuevoUsuario").prop('disabled', true);
		  }
		}
	  });
	}
	else{//si no tiene al menos dos letras o no pasa el filtro de caracteres especiales
		//alert('else');
	  $('#usuario').removeClass('form-control').addClass('form-control is-invalid');
	  $("#botonNuevoUsuario").prop('disabled', true);
	}
	return false;
}

function modificar_cuenta(){

	nombre = $('#nombre').val();
	usuario = $('#usuario').val();	
	password = $('#password').val();
	repassword = $('#repassword').val();

	if( (nombre.length > 1 && nombre.length <= 50)  && caracEspeciales(nombre) ){$('#nombre').removeClass('form-control is-invalid').addClass('form-control is-valid');}
	else{$('#nombre').removeClass('form-control is-valid').addClass('form-control is-invalid'); return false;}

	if( (password.length > 1 && password.length <= 20)  && caracEspeciales(password) ){$('#password').removeClass('form-control is-invalid').addClass('form-control is-valid');}
	else{$('#password').removeClass('form-control is-valid').addClass('form-control is-invalid'); return false;}

	if(( repassword.length > 1 && repassword.length <= 20)  && caracEspeciales(repassword) ){$('#repassword').removeClass('form-control is-invalid').addClass('form-control is-valid');}
	else{$('#repassword').removeClass('form-control is-valid').addClass('form-control is-invalid'); return false;}

	if(password != repassword){
		$('#password').removeClass('form-control is-valid').addClass('form-control is-invalid');
		$('#repassword').removeClass('form-control is-valid').addClass('form-control is-invalid'); 
		return false;
	}
	
	if( (usuario.length > 1 && usuario.length <= 30) && caracEspeciales(usuario)){
		//alert($("#formLogin").serialize());
		var url = "../funciones/procesar_empresa.php"; // El script a dónde se realizará la petición.
		$.ajax({
		  type: "POST",
		  url: url,
		  data: $("#formLogin").serialize(), // Adjuntar los campos del formulario enviado.
		  success: function(data)
		  	{
				//alert(data);
				location.reload();
		  	}
		});
	}
	else{//si no tiene al menos dos letras o no pasa el filtro de caracteres especiales
		  //alert('else');
		$('#usuario'+id_usuario).removeClass('form-control').addClass('form-control is-invalid');
		$("#botonNuevoUsuario"+id_usuario).prop('disabled', true);
	}
	return false;
}

//------------------------------------------------------------------
//---------------------FRANJAS HORARIAS(TURNOS)--------------------------------------
//------------------------------------------------------------------
function enviar_turno(id_turno){
	//alert('jj');
	descripcion = $('#descripcion'+id_turno).val();
	if( caracEspeciales(descripcion) ){
		var url = "../funciones/procesar_turno.php"; // El script a dónde se realizará la petición.
		$.ajax({
		type: "POST",
		url: url,
		data: $("#formLogin"+id_turno).serialize(), // Adjuntar los campos del formulario enviado.
		success: function()
		{
			//alert(data);
			//recargamos la pagina
			location.reload();
		}
		});
	}
}

  function eliminar_turno(id_turno){
	descripcion = $('#descripcion'+id_turno).val();
	if(descripcion != ''){
		var pregunta = 'Deseas archivar la franja horaria '+descripcion+'?';
	}
	else{
		pregunta = 'Deseas archviar la franja horaria?';
	}
	Swal.fire({
	  title: pregunta,
	  text: "Ya no podrá modificar los datos de esta franja horaria",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Sí, archivar'
	}).then((result) => {
	  if (result.value) {
		var datos_enviar = 'id_turno='+id_turno+'&operacion=D';
		var url = "../funciones/procesar_turno.php"; // El script a dónde se realizará la petición.
		$.ajax({
		  type: "POST",
		  url: url,
		  data: datos_enviar, // Adjuntar los campos del formulario enviado.
		  success: function()
		  {
			//recargamos la pagina
			location.reload();
			//alert(data);
		  }
		});
	  }
	});
  }



//------------------------------------------------------------------
//---------------------TURNOS(RESERVAS)--------------------------------------
//------------------------------------------------------------------

function cargar_datos(id_turno){
	if(id_turno > 0){
	  $('#botonmas').removeClass('btn bg-gradient-light btn-app d-none').addClass('btn bg-gradient-light btn-app');
	  $('#botonesLista').removeClass('btn-group btn-group-toggle d-none').addClass('btn-group btn-group-toggle');
	  cargar('#cabecera_datos','cabecera_reserva.php?id_turno='+id_turno+'&modo=0');
	  cargar('#contenido_datos','contenido_reserva.php?id_turno='+id_turno+'&modo=0');
	}
}

function enviar_modo(modo){
	cargar('#cabecera_datos','cabecera_reserva.php?modo='+modo);
	cargar('#contenido_datos','contenido_reserva.php?modo='+modo);
}

function eliminar_turno_desde_reserva(){
	if($('#select_turnos').val() > 0){
	  Swal.fire({
	  title: 'Deseas archivar la franja horaria?',
	  text: "Ya no podrá modificar los datos de esta franja horaria",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Sí, archivar'
	  }).then((result) => {
		if (result.value) {
		  var datos_enviar = 'id_turno=sesion&operacion=D';
		  var url = "../funciones/procesar_turno.php"; // El script a dónde se realizará la petición.
		  $.ajax({
			type: "POST",
			url: url,
			data: datos_enviar, // Adjuntar los campos del formulario enviado.
			success: function()
			{
			//recargamos la pagina
			location.reload();
			//alert(data);
			}
		  });
		}
	  });
	}
	
}

function crear_reserva(place_campo1,place_campo4){      
	Swal.fire({
		html:
		'<br><br><br><br><br><br><br>Nuevo Turno' +
		'<input type="text" id="swal-input4" class="form-control" placeholder="'+place_campo1+'">' +
		'<input type="number" id="swal-input2" class="form-control" placeholder="Núm de personas" min="1">' +
		'<input type="text" id="swal-input1" class="form-control" placeholder="Nombre de la reserva">' +
		'<textarea id="swal-input3" class="form-control" placeholder="'+place_campo4+' (Opcional podrá rellenarlo después)"></textarea>' +
		'<input type="number" id="swal-input5" class="form-control" placeholder="Cuenta (Opcional podrá rellenarlo depués)" step="any" value="0" min="0">',

		focusConfirm: false,
		showCancelButton: true,
		confirmButtonText: 'Crear',
		cancelButtonText: 'Cancelar',
		preConfirm: () => {
		  var descripcion_corta = document.getElementById('swal-input1').value;
		  var num_personas = document.getElementById('swal-input2').value;
		  var descripcion_larga = document.getElementById('swal-input3').value;
		  var mesa = document.getElementById('swal-input4').value;
		  var cuenta = document.getElementById('swal-input5').value;
		  var datos = 'operacion=I&descripcion_corta='+descripcion_corta+'&num_personas='+num_personas+'&descripcion_larga='+descripcion_larga+'&mesa='+mesa+'&cuenta='+cuenta;
		  var url = "../funciones/procesar_reserva.php"; // El script a dónde se realizará la petición.
		  $.ajax({
			type: "POST",
			url: url,
			data: datos, // Adjuntar los campos del formulario enviado.
			success: function()
			  {
				cargar('#cabecera_datos','cabecera_reserva.php');
				cargar('#contenido_datos','contenido_reserva.php');
			  }
		  });

		}
	})
	
}


//------------------------------------------------------------------
//---------------------ESTADISTICAS---------------------------------
//------------------------------------------------------------------
function enviar_horarios(){
	//alert($("#formHorarios").serialize());
	$("#formHorarios").submit();
}

function cambiaMes(mes,anyo){
	if(mes.length == 2 && anyo.length == 4){
		//alert(mes+'-'+anyo);
		var datos_enviar = 'mes='+mes+'&anyo='+anyo;
		var url = "recoger.php"; // El script a dónde se realizará la petición.
		$.ajax({
		  type: "POST",
		  url: url,
		  data: datos_enviar, // Adjuntar los campos del formulario enviado.
		  success: function()
		  {
			//recargamos la pagina
			location.reload();
			//alert(data);
		  }
		});
	}
}

//------------------------------------------------------------------
//---------------------FUNCION PARA VALIDACIONES -------------------
//------------------------------------------------------------------

function verificaAcentos(valor){
	var retorno = false;
	for (var i = 0; i< valor.length; i++) {
			 //var c = valor.charAt(i);
			 var c = valor.charCodeAt(i);
			 if (c == 241 || c == 209 || c == 224 || c == 225 || c == 192 || c == 193 || c == 232 || c == 233 || c == 200 || c == 201 || c == 236 || c == 237 || c == 204 || c == 205 || c == 242 || c == 243 || c == 210 || c == 211 || c == 249 || c == 250 || c == 217 || c == 218 || c == 252 || c == 220){
				 retorno = true;
				 //alert('encontrado'+c);
			  }
    }
	return retorno;
}
function caracEspeciales (valor){
	if( (valor.indexOf('ª') != -1) 
	|| (valor.indexOf('|') != -1) 
	|| (valor.indexOf('!') != -1) 
	|| (valor.indexOf('"') != -1) 
	|| (valor.indexOf('·') != -1) 
	|| (valor.indexOf('#') != -1) 
	|| (valor.indexOf('$') != -1) 
	|| (valor.indexOf('~') != -1) 
	|| (valor.indexOf('%') != -1) 
	|| (valor.indexOf('&') != -1) 
	|| (valor.indexOf('¬') != -1) 
	|| (valor.indexOf('(') != -1) 
	|| (valor.indexOf(')') != -1) 
	|| (valor.indexOf('=') != -1) 
	|| (valor.indexOf("'") != -1) 
	|| (valor.indexOf('?') != -1) 
	|| (valor.indexOf('¿') != -1) 
	|| (valor.indexOf('¡') != -1) 
	|| (valor.indexOf('`') != -1) 
	|| (valor.indexOf("'") != -1)
	|| (valor.indexOf('^') != -1) 
	|| (valor.indexOf('[') != -1) 
	|| (valor.indexOf(']') != -1) 
	|| (valor.indexOf('+') != -1) 
	|| (valor.indexOf('*') != -1) 
	|| (valor.indexOf('´') != -1) 
	|| (valor.indexOf('{') != -1) 
	|| (valor.indexOf('}') != -1) 
	|| (valor.indexOf(';') != -1) 
	|| (valor.indexOf('¨') != -1) 
	|| (valor.indexOf(':') != -1) 
	|| (valor.indexOf(' OR ') != -1) 
	|| (valor.indexOf(' or ') != -1) 
	|| (valor.indexOf(' like ') != -1)
	|| (valor.indexOf(' LIKE ') != -1)  
	|| (valor.indexOf('\x00') != -1) 
	|| (valor.indexOf('\x1a') != -1) ) {
		return false;
	}
	else {
		return true;
	}
}


