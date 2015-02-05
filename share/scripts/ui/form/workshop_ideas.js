(function()
{
	"use strict";

	pwf.reg_class('ui.form.workshop_ideas', {
		"parents":['model.list', 'form'],
		'requires':['Workshop.Concept'],

		"storage":{
			"opts":{
				'action':'/formulare/koncept/feed',
				'heading':'Improtřesk 2015',
				'desc':'Improtřesk 2015',
				'model':'Workshop.Concept',
				'sort':[
					{
						'attr':'name',
					}
				],
				"elements":[
					{
						'name':'submited',
						'type':'hidden',
						'value':1
					},

					{
						'name':'name',
						'type':'text',
						'label':'Tvoje jméno',
						'required':true
					},

					{
						'name':'email',
						'type':'email',
						'label':'Tvůj e-mail',
						'required':true
					},

					{
						"name":'workshops',
						'label':'Vyber tři workshopy',
						'type':'checkbox',
						'multiple':true,
						'required':true,
						'value':[],
						'on_validate':function() {
							var val = this.val();

							return val.length > 0 && val.length <= 3;
						}
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

				p.storage.opts.elements[3].options = opts;

				p('create_meta');
				p('create_form_obj');
			}
		}
	});
})();
