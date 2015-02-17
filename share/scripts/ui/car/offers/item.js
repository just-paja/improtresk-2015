(function()
{
	"use strict";

	pwf.reg_class('ui.car.offers.item', {
		'parents':['jq.struct'],


		'proto':{
			'els':[
				{
					'name':'vehicle',
					'els':['icon', 'seats']
				},

				{
					'name':'info',
					'els':['from', 'departure', 'driver', 'c2a']
				}
			],

			'create_struct':function(p)
			{
				this.get_el().addClass(this.get('icon'));
				this.get_el('vehicle').addClass(this.get('icon'));
				this.get_el('vehicle.icon').addClass(this.get('icon'));
				this.get_el('vehicle.seats')
					.html(this.get('seats'))
					.attr('title', 'Počet míst')
					.addClass('free');

				this.get_el('info.from').html(this.get('from'));
				this.get_el('info.departure').html('Odjezd: ' + this.get('departure').format('D.M H:m'));
				this.get_el('info.driver').html('Řidič: ' + this.get('driver'));
			}
		}
	});

})();
