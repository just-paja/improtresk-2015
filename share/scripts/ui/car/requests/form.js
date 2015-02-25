(function()
{
	"use strict";

	pwf.reg_class('ui.car.requests.form', {
		"parents":['form'],
		'requires':['input.select', 'input.datetime'],

		'storage':{
			'opts':{
				'action':'/autem/poptavka',

				'before_send':function()
				{
					var el = this.get_el().trigger('loading', this);
					el.find('.form-group-typed-buttons').stop(true).slideUp();

					this.get_el('errors').hide();
					return true;
				},

				'on_ready':function(err, res)
				{
					var el = this.get_el().trigger('loaded', this);

					if (err) {
						el.find('.form-group-typed-buttons').stop(true).slideDown();
						this.get_el('errors')
							.html('Nepovedlo se odeslat poptávku. Zkuste to prosím později.')
							.append(err)
							.stop(true)
							.slideDown();
					} else {
						this.get_el('form').slideUp(250);
						this.get_el('result').html('<p class="success">Tvoje popt8vka byla uložena a byla přeposlána řidiči. Je už na něm, kdy tě bude kontaktovat.</p>');

						pwf.create('ui.car.offers.item', pwf.merge(this.get_data(), {
							'ident':res.data.ident,
							'parent':this.get_el('result')
						}));

						this.get_el('result')
							.stop(true)
							.slideDown();
					}
				},

				'elements':[
					{
						'element':'container',
						'type':'inputs',
						'elements':[
							{
								'name':'submited',
								'type':'hidden',
								'value':true
							},
							{
								'name':'car',
								'type':'hidden'
							},

							{
								'name':'name',
								'label':'Tvoje jméno',
								'type':'text',
								'required':true,
								'desc':'Stačí přezdívka, která bude použita jako podpis.'
							},

							{
								'name':'phone',
								'label':'Telefon',
								'type':'text',
								'required':true,
								'desc':'Telefon, na kterém tě bude řidič kontaktovat. Nebude zveřejněn.'
							},

							{
								'name':'email',
								'label':'E-mail',
								'type':'email',
								'required':true,
								'desc':'E-mail, kterým ti pošleme potvrzení. Nebude zveřejněn.'
							},

							{
								'name':'desc',
								'label':'Zpráva pro řidiče',
								'type':'textarea',
								'desc':'Pokud chceš připojit nějaký vzkaz, tady je k tomu prostor.'
							}
						]
					},

					{
						'element':'container',
						'type':'buttons',
						'elements':[
							{
								'element':'button',
								'type':'submit',
								'label':'Vložit'
							}
						]
					}
				]
			}
		},

		'proto':{
			'els':[
				'heading',
				'desc',
				'result',
				'errors',

				{
					'name':'form',
					'prefix':'the',
					'tag':'form',
					'attrs':{
						'novalidate':'true',
						'enctype':'multipart/form-data'
					},

					'els':[
						{
							'name':'inner',
							'prefix':'form'
						}
					]
				}
			],
		}
	});
})();
