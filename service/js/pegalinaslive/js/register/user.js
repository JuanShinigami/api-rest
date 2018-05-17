// Variable para almacenar el input contrasena
var $password_user           = $("#password_user");
	
// Variable para almacenar el input repetir contrasena
var $repeat_password_user    = $("#repeat_password_user");

// Variable para almacenar el check
var $condiciones    = $("#condiciones");


// ***********************************************************************
// EVENTOS QUE SE EJECUTAN CUANDO INICIA UN AJAX Y CUANDO TERMINA
// ***********************************************************************
$(document)
.ajaxStart(function () {
	// Iniciamos panel de carga
	$.LoadingOverlay("show");
})
.ajaxStop(function () {
	// ocultamos panel de carga
	$.LoadingOverlay("hide");
});

// ***********************************************************************
// Cuando el documento esta listo
// ***********************************************************************
$(document).ready(function() {

	// Al hacer click en el boton registrate ahora
	$("#users_form").validetta({
		bubblePosition 	: 'bottom',
        bubbleGapTop 	: 10,
        bubbleGapLeft 	: 5,
        realTime  		: true,
		onValid 		: function( event ) {

			// Detenemos el evento
          	event.preventDefault();
          		
            // Validamos si las contrasenas son iguales
          	if ($password_user.val() != $repeat_password_user.val()) {

          		// Mostramos alerta
				swal(
		  			'Atención',
		  			'¡Las contraseñas no coinciden!',
		  			'warning'
				).catch(swal.noop);

			} else {

				if (grecaptcha.getResponse().length == 0) {
					
					// Mostramos alerta
	          		swal(
				  		'Opsss..',
				  		'¡Debes de comprobar que no eres un robot!',
				  		'warning'
					).catch(swal.noop);

	          	} else {
	          		//alert($("#condiciones").is(':checked'));
	          		if ($("#condiciones").is(':checked')) {
	          			// Mostramos alerta
	          		
	          		
	          		// iniciamos peticion
					$.ajax({
		        			url 		: $basePath + '/users/register',
		        			type 		: 'POST',
		        			dataType 	: 'json',
		        			data 		: $(this.form).serialize(),
		        	})
		        	.done(function(response) {
		        		console.log("success");
		        		console.log("response: " + response);
		        		
		        		// Validamos el response
		        		if (response.status == 'ok') {
		        			
		        			// Mostramos alerta
		        			swal({
		        				title: '¡Buen trabajo!',
	  							text: 'Gracias por registrarte en Recupera Pet ' + response.name,
	  							type: 'success',
		        				confirmButtonText: 'Iniciar Sesión'
		        			}).catch(swal.noop).then(function () {
								window.location = $basePath + '/auth/login';
							});

		        		} else if (response.status == 'fail') {

		        			swal(
				  				'Opsss..',
				  				'¡Correo electrónico duplicado. Intenta con otro!',
				  				'warning'
							).catch(swal.noop);

							grecaptcha.reset();

		        		}

			        })
			        .fail(function() {
			        	console.log("error");
			        })
			        .always(function() {
			        	console.log("complete");
			        });
			        }else{

	          			swal(
				  		'Opsss..',
				  		'¡Debes de aceptar terminos y condiciones!',
				  		'warning'
					).catch(swal.noop);
	          		}

		        }

			}

		}
   	});
	
});