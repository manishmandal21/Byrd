<?php
	wp_enqueue_style( 'datetimepicker', get_template_directory_uri() . '/css/jquery.datetimepicker.min.css' );
	wp_enqueue_script( 'datetimepicker', get_template_directory_uri() . '/js/jquery.datetimepicker.full.min.js' );
	$date_from = ! empty( $_REQUEST['filter_event_date_from'] ) ? esc_attr( $_REQUEST['filter_event_date_from'] ) : '';
	$date_to = ! empty( $_REQUEST['filter_event_date_to'] ) ? esc_attr( $_REQUEST['filter_event_date_to'] ) : '';
?>
<div class="filter_event_date">
	<div class="row">
		<div class="col-xs-6">
			<input type="text" class="form-control style2" name="filter_event_date_from" placeholder="<?php esc_attr_e( 'Start Date...', 'cityo' ); ?>" value="<?php echo esc_attr( $date_from ); ?>" />
		</div>
		<div class="col-xs-6">
			<input type="text" class="form-control style2" name="filter_event_date_to" placeholder="<?php esc_attr_e( 'Finish Date...', 'cityo' ); ?>" value="<?php echo esc_attr( $date_to ); ?>" />
		</div>
	</div>
</div>