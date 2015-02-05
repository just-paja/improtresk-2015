(function()
{
	"use strict";

	pwf.reg_class('ui.form.workshop_ideas', {
		"parents":['model.list', 'form'],
		'requires':['Workshop.Concept'],

		"storage":{
			"opts":{
				'model':'Workshop.Concept',
				"elements":[
					{
						'name':'name',
						'type':'text',
						'label':'Jméno',
						'required':true
					},

					{
						'name':'email',
						'type':'email',
						'label':'E-mail',
						'required':true
					},

					{
						"name":'workshops',
						'label':'Vyberte tři workshopy',
						'type':'checkbox',
						'multiple':true,
						'maxlength':3,
						'required':true,
						'value':[]
					},

					{
						'label':'Poslat',
						'element':'button',
						'type':'submit'
					}
				]
			}
		},


		'proto':{
			'create_struct':function(p)
			{
				this.load();
			},


			'loaded':function(p)
			{
				var
					items = p.storage.dataray.data,
					opts  = [];

				for (var i = 0 ; i < items.length; i++) {
					var label = pwf.jquery.div('workshop-option');

					label.create_divs(['name', 'desc']);

					label.name.html(items[i].get('name'));
					label.desc.html(items[i].get('desc'));

					opts.push({
						'name':label,
						'value':items[i].get('id')
					});
				}

				p.storage.opts.elements[2].options = opts;

				p('create_meta');
				p('create_form_obj');
			}
		}
	});
})();
