function rsfp_changePage(formId, page, totalPages, validate)
{
	if (validate)
	{
		var form = rsfp_getForm(formId);
		if (!ajaxValidation(form, page))
			return false;
	}
	
	for (var i=0; i<=totalPages; i++)
	{
		var thePage = document.getElementById('rsform_' + formId + '_page_' + i);
		if (thePage)
			document.getElementById('rsform_' + formId + '_page_' + i).style.display = 'none';
	}
	
	var thePage = document.getElementById('rsform_' + formId + '_page_' + page);
	if (thePage)
	{
		thePage.style.display = 'block';
		try {
			var func = window["rsfp_showProgress_" + formId];
			if (typeof func == "function") {
				func(page);
			}
		}
		catch (err) { }
	}
}