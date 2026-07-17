//Questo codice utilizza jQuery per creare una funzionalità di creazione di un nuovo prodotto in un'applicazione web
$(document).ready(function() {

    // Quando l'utente clicca sul bottone "crea prodotto" (indicato dalla classe ".create-tavolo-button"), viene mostrato un modulo HTML per la creazione del prodotto
    $(document).on('click', '.create-tavolo-button', function(e) { // first par = event; second (optional) par = selector (in this case the class); last par = event handler
		e.preventDefault();
		// html for new tavolo form
		// NB il bottonr "read tavoli" è utile per tornare indietro alla lista di prodotti 	
		let create_tavolo_html=back_to_tavoli_button();
		create_tavolo_html+=`	
			<!-- 'create tavolo' html form -->
			<form id='create-tavolo-form' action='#' method='post' border='0'>
				<table class='table table-responsive table-bordered'>
					
					<!-- price field -->
					<tr>
						<td>Persone</td>
						<td><input type='number' min='1' name='persone' class='form-control' required /></td>
					</tr>
					<!-- description field -->
					<tr>
						<td>Esterno</td>
						<td>No<input type="radio" name='esterno' class='form-control form-check-input' value='0' checked>
						Si<input type="radio" name='esterno' class='form-control form-check-input' value='1'></td>
					</tr>

					<!-- button to submit form -->
					<tr>
						<td></td>
						<td>
							<button type='submit' class='btn btn-warning'>
								<span class='fa fa-plus'></span> Crea tavolo
							</button>
						</td>
					</tr>
				</table>
			</form>`;

		// inject html to 'page-content' of our app
		$("#page-content").html(create_tavolo_html);
 
		// cambia il titolo della pagina
		changePageTitle("Crea tavolo");
	});

    // Una volta inviato il modulo, i dati del nuovo prodotto vengono inviati al servizio di creazione tramite una richiesta HTTP "POST" e la pagina viene aggiornata per mostrare la lista dei prodotti
	$(document).on('submit', '#create-tavolo-form', function(e) { // first par = event; second (optional) par = selector (in this case the id); last par = event handler
		e.preventDefault();

		// get form data
		const form_data = JSON.stringify($(this).serializeObject()); // this = the submitted form
		
		// per il debugging...
		console.log("FORM DATA: "+form_data);
		
		sendRequest("create.php", showTavoli, "POST", form_data);
	});
});