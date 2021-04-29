<?php
/**
 *
 * Search form.
 * @since 1.0.0
 * @version 1.0.0
 *
 */
?>
<div class="search-form">
	<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
		<input type="text" placeholder="<?php esc_attr_e( 'Search', 'cityo' ); ?>" name="s" class="form-control"/>
		<button type="submit" class="btn btn-theme"><i class="ti-search"></i></button>
	</form>
</div>