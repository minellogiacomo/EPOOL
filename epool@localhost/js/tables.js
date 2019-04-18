$(function() {

	function linkClicked(e) {
		var el = $(e.target).closest('.collapsible');

		var state = store.get('tables-visibility', {});
		var key = el.data('key');

		state[key] = state[key] !== undefined ? !state[key] : false;
		store.set('tables-visibility', state);

		toggle(el, 300);
	}

	function toggle(tag, animTime) {
		var el = $(tag).closest('.collapsible');

		el.toggleClass('collapsed');
		el.find('.collapsible-link')
		  .next('.collapsible-area')
		  .slideToggle(animTime);
	}

	function contentReloaded() {
		// Bind elements actions
		$('#right .collapsible-link').click(linkClicked);

		// Restore last used state
		var state = store.get('tables-visibility', {});
		for(key in state) {
			var val = state[key];

			// By default all sections are visible,
			// toggle only if it was hidden before.
			if(val === false) {
				toggle('#right .collapsible[data-key="'+ key +'"]', 0);
			}
		}
	}

    $(window).on('content-reloaded', contentReloaded);
    contentReloaded();

});