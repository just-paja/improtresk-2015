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
				'desc':'Letošní Improtřesk bude 7. - 10. května v Milevsku a ty máš možnost ovlivnit, jaké workshopy nabídne. Hlasuj až pro tři workshopy. Workshopy s největším počtem hlasů se pokusíme uskutečnit. Hlasování končí v <span style="text-decoration:underline">pátek 13. února v 20:00</span>. Toto není přihláška na Improtřesk 2015.',
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
						this.display_thanks();
					}
				},


				'on_invalid':function(err) {
					alert('Vyplň prosím svoje jméno, e-mail a vyber přesně tři workshopy.');
				},

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
							return this.val().length == 3;
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
