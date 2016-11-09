<?php
	$search_string = '';
	if ( get_search_query() != '' ) {
		$search_string = get_search_query();
	}
?>

<form action="<?php echo esc_url(home_url()); ?>" method="get">
	<span class="sb-icon-search icon-search blue-button"></span>
	<input type="text" name="s" value="<?php echo esc_attr($search_string); ?>" placeholder="<?php _e('Search', 'beryl'); ?>" />
	<input type="submit" name="search" class="btn btn-primary sb-search-submit" value="<?php esc_attr_e('Search', 'beryl'); ?>" />
</form>