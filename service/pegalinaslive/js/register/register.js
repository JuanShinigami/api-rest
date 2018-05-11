// Constantes
var TYPE_USER 		= 1;
var TYPE_COMPANY 	= 2;

// CONTENEDORES DE DATOS

// Contenedor de datos de acceso
var $containerDataSign 				= $("#container-data-sign");

// Contenedor de datos de contacto o personales
var $containerDataContactPersonal 	= $("#container-data-contact-personal");

// Contenedor de datos de la empresa
var $containerDataCompany 			= $("#container-data-company");

// Contenedor de acciones
var $containerAllActions 			= $("#container-all-actions");

// Contenedor de sector de actividad
var $containerDataActivitySector 	= $("#container-data-activity-sector");

// Contenedor de galeria de imagenes
var $containerGalleryImage 			= $("#container-gallery-image");

// contenedor de sitio web
var $container_website        		= $("#container_website");

// TITULOS
$titleDataContactPersonal 			= $(".title-data-contact-personal");


	// Variable para almacenar el input contrasena
	var $password_user           = $("#password_user");
	
	// Variable para almacenar el input repetir contrasena
	var $repeat_password_user    = $("#repeat_password_user");
	
	// Nombre
	var $label_name_user         = $("#label_name_user");
	
	// Apellido paterno
	var $container_surname       = $("#container_surname");
	
	// campus
	var $container_campus        = $("#container_campus");
	
	// key_inventory
	var $container_key_inventory = $("#container_key_inventory");
	
	// key_inventory
	var $container_pin           = $("#container_pin");

	// variables para proveedor

	// brand
	var $container_brand        = $("#container_brand");
	// company_description
	var $container_company_description        = $("#container_company_description");
	// website
	
	// nombre banco
	var $container_name_bank        = $("#container_name_bank");
	// numero de cuenta
	var $container_number_acount        = $("#container_number_acount");
	// numero de cuenta
	var $container_interestingin        = $("#container_interestingin");

	var $container_name_company        = $("#container_name_company");
	var $container_sector        = $("#container_sector");
	
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

	// Inicializar combos
	$('select').material_select();

	// Al hacer click en el input radio tipo de usuario
	$('input[name="radio_type_user"]:radio').change(function(event) {

		// Valor de input radio tipo de usuario
		$valInputRadioTypeUser = this.value;

		// Asignamos un valor al campo type_user
		$("#type_user").val($valInputRadioTypeUser);

		// Mostramos contenedor de datos de acceso
		$containerDataSign.fadeIn(2500, function() {
		});

		// Mostramos contenedor de datos personales
		$containerDataContactPersonal.fadeIn(2500, function() {
		});

		// Mostramos contenedor de las acciones
		$containerAllActions.fadeIn(2500, function() {
		});

		// VALIDAMOS EL TIPO DE USUARIO
		if ($valInputRadioTypeUser == TYPE_USER ) {
			
			console.log("Soy persona");

			// Cambiamos el texto al titulo de datos de contacto o personales
			$titleDataContactPersonal.text("Datos personales");

			// Remover clase validate del campo nombre de la empresa
			$('#name_company').removeClass('validate');

			// Remover atributo data-validetta del campo nombre de la empresa
			$('#name_company').removeAttr('data-validetta');

			// Remover atributo data-vd-message-required del campo nombre de la empresa
			$('#name_company').removeAttr('data-vd-message-required');

			// Ocultamos contenedor de empresa
			$containerDataCompany.fadeOut('fast', function() {
			});

			// Ocultamos contenedor de sitio web
			$container_website.hide();

			// Ocultamos contenedor de sector de actividad
			$containerDataActivitySector.fadeOut('fast', function() {
			});

			// Ocultamos contenedor de galeria de imagenes
			$containerGalleryImage.fadeOut('fast', function() {
			});

		} else if ($valInputRadioTypeUser == TYPE_COMPANY ) {
			
			console.log("Soy proveedor");

			// Cambiamos el texto al titulo de datos de contacto o personales
			$titleDataContactPersonal.text("Datos de contacto");

			// Agrehgar clase validate del campo nombre de la empresa
			$('#name_company').addClass('validate');

			// Agregar atributo data-validetta del campo nombre de la empresa
			$('#name_company').attr('data-validetta');

			// Agregar atributo data-vd-message-required del campo nombre de la empresa
			$('#name_company').attr('data-vd-message-required');

			// Mostramos contenedor de compania
			$containerDataCompany.fadeIn(2500, function() {
			});

			// Mostramos contenedor de sitio web
			$container_website.show();

			// Mostramos contenedor de sector de actividad
			$containerDataActivitySector.fadeIn(2500, function() {
			});

			// Mostramos contenedor de galeria de imagenes
			$containerGalleryImage.fadeIn(2500, function() {
			});

		}

	});

		// Al hacer un camnio e el input tipo de usuario
		/*$( 'input[name="type_user"]:radio').change(function() {

			// Valor del input
			var $valueTypeUser = this.value;

			// Validamos el tipo de usuario
			if ($valueTypeUser == 1) {
				// Eres persona

				// Cambiamos el texto
				$label_name_user.text("Nombre");

				// Mostramos el apellido
				$container_surname.show('fast');

				$('#surname').attr('data-validetta', 'required');

				$('#surname').attr('data-vd-message-required', 'Por favor ingrese su apellido!');

				// Ocultamos campus
				$container_campus.hide();
				//ocultamos campos de proveedor
				$container_brand.hide();
				$container_company_description.hide();
				$container_website.hide();
				$container_name_bank.hide();
				$container_number_acount.hide();
				$container_interestingin.hide();
				$container_name_company.hide();
				$container_sector.hide();
				

				$container_key_inventory.hide();
				

				$('#campus').removeAttr('data-validetta');

				$('#campus').removeAttr('data-vd-message-required');

				$('#name_company').removeAttr('data-validetta');

				$('#name_company').removeAttr('data-vd-message-required');

				
				$('#key_inventory').removeAttr('data-validetta');

				$('#key_inventory').removeAttr('data-vd-message-required');


				$('#pin').removeAttr('data-validetta');

				$('#pin').removeAttr('data-vd-message-required');

				// Limpiamos el campus
				$("#campus").val('');
				// Limpiamos la llave de inventario
			    $("#key_inventory").val('');
			    // Limpiamos el pin
			   // $("#pin").val('');


				// Mostramos el pin
				$container_pin.show('fast');

				$('#pin').attr('data-validetta', 'required');

				$('#pin').attr('data-vd-message-required', 'Por favor ingrese su pin!');


			}  else if ($valueTypeUser == 2) {
				// Eres empresa

				// Cambiamos el texto
				$label_name_user.text("Nombre de institución");

				// Ocultamos apellido
				$container_surname.hide();
				// Ocultamos campos de proveedor
				$container_brand.hide();
				$container_company_description.hide();
				$container_website.hide();
				$container_name_bank.hide();
				$container_number_acount.hide();
				$container_interestingin.hide();

				$('#surname').removeAttr('data-validetta');
				$('#surname').removeAttr('data-vd-message-required');
				// Limpiamos el apellido paterno
				$("#surname").val('');
				

				// Ocultamos pin
				$container_pin.hide();

				$('#pin').removeAttr('data-validetta');
				$('#pin').removeAttr('data-vd-message-required');
				// Limpiamos el pin
				$("#pin").val('');

				// Mostramos el campus
				$container_campus.show('fast');
				$container_key_inventory.show('fast');


				$('#campus').attr('data-validetta', 'required');

				$('#campus').attr('data-vd-message-required', 'Por favor ingrese el campus o su sucursal!');

				$('#key_inventory').attr('data-validetta', 'required');

				$('#key_inventory').attr('data-vd-message-required', 'Por favor ingrese una contraseña para que accedas a tu inventario!');


			}
			else if ($valueTypeUser == 3){
				// Eres proveedor
				//ocultamos campus
				$container_campus.hide();
				// Ocultamos apellido
				$container_surname.hide();
				// Ocultamos pin para recuperar contraseña
				$container_surname.hide();
				$container_key_inventory.hide();

				// Cambiamos el texto
				$label_name_user.text("Nombre del contacto");
				// Mostramos el campus
				//$container_brand.show('fast');
				$container_company_description.show('fast');
				$container_website.show('fast');
				//$container_name_bank.show('fast');
				//$container_number_acount.show('fast');
				//$container_interestingin.show('fast');
				//$container_pin.show('fast');
				$container_name_company.show('fast');
				$container_sector.show('fast');


				// Ocultamos pin
				$container_pin.hide();

				$('#pin').removeAttr('data-validetta');
				$('#pin').removeAttr('data-vd-message-required');
				// Limpiamos el pin
				$("#pin").val('');
				

				$('#campus').removeAttr('data-validetta');
				$('#campus').removeAttr('data-vd-message-required');
				$("#campus").val('');

				$('#key_inventory').removeAttr('data-validetta');
				$('#key_inventory').removeAttr('data-vd-message-required');
				$("#key_inventory").val('');

				$('#surname').removeAttr('data-validetta');
				$('#surname').removeAttr('data-vd-message-required');
				// Limpiamos el apellido paterno
				$("#surname").val('');
				

				


			}

    		//alert(this.value);
		});*/

	// Al hacer click en el boton registrate ahora
	$("#users").validetta({
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
		  			'error'
				).catch(swal.noop);
			} else {

				if (grecaptcha.getResponse().length == 0) {
					// Mostramos alerta
	          		swal(
				  		'Opsss..',
				  		'¡Debes de comprobar que no eres un robot!',
				  		'error'
					).catch(swal.noop);
	          	} else {
	          		
	          		// iniciamos peticion
					$.ajax({
		        			url 		: $basePath + '/users/register',
		        			type 		: 'POST',
		        			dataType 	: 'json',
		        			data 		: $(this.form).serialize(),
		        	})
		        	.done(function(response) {

		        		console.log(response);
		        		//console.log("success");
		        		if (response.status == 'ok') {
		        			
		        			// Mostramos alerta
		        			swal({
		        				title: '¡Buen trabajo!',
	  							text: 'Gracias por registrate en Recupera ' + response.name,
	  							type: 'success',
		        				confirmButtonText: 'Iniciar Sesión'
		        			}).catch(swal.noop).then(function () {
								window.location = $basePath + '/auth/login';
							});

		        		} else if (response.status == 'fail') {

		        			swal(
				  				'Opsss..',
				  				'¡Correo electrónico duplicado. Intenta con otro!',
				  				'error'
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

		        }

			}

		}
   	});

});