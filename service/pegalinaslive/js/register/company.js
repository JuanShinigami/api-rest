// Variable para almacenar el input contrasena
var $password_user         = $("#password_user");
	
// Variable para almacenar el input repetir contrasena
var $repeat_password_user  = $("#repeat_password_user");

// FORMULARIO contraseña sesion para email
$form_validate_email       = $("#form_validate_email");
$form_update_email         = $("#form_update_email");

// FORMULARIO contraseña sesion
$form_validate_pass        = $("#form_validate_pass");
$form_update_pass          = $("#form_update_pass");

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

// Inicializar combos
$('select').material_select();

// ***********************************************************************
// Cuando el documento esta listo
// ***********************************************************************
$(document).ready(function() {

   // Vista actual
   // console.log("currentView: " + currentView);
   $('.modal').modal();

   // Validamos la vista actual
   if(currentView == "addSupplier") {

      // OBTENER CHECKBOX SELECCIONADOS DE TIPO DE MASCOTA
      checkboxSelectedPetType();

      // OBTENER CHECKBOX SELECCIONADOS DE SECTOR DE ACTIVIDAD
      checkboxSelectedSectorActivity();

   }

	// Al hacer click en el boton registrate ahora
	$("#company_form").validetta({
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
	        	 console.log();
               var parametros = new FormData($(this.form)[0]);
	          	
               console.dir(parametros);
               
	          	// iniciamos peticion
					$.ajax({
		        			url        : $basePath + '/supplier/register',
		        			type       : 'POST',
		        			dataType   : 'json',
                     contentType: false, // importante enviar este parametro
											// en false
                     processData: false, // importante enviar este parametro
											// en false
		        			data       : parametros// $(this.form).serialize(),
		        	})
		        	.done(function(response) {
		        		console.log("success");
		        		
		        		// Validamos el response
		        		if (response.status == 'ok') {
		        			
		        			// Mostramos alerta
		        			swal({
		        				title: '¡Buen trabajo!',
	  							text: 'Gracias por registrarte en Recupera Pet ' + $("#name_company").val(),
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

		        }

			}

		}
   });

   // Al hacer click en el boton guardar
   $("#company_update_form").validetta({
      bubblePosition    : 'bottom',
      bubbleGapTop      : 10,
      bubbleGapLeft     : 5,
      realTime          : true,
      onValid           : function( event ) {

         // Detenemos el evento
         event.preventDefault();

         // Datos del formulario
         var parametros = new FormData($(this.form)[0]);
                  
         // iniciamos peticion
         $.ajax({
            url         : $basePath + '/supplier/index',
            type        : 'POST',
            dataType    : 'json',
            contentType : false, // importante enviar este parametro en false
            processData : false, // importante enviar este parametro en false
            data        : parametros// $(this.form).serialize(),
         })
         .done(function(response) {
            
            console.log("success");
                  
            // Validamos el response
            if (response.status == 'ok') {
                     
               // Mostramos alerta
               swal(
                  'Correcto',
                  '¡Los datos se actualizaron correctamente!',
                  'success'
               ).catch(swal.noop);

            } else if (response.status == 'fail') {

               swal(
                  'Error',
                  '¡Ocurrio un error, intentalo nuevamente!',
                  'error'
               ).catch(swal.noop);

            }

         })
         .fail(function() {
            console.log("error");
         })
         .always(function() {
            console.log("complete");
         });

      }
   });

   // VALIDAR FORMULARIO PARA COMPROBAR SI LA CONTRASEÑA ACTUAL DE INICIO DE
	// SESION ES CORRECTA (Cambiar pass)
   $form_validate_pass.validetta({
      bubblePosition: 'bottom',
      bubbleGapTop: 10,
      bubbleGapLeft: 0,
      realTime : true,
      onValid : function( event ) {

         event.preventDefault();

         $.ajax({
            url: $basePath + '/users/perfil',
            type: 'POST',
            dataType: 'json',
            data: $(this.form).serialize(),
         })
         .done(function(response) {
            // console.log(response.password[0].count);

            // Validamos la respuesta
            if (response.password[0].count == 1) {
               
               $('#div_pass_actual').hide();
               $('#div_update_pass').show();

            } else if(response.password[0].count == 0) {
               swal(
                  'Opsss..',
                  '¡La contraseña no es correcta!',
                  'error'
               ).catch(swal.noop);
            }

         })
         .fail(function() {
            console.log("error");
         })
         .always(function() {
            console.log("complete");
         });

      }
   });

   // VALIDAR FORMULARIO PARA COMPROBAR SI LA CONTRASEÑA ACTUAL DE INICIO DE
	// SESION ES CORRECTA (Cambiar email)
   $form_validate_email.validetta({
      bubblePosition: 'bottom',
      bubbleGapTop: 10,
      bubbleGapLeft: 0,
      realTime : true,
      onValid : function( event ) {

         event.preventDefault();

         $.ajax({
            url: $basePath + '/users/perfil',
            type: 'POST',
            dataType: 'json',
            data: $(this.form).serialize(),
         })
         .done(function(response) {
            // console.log(response.password[0].count);
            
            // Validamos la respuesta
            if (response.password[0].count == 1) {
                  
                  $('#div_pass_actual_2').hide();
                  $('#div_update_email').show();

            } else if(response.password[0].count == 0) {
               swal(
                  'Opsss..',
                  '¡La contraseña no es correcta!',
                  'error'
               ).catch(swal.noop);
            }

         })
         .fail(function() {
            console.log("error");
         })
         .always(function() {
            console.log("complete");
         });

      }
   });

   // VALIDAR FORMULARIO DE CAMBIO DE CONTRASEÑA
   $form_update_pass.validetta({
         bubblePosition: 'bottom',
         bubbleGapTop: 10,
         bubbleGapLeft: 0,
         realTime : true,
         onValid : function( event ) {

            event.preventDefault();

            // Validamos si los codigos qr son correctos
            if ($('#change_pass').val() != $("#change_pass2").val()) {
               // Mostramos alerta
               swal(
                  'Atención',
                  '¡Las contraseñas no coinciden!',
                  'error'
               );
                  
            } else {
               
               var parametros = new FormData($(this.form)[0]);

               $.ajax({
                  url         : $basePath + '/users/updatepass',
                  type        : 'POST',
                  dataType    : 'json',
                  contentType : false, // importante enviar este parametro en
										// false
                  processData : false, // importante enviar este parametro en
										// false
                  data        : parametros// $(this.form).serialize(),
               })
               .done(function(response) {
                  // console.log(response);
                  // console.log("success");
                  if (response.status == 'ok') {

                     // window.location = $basePath + '/users/perfil';
                     // Mostramos alerta
                     swal(
                        'Correcto',
                        '¡La contraseña se actualizo correctamente!',
                        'success'
                     ).catch(swal.noop);

                  } else if(response.status == 'fail'){
                     swal(
                        'Opsss..',
                        '¡Ocurrio un error intentalo de nuevo!',
                        'error'
                     );
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
   });

   // VALIDAR FORMULARIO DE CAMBIO DE EMAIL
   $form_update_email.validetta({
      bubblePosition: 'bottom',
      bubbleGapTop: 10,
      bubbleGapLeft: 0,
      realTime : true,
      onValid : function( event ) {

         event.preventDefault();

         // Validamos si los codigos qr son correctos
         if ($('#change_email').val() != $("#change_email2").val()) {
            
            // Mostramos alerta
            swal(
               'Atención',
               '¡Los correos electr&oacute;nicos no coinciden!',
               'error'
            );
                        
         } else {
                    
            var parametros = new FormData($(this.form)[0]);

            $.ajax({
               url            : $basePath + '/users/updateemail',
               type           : 'POST',
               dataType       : 'json',
               contentType    : false, // importante enviar este parametro en
										// false
               processData    : false, // importante enviar este parametro en
										// false
               data           : parametros// $(this.form).serialize(),
            })
            .done(function(response) {
               // console.log(response);
               // console.log("success");

               if (response.status == 'ok') {
                  swal(
                     'Atención',
                     '¡Cerraremos tu sesión para que inicies con tu nueva cuenta de correo electrónico!',
                     'success'
                  ).then(function () {
                     window.location = $basePath + '/auth/logout';
                  });
                            
               } else if(response.status == 'fail') {
                           
                  swal(
                     'Opsss..',
                     '¡Ocurrio un error intentalo de nuevo!',
                     'error'
                  );

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
   });

   // Click en checkbox pet type
   $(".check_pet_type").click(function(event) {

   	// OBTENER CHECKBOX SELECCIONADOS DE TIPO DE MASCOTA
   	checkboxSelectedPetType();

   });

   // Click en checkbox sector activity
   $(".check_sector_activity").click(function(event) {

   	// OBTENER CHECKBOX SELECCIONADOS DE SECTOR DE ACTIVIDAD
   	checkboxSelectedSectorActivity();

  	});

   // ************************************************************************
   // Al hacer un cambio en el input imagen
   // ************************************************************************
   /*
	 * $(".change_image_preview").change(function () { // LLamamos a la funcion
	 * previewImgArticle(this,"preview_img_pet"); });
	 */

});

// OBTENER CHECKBOX SELECCIONADOS DE TIPO DE MASCOTA
function checkboxSelectedPetType()
{
   // Arreglo
   var $arrayPetTypeSelected 	= [];

   // Status
   var $statusPetType 			= 0;

   // Contenedor de checkbox
   $containerCheckboxPetType 	= $('.container-checkbox-pet-type input[type=checkbox]');

   // Recorremos contenedor de checkbox
   $containerCheckboxPetType.each(function(index, el) {
   			
   	// Asignamos status: 1 Seleccionado - 2 No seleccionado
   	if(this.checked) {
      	// Asignar status
   		$statusPetType = 1;
   	} else if(!this.checked) {
   		// Asignar status
   		$statusPetType = 0;
   	}

   	// Creamos objeto con los checkbox seleccionados
   	$arrayPetTypeSelected.push({
   		id 		: parseInt($(this).val()),
   		status 	: $statusPetType
   	});

   });

   // Agregamos el array a un campo de texto
   $("#pet_type_checkbox").val(JSON.stringify($arrayPetTypeSelected));

   console.log("arrayPetTypeSelected: " + JSON.stringify($arrayPetTypeSelected));

   return JSON.stringify($arrayPetTypeSelected);
}

// OBTENER CHECKBOX SELECCIONADOS DE SECTOR DE ACTIVIDAD
function checkboxSelectedSectorActivity()
{
   // Arreglo
   var $arraySectorActivitySelected 	= [];

   // Status
   var $statusSectorActivity 			= 0;

   // Contenedor de checkbox
   $containerCheckboxSectorActivity 	= $('.container-checkbox-sector_activity input[type=checkbox]');

   // Recorremos contenedor de checkbox
   $containerCheckboxSectorActivity.each(function(index, el) {
   			
      // Asignamos status: 1 Seleccionado - 2 No seleccionado
      if(this.checked) {
      	// Asignar status
      	$statusSectorActivity = 1;
      } else if(!this.checked) {
      	// Asignar status
      	$statusSectorActivity = 0;
      }

      // Creamos objeto con los checkbox seleccionados
      $arraySectorActivitySelected.push({
      	id 		: parseInt($(this).val()),
      	status 	: $statusSectorActivity
      });

   });

   // Agregamos el array a un campo de texto
   $("#sector_activity_checkbox").val(JSON.stringify($arraySectorActivitySelected));

   console.log("arraySectorActivitySelected: " + JSON.stringify($arraySectorActivitySelected));

   return JSON.stringify($arraySectorActivitySelected);
}

// Funcion de vista previa de imagen
function showPreview(objFileInput) {
   if (objFileInput.files[0]) {

      var fileReader = new FileReader();

      fileReader.onload = function (e) {
         $(objFileInput).parents('.targetOuter').find('.targetLayer').html('<img src="'+e.target.result+'" width="200px" height="200px" class="upload-preview" />');
         $(objFileInput).parents('.targetOuter').find('.targetLayer').css('opacity','0.7');
         $(objFileInput).parents('.targetOuter').find('.icon-choose-image').css('opacity','0.5');
      }

      fileReader.readAsDataURL(objFileInput.files[0]);

   }
}