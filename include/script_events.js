jQuery(function($)
{
	var dom_href = '',
		dom_obj;

	function use_link()
	{
		if(dom_href != '')
		{
			location.href = dom_href;

			dom_href = '';
		}
	}

	function submit_form()
	{
		dom_obj.parents('form').submit();
	}

	$.each(script_analytics_events.events, function(index, value)
	{
		$(document).on('click', value.selector, function(e)
		{
			dom_obj = $(this);

			if(dom_obj.is('a'))
			{
				dom_label = dom_obj.attr('href');
				dom_href = dom_obj.attr('href');

				if(typeof dom_href != 'undefined')
				{
					setTimeout(use_link, 1000);

					ga('send', 'event',
					{
						eventCategory: value.title,
						eventAction: 'click',
						eventLabel: dom_label,
						hitCallback: use_link
					});

					return false;
				}
			}

			else if(dom_obj.is('button'))
			{
				dom_label = dom_obj.attr('rel');
				dom_href = '';

				setTimeout(submit_form, 1000);

				ga('send', 'event',
				{
					eventCategory: value.title,
					eventAction: 'click',
					eventLabel: dom_label,
					hitCallback: submit_form
				});

				return false;
			}
		});
	});
});