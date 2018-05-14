// Cuando carga el documento
$(document).ready(function() {

	// CARGAR DELEGACION O MUNICIPIO SI YA SE TIENE ASIGNADO UNO
	loadDistrictSelected();
	
	// CARGAR UNA COLONIA SI YA TIENE ASIGNADA UNA
	loadNeighborhoodSelected();

	// AL HACER UN CAMBIO EN EL COMBO ESTADO
	$("#state_of_mexico").change(function(event) {
		
		// Opcion seleccionada
		var $optionSelected = $("#state_of_mexico option:selected").val();

		// Validamos si se eligio un estado o no
		if ($optionSelected != 0 && $optionSelected != "") {
			// OBTENEMOS DELEGACIONES Y MUNICIPIOS
			getAllDistrict($optionSelected);
		} else {
			// Limpiar combo de delegacion y municipio
			$("#district").html('<option value="0">seleccione</option>');

			// Limpiar combo de colonia
			$("#neighborhood").html('<option value="0">seleccione</option>');

			// Limpiar campo de codigo postal
			$("#postal_code").val("");

			// Inicializamos el combo
			$("select").material_select();

			// Quitamos foco al campo codigo postal
			$("#postal_code").blur();
		}
	});

	// AL HACER UN CAMBIO EN EL COMBO DELEGACIONES Y MUNICIPIOS
	$("#district").change(function(event) {
		
		// Opcion seleccionada
		var $optionSelectedDistrict = $("#district option:selected").val();

		// Validamos si se eligio una delegacion o municipio
		if ($optionSelectedDistrict != 0 && $optionSelectedDistrict) {
			// OBTENEMOS LAS COLONIAS
			getAllNeighborhood($optionSelectedDistrict);
		} else {
			// Limpiar combo de colonia
			$("#neighborhood").html('<option value="0">seleccione</option>');

			// Limpiar campo de codigo postal
			$("#postal_code").val("");

			// Inicializamos el combo
			$("select").material_select();

			// Quitamos foco al campo codigo postal
			$("#postal_code").blur();
		}

	});

	// AL HACER UN CAMBIO EN EL COMBO COLONIA
	$("#neighborhood").change(function(event) {
		
		// Opcion seleccionada
		var $optionSelectedNeighborhood = $("#neighborhood option:selected");

		// Validamos si se eligio una colonia
		if ($optionSelectedNeighborhood.val() != 0 && $optionSelectedNeighborhood.val() != "") {

			// Asignamos un valor al input codigo postal
			$("#postal_code").val($optionSelectedNeighborhood.data('code'));

			// Asignamos foco
			$("#postal_code").focus();

		} else {
			// Limpiamos el valor del input codigo postal
			$("#postal_code").val("");

			// Quitamos foco
			$("#postal_code").blur();	
		}

	});
 
});

// OBTENEMOS TODAS LAS DELEGACIONES Y MUNICIPIOS
function getAllDistrict($id_state)
{
	// Combo delegaciones y municipios
	var $select_district 		= $('#district');
	
	// Opciones para agregar en el combo
	var $optionsComboDistrict 	= '<option value="0">seleccione</option>';

	// Llamada ajax
	$.ajax({
		url 		: $basePath + "/datosProveedor/addresses/getalldistrict",
		type 		: 'POST',
		dataType 	: 'json',
		data 		: {id_state : $id_state},
	})
	.done(function(response) {
		//console.log("success");

		// Validamos la respuesta
		if (response.response == "ok") {
			
			// Recorremos datos
			$.each(response.data, function(index, val) {

				// Generamos opciones del combo
				$optionsComboDistrict 	+= '<option value="' + val.id + '"  data-state="' + val.state_id + '">'
							 	 		+ val.name 
							 	 		+ '</option>' ;

			});
			
			// Agregamos las opciones al combo
			$select_district.html($optionsComboDistrict);

			// Inicializamos el combo
			$select_district.material_select();

			// Limpiar combo de colonia
			$("#neighborhood").html('<option value="0">seleccione</option>');

			// Inicializamos el combo
			$("#neighborhood").material_select();

			// Limpiar campo de codigo postal
			$("#postal_code").val("");

			// Quitamos foco al campo codigo postal
			$("#postal_code").blur();

		}

	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
	
}

// OBTENEMOS TODAS LAS COLONIAS
function getAllNeighborhood($id_district)
{	
	// Combo de colonias
	$select_neighborhood 		= $("#neighborhood");

	// Opciones para agregar en el combo
	$optionsComboNeighborhood	= '<option value="0">seleccione</option>';

	// Llamada ajax
	$.ajax({
		url 		: $basePath + "/datosProveedor/addresses/getallneighborhood",
		type 		: 'POST',
		dataType 	: 'json',
		data 		: {id_district: $id_district},
	})
	.done(function(response) {
		//console.log("success");

		// Validamos la respuesta
		if (response.response == "ok") {

			// Recorremos datos
			$.each(response.data, function(index, val) {
				
				// Generar opciones del combo
				$optionsComboNeighborhood 	+= '<option value="' + val.id + '" data-district="' + val.district_id + '" data-code="' + val.postal_code + '">'
											+ val.colony
											+ '</option>';

			});

			// Agregamos las opciones al combo
			$select_neighborhood.html($optionsComboNeighborhood);

			// Inicializamos combo
			$select_neighborhood.material_select();

			// limpiamos campo de codigo postal
			$("#postal_code").val("");

			// Quitamos foco de campo codigo postal
			$("#postal_code").blur();

		}

	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
	
}

// CARGAR DELEGACION O MUNICIPIO SI YA SE TIENE ASIGNADO UNO
function loadDistrictSelected()
{
	// Si hay un distrito
	if($district != 0 && $district != "")
	{

		// ID DE ESTADO
		var $id_state_selected 		= $("#state_of_mexico option:selected").val();

		// Combo delegaciones y municipios
		var $select_district 		= $('#district');
		
		// Opciones para agregar en el combo
		var $optionsComboDistrict 	= '<option value="0">seleccione</option>';

		// Llamada ajax
		$.ajax({
			url 		: $basePath + "/datosProveedor/addresses/getalldistrict",
			type 		: 'POST',
			dataType 	: 'json',
			data 		: {id_state : $id_state_selected},
		})
		.done(function(response) {

			// Validamos la respuesta
			if (response.response == "ok") {
				
				// Recorremos datos
				$.each(response.data, function(index, val) {

					// Generamos opciones del combo
					$optionsComboDistrict 	+= '<option value="' + val.id + '"  data-state="' + val.state_id + '">'
								 	 		+ val.name 
								 	 		+ '</option>' ;

				});
				
				// Agregamos las opciones al combo
				$select_district.html($optionsComboDistrict);

				// SELECCIONAMOS UN DISTRITO POR DEFAULT
				$('#district > option[value="'+$district+'"]').attr('selected', 'selected');

				// Inicializamos el combo
				$select_district.material_select();
			}

		})
		.fail(function() {
			//console.log("error");
		})
		.always(function() {
			//console.log("complete");
		});

	}
}

// CARGAR UNA COLONIA SI YA TIENE ASIGNADA UNA
function loadNeighborhoodSelected()
{
	// Si hay una colonia
	if($neighborhood != 0 && $neighborhood != "")
	{
		// Combo de colonias
		$select_neighborhood 		= $("#neighborhood");

		// Opciones para agregar en el combo
		$optionsComboNeighborhood	= '<option value="0">seleccione</option>';

		// Llamada ajax
		$.ajax({
			url 		: $basePath + "/datosProveedor/addresses/getallneighborhood",
			type 		: 'POST',
			dataType 	: 'json',
			data 		: {id_district: $district},
		})
		.done(function(response) {

			// Validamos la respuesta
			if (response.response == "ok") {

				// Recorremos datos
				$.each(response.data, function(index, val) {
					
					// Generar opciones del combo
					$optionsComboNeighborhood 	+= '<option value="' + val.id + '" data-district="' + val.district_id + '" data-code="' + val.postal_code + '">'
												+ val.colony
												+ '</option>';

				});

				// Agregamos las opciones al combo
				$select_neighborhood.html($optionsComboNeighborhood);

				// SELECCIONAMOS UNA COLONIA POR DEFAULT
				$('#neighborhood > option[value="'+$neighborhood+'"]').attr('selected', 'selected');

				// Inicializamos combo
				$select_neighborhood.material_select();

			}

		})
		.fail(function() {
			//console.log("error");
		})
		.always(function() {
			//console.log("complete");
		});
	}
}