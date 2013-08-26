/**
* Classe per la gestione dei task client side nel pannello di controllo del componente
* 
* @package JMAP::administrator::components::com_jmap 
* @subpackage js 
* @author Joomla! Extensions Store
* @copyright (C)2013 Joomla! Extensions Store
* @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
*/
jQuery(function($){
	
	var CPanelTasks = $.newClass ({
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
			$(this.selettore).bind('change', {bind:this}, function(event) {
				event.data.bind.refreshCtrls(event.target.value); 
			});
		},
	
		/**
		 * Recupera via ajax server i dati relativi all'articolo attualmente selezionato
		 * mostrandoli nei campi titolo e testo articolo per il corretto storeEntity
		 * @access private
		 * @param String tableName
		 * @return void 
		 */
		refreshCtrls : function(value) { 
			var bindThis = this; 
			
			// Inject default option
			$(this.selettoreTargets).each(function(index, item) {
				switch($(item).prop('tagName').toLowerCase()) {
					case 'a':
						var currentValue = $(item).attr('href');
						var cleanedValue = currentValue.replace(/&lang=.+/gi, '');
						
						// If selezionato una lingua valida...
						if(value) {
							cleanedValue = cleanedValue + '&lang=' + value;
						}
						
						// Resetting value
						$(item).attr('href', cleanedValue);
					break;
					
					case 'input':
					default: 
						var currentValue = $(item).val();
						var cleanedValue = currentValue.replace(/&lang=.+/gi, '');
						
						// If selezionato una lingua valida...
						if(value) {
							cleanedValue = cleanedValue + '&lang=' + value;
						}
						
						// Resetting value
						$(item).val(cleanedValue);
				}				
	  		}); 
		}
	}); 
 
	// Start dell'application
	$.cpanelTasks = new CPanelTasks('#language_option', 'input[data-role=sitemap_links], a[href*=sitemap]');
});