pwf.wait_for('module', 'jquery', function() {
	"use strict";

	var map = [
		{
			'ui':'ui.form.workshop_ideas',
			'selector':'.concepts'
		},
		{
			'ui':'ui.form.signup',
			'selector':'.form-signup'
		},
		{
			'ui':'ui.car.offers',
			'selector':'.car-offers'
		},

	];


	for (var i = 0 ; i < map.length; i++) {
		pwf.wait_for('class', map[i].ui, function(item) {
			return function() {
				var el = pwf.jquery(item.selector);

				if (el.length) {
					pwf.create(item.ui, {
						'tag_overtake':true,
						'parent':el
					});
				}
			};
		}(map[i]));
	}
});
