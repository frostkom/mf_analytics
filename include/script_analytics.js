jQuery(function($)
{
	var dom_href = '';

	function use_link()
	{
		if(dom_href != '')
		{
			location.href = dom_href;

			dom_href = '';
		}
	}

	$.each(script_analytics.events, function(index, value)
	{
		$(document).on('click', value.selector, function(e)
		{
			e.preventDefault();

			dom_href = e.target.href;

			setTimeout(use_link, 1000);

			ga('send', 'event',
			{
				eventCategory: value.title,
				eventAction: 'click',
				eventLabel: e.target.href,
				hitCallback: use_link
			});
		});
	});
});