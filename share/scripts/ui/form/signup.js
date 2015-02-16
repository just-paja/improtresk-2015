(function()
{
	"use strict";

	pwf.reg_class('ui.form.signump', {
		"parents":['model.list', 'form'],
		'requires':['Workshop'],

		"storage":{
			"opts":{
				'action':'/formulare/koncept/feed',
				'model':'Workshop.Concept',
				'sort':[
					{
						'attr':'name',
					}
				],

				'on_ready':function(err) {
					if (err) {
						this.display_error(err);
					} else {
						pwf.storage.store('concept_voted', pwf.moment().format('YYYY-MM-DD HH:mm:ss'));
						this.display_thanks();
					}
				},

				'on_invalid':function(err) {
					alert('Vyplň.');
				},

				"elements":[
					{
						'element':'container',
						'type':'inputs',
						'elements':[
							{
								'name':'submited',
								'type':'hidden',
								'value':1
							},

							{
								'name':'name_first',
								'type':'text',
								'label':'Jméno',
								'required':true
							},

							{
								'name':'name_last',
								'type':'text',
								'label':'Příjmení',
								'required':true
							},

							{
								'name':'team',
								'type':'text',
								'label':'Tým',
								'required':true
							},

							{
								'name':'email',
								'type':'email',
								'label':'Tvůj e-mail',
								'required':true
							},

							{
								'name':'phone',
								'type':'text',
								'label':'Tvoje telefonní číslo',
								'required':true
							},

							{
								'name':'birthday',
								'type':'text',
								'label':'Datum narození',
								'required':true
							},

							{
								"name":'workshops',
								'label':'Vyber tři workshopy',
								'type':'checkbox',
								'multiple':true,
								'required':true,
								'value':[]
							}
						]
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
				var voted = pwf.storage.get('concept_voted');

				if (voted) {
					p('create_meta');
					this.get_el('form').hide();
					this.display_thanks();
				} else {
					this.load();
				}
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

				var other = pwf.jquery.div('workshop-option');

				other.create_divs(['name', 'desc']);

				other.name.html('Jiný workshop');
				other.desc.html('Napiš nám vlastní představu workshopu.');

				opts.push({'value':666, 'name':other});

				p.storage.opts.elements[0].elements[3].options = opts;

				p('create_meta');
				p('create_form_obj');

				this.get_input('workshops').job('change');
			}
		},


		'public':{
			'display_error':function(err)
			{
				alert('Ajaj. Něco tady nefunguje. Zkus to prosím znovu později.');
				v(err);
			},


			'display_thanks':function(p, next)
			{
				var jobs = [];

				jobs.push(function(next) {
					p.object.get_el('form').stop(true).slideUp(500, next);
				});

				jobs.push(function(next) {
					var el = p.object.get_el();

					el.create_divs(['thanks']);

					el.thanks
						.html('Děkujeme. Sledujte Facebookovou událost kvůli novinkám.')
						.hide()
						.slideDown(500, next);
				});


				pwf.async.series(jobs, next);
			}
		}
	});
})();
