pwf.wait_for('class', 'ui.form.workshop_ideas', function()
{
	var el = pwf.jquery('.concepts');

	pwf.create('ui.form.workshop_ideas', {
		'tag_overtake':true,
		'parent':el
	});
});
