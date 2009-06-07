function addFieldset(formId) {
	var $target = $('#'+formId).children().filter(':first-child');
	//grab the first kid
	var $firstKid = $target.children().filter(':first-child');
	//grab the kids fieldset ids
	var firstKidIdPrefix = $firstKid.attr('id').split(/_[0-9]*$/i)[0];
	//clone the first Kid
	var $newKid = $firstKid.clone();
	//add the new kid to the end of the block
	$target.append($newKid);
	//now, change all the fieldnames to ascending numerical order
	var newNum = 1;
	var $allKids = $target.children();
	$allKids.each(function(i) { //loop
		$(this).attr('id', firstKidIdPrefix + '_' + newNum); //rename the fieldset
		$(this).find('input').each(function(i) { //rename the fieldset inputs
			renameField(this, 'id', newNum);
			renameField(this, 'name', newNum);
			if (newNum == $allKids.length) { //clear the content of the new fieldset
				$(this).attr('value', '');
			}
		});	
		//finally, add the delete button to the last fieldset only
		if (newNum == $allKids.length) {
			var d_html = '<div class="delete-button-div"><input type="button" id="delete_"'+newNum+
								' name="delete_"'+newNum+' value="Delete This Fieldset" onclick="deleteFieldset(this);"'+
								' class="delete-button" /></div>';
			$(this).append(d_html);
		}
		newNum++;
	});
}

function renameField(obj, attri, newNum) {
	var $el = $(obj);
	var a = $el.attr(attri).split(/_[0-9]*$/i)[0];
	$el.attr(attri, a+'_'+newNum);
}

function deleteFieldset(target) {
	$parentDivs = $(target).parents("div");
	$div = $parentDivs.eq(1).fadeOut("slow", function() {
		$(this).remove();
	});
}
