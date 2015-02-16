pwf.wait_for('class', 'ui.form.workshop_ideas', function()
{
	var el = pwf.jquery('.concepts');

	pwf.create('ui.form.workshop_ideas', {
		'tag_overtake':true,
		'parent':el
	});
});

pwf.wait_for('class', 'ui.form.signup', function()
{
	var el = pwf.jquery('.form-signup');

	pwf.create('ui.form.signup', {
		'tag_overtake':true,
		'parent':el
	});
});
