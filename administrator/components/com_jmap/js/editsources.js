/**
* Classe per la trasformazione e gestione della modalità di editing della newsletter 
* nello step 3 per la creazione del dialog div con lista utenti-DB assegnati alla newsletter
* 
* @package JMAP::administrator::components::com_jmap 
* @subpackage js 
* @author Joomla! Extensions Store
* @copyright (C)2013 Joomla! Extensions Store
* @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
*/

var EditSources = jQuery.newClass ({
	/**
	 * Selettori dei pulsanti singoli termini e add/delete globali 
	 * @access private
	 * @var array
	 */
	selettore : null,
	selettoreTargets : null, 
 
	/**
	 * Inizializzatore dell'oggetto 
	 * @access protected
	 * @param string selettore 
	 */
	init : function(selettore, selettoreTargets) {
		this.constructor.prototype.selettore = selettore;
		this.constructor.prototype.selettoreTargets = selettoreTargets;
		
		//Registrazione eventi
		this.registerEvents();
	},

	/**
	 * Registra gli eventi in risposta alla user interaction 
	 * @access private
	 * @return void 
	 */
	registerEvents : function() {
		var bind = this;
		
		//register events select articoli
		jQuery(this.selettore).bind('change', {bind:this}, function(event) {
			event.data.bind.getAjaxContent(event.target.value); 
		});
		
		jQuery('select, input, #sqlquery_rawparams', '#sqlquerier').bind('change', function(){
			jQuery('#regenerate_query').val(1);
		});
		
		jQuery('#dialog').dialog({'autoOpen':false, 'width':800, 'height': 600});
		jQuery('#dialog_trigger').bind('click', {bind:this}, function(event) {
			jQuery('#dialog').dialog('open');
			jQuery('iframe', '#dialog').attr('src', 'index.php?option=com_jmap&task=cpanel.showSuggestions&tmpl=component');
		});
	},
	
	/**
	 * Recupera via ajax server i dati relativi all'articolo attualmente selezionato
	 * mostrandoli nei campi titolo e testo articolo per il corretto storeEntity
	 * @access private
	 * @param String tableName
	 * @return void 
	 */
	getAjaxContent : function(tableName) { 
		//Oggetto con parametri che passeremo a PHP
		var ajaxparams = { 
				id : 'loadTableFields',
				template : 'json',
				param: tableName
		     };
		
		//Vogliamo passarlo come oggetto da decodificare con json_decode e quindi come unico parametro denominato 'data'
		var uniqueParam = JSON.stringify(ajaxparams); 
		//Chiamata JSON2JSON
		jQuery.ajax({
	        type:"POST",
	        url: "../administrator/index.php?option=com_jmap&task=ajaxserver.display&format=raw",
	        dataType: 'json',
	        context: this,
	        data: {data : uniqueParam } , 
	        success: function(response)  {
	        	if(response !== null) {
	        		this.populateSelectFields(response); 
	        	}
            }
		});   
	},
	
	/**
	 * Recupera via ajax server i dati relativi all'articolo attualmente selezionato
	 * mostrandoli nei campi titolo e testo articolo per il corretto storeEntity
	 * @access private
	 * @param String tableName
	 * @return void 
	 */
	populateSelectFields : function(responseData) { 
		var bindThis = this;
		jQuery(this.selettoreTargets).empty(); 
		// Inject default option
		var currentOpt = jQuery('<option value="">' + jmapselectfield + '</option>');
		jQuery(this.selettoreTargets).append(currentOpt);
		
		jQuery(responseData).each(function(index,item) {
			var currentOpt = jQuery('<option value="' + item + '">' + item + '</option>');
			jQuery(bindThis.selettoreTargets).append(currentOpt);
  		}); 
	}
}); 

jQuery(function(){
	// Start dell'application
	jQuery.editSources = new EditSources('#sqlquery_managedtable', 'select[data-role=tablefield]');
});