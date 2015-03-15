(function()
{
	"use strict";

	pwf.reg_class('ui.form.signup', {
		"parents":['model.list', 'form'],
		'requires':['Workshop'],

		"storage":{
			"opts":{
				'action':'/formulare/signup',
				'model':'Workshop',
				'heading':'Přihláška',
				'sort':[
					{
						'attr':'name',
					}
				],

				'on_invalid':function(err) {
					alert('Vyplň prosím všechna pole.');
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
								'element':'container',
								'type':'name',
								'elements':[
									{
										'name':'name_first',
										'type':'text',
										'label':'Jméno',
										'placeholder':'Křestní',
										'required':true
									},

									{
										'name':'name_last',
										'type':'text',
										'placeholder':'Příjmení',
										'required':true
									}
								]
							},

							{
								'name':'team',
								'type':'text',
								'label':'Tým'
							},

							{
								'name':'email',
								'type':'email',
								'label':'Tvůj e-mail',
								'required':true,
								'desc':'Na e-mail ti pošleme potvrzení přihlášky a detaily platby.'
							},

							{
								'name':'phone',
								'type':'text',
								'label':'Tvoje telefonní číslo',
								'required':true,
								'desc':'Pokud se vyskytne nějaký problém, budeme ti volat.'
							},

							{
								'name':'birthday',
								'type':'text',
								'label':'Datum narození',
								'required':true
							},

							{
								'name':'lunch',
								'type':'checkbox',
								'label':'Chci obědy (Více o obědech se dočtete v <a href="/jidlo">sekci pro účastníky</a>)'
							}
						]
					},

					{
						'element':'container',
						'type':'workshops',
						'heading':'Workshopy',
						'desc':'Vyber si tři workshopy v pořadí podle preferencí. Pokud se naplní první než nám přijde tvoje platba, dáme tě do druhého. Pokud se naplní druhý, dáme tě do třetího.',
						'elements':[
							{
								"name":'workshop_0',
								'label':'Primární workshop',
								'type':'select',
								'required':true,
								'model':'Workshop',
								'on_change':function() {
									var
										val = this.val(),
										sel = this.get('form').get_input('workshop_1'),
										ex  = pwf.get_class('Workshop').get_all_existing(),
										op  = [];

									for (var i = 0; i < ex.length; i++) {
										if (ex[i].get('id') != val) {
											op.push({
												'name':ex[i].get('name') + ' (' + ex[i].get('lector') + ')',
												'value':ex[i].get('id')
											});
										}
									}

									sel.set('options', op);
									sel.get_el('input').html('');
									sel.job('create_options');
								}
							},

							{
								"name":'workshop_1',
								'label':'Sekundární workshop',
								'type':'select',
								'required':true,
								'on_change':function() {
									var
										val = this.val(),
										pri = this.get('form').get_input('workshop_0').val(),
										sel = this.get('form').get_input('workshop_2'),
										ex  = pwf.get_class('Workshop').get_all_existing(),
										op  = [];

									for (var i = 0; i < ex.length; i++) {
										var id = ex[i].get('id');

										if (id != val && id != pri) {
											op.push({
												'name':ex[i].get('name') + ' (' + ex[i].get('lector') + ')',
												'value':ex[i].get('id')
											});
										}
									}

									sel.set('options', op);
									sel.get_el('input').html('');
									sel.job('create_options');
								}
							},

							{
								"name":'workshop_2',
								'label':'Terciální workshop',
								'type':'select',
								'required':true
							}
						]
					},

					{
						'element':'container',
						'heading':'Odeslání',
						'desc':'Po úspěšném odeslání ti pošleme potvrzení přihlášky a detaily platby. Tato přihláška je závazná.',
						'elements':[
							{
								'type':'checkbox',
								'label':'Souhlasím s <a href="/pro-ucastniky">podmínkami pro účastníky</a>',
								'required':true
							},

							{
								'label':'Odeslat',
								'element':'button',
								'type':'submit'
							}
						]
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
					opts.push({
						'name':items[i].get('name') + ' (' + items[i].get('lector') + ')',
						'value':items[i].get('id')
					});
				}

				var use = p.storage.opts.elements[1].elements;

				for (var i = 0 ; i < use.length; i++) {
					if (typeof use[i].model != 'undefined' && use[i].model == 'Workshop') {
						use[i].options = opts;
					}
				}

				p('create_meta');
				p('create_form_obj');

				this.get_input('workshop_0').job('change');
				this.get_input('workshop_1').job('change');
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
