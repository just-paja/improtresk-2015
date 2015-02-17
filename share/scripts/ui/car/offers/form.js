(function()
{
	"use strict";

	pwf.reg_class('ui.car.offers.form', {
		"parents":['form'],
		'requires':['input.select', 'input.datetime'],

		'storage':{
			'opts':{
				'elements':[
					{
						'name':'driver',
						'label':'Tvoje jméno',
						'type':'text',
						'required':true
					},

					{
						'name':'from',
						'label':'Město',
						'type':'text',
						'required':true
					},

					{
						'name':'seats',
						'label':'Počet míst',
						'type':'number',
						'min':1,
						'step':1,
						'required':true
					},

					{
						'name':'departure',
						'label':'Plánovaný odjezd',
						'type':'datetime',
						'required':true
					},

					{
						'name':'name',
						'label':'Tvůj e-mail',
						'type':'text',
						'required':true
					},

					{
						'name':'icon',
						'type':'select',
						'label':'Ikona',
						'options':[
							{"name":"sedan","value":"sedan"},
							{"name":"combi","value":"combi"},
							{"name":"hatchback","value":"hatchback"},
							{"name":"hatchback-3d","value":"hatchback-3d"},
							{"name":"coupe","value":"coupe"},
							{"name":"van","value":"van"},
							{"name":"microbus","value":"microbus"},
							{"name":"cabriolet","value":"cabriolet"},
							{"name":"mpv","value":"mpv"},
							{"name":"suv","value":"suv"},
							{"name":"pickup","value":"pickup"},
							{"name":"limousine","value":"limousine"},
							{"name":"tank","value":"tank"}
						],
						'required':true
					},

					{
						'name':'desc',
						'label':'Zpráva pro zájemce',
						'type':'textarea'
					},

					{
						'element':'button',
						'type':'submit',
						'label':'Vložit'
					}
				]
			}
		},

		'proto':{
			'els':[
				'heading',
				'desc',

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
				},

				{
					'name':'open',
					'cname':['button'],
					'html':'Nabídnout místo v autě'
				},

				'errors'
			],


			'create_struct':function(p)
			{
				p('create_meta');
				p('create_form_obj');

				this.get_el('open').bind('click touchend', p, p.get('callbacks.open'));
			},


			'callbacks':
			{
				'open':function(e)
				{
					e.preventDefault();
					e.data.object.open();
				}
			}
		},


		'public':{
			'open':function()
			{
				this.get_el('form').slideDown(250);
				this.get_el('open').slideUp(250);
			}
		}
	});
})();
