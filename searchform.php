<?php
/**
 * The template for displaying search forms in Blunderbus
 *
 * @package Blunderbus
 */
?>
<form role="search" method="get" class="form-inline search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="input-group">
            <input type="text" class="search-field form-control" placeholder="<?php echo esc_attr_x( 'Keyword search &hellip;', 'placeholder', 'blunderbus' ); ?>" name="srch-term" id="srch-term">
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
            </div>
        </div>
	<label>
</form>
