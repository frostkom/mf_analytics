jQuery(function($)
{
	var dom_href = '',
		dom_obj;

	function use_link()
	{
		if(dom_href != '')
		{
			if(dom_obj.attr('rel') == 'external' && script_analytics_events.external_links == 'yes'){}

			else
			{
				if(typeof process_url == 'function')
				{
					process_url(dom_href);
				}

				else
				{
					location.href = dom_href;
				}
			}

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

			if($(this).is('a'))
			{
				dom_label = e.target.href;
				dom_href = e.target.href;

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

			else if($(this).is('button'))
			{
				dom_label = $(this).attr('rel');
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