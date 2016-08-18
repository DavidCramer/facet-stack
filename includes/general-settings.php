<?php
	$show_titles = isset( $instance['show_titles'] ) ? 'checked="checked"' : null;
	$load_style = isset( $instance['load_style'] ) ? 'checked="checked"' : null;

	echo '<div class="facet-stack-section-wrapper">';
		
		echo '<h4>' . esc_html__( 'Display Settings', 'facet-stack' ) . ' <span class="facet-stack-section-toggle dashicons dashicons-arrow-down"></span></h4>';			
		
		echo '<div class="facet-stack-section">';

			// Show Titles
			echo '<p><input type="checkbox" id="' . $this->get_field_id('show_titles') . '" name="' . $this->get_field_name('show_titles') . '" class="checkbox facet-stack-checkbox" ' . $show_titles . '>';
			echo '<label for="' . $this->get_field_id('show_titles') . '">' . esc_html__( 'Show Titles', 'facet-stack' ) . '</label></p>';

			// Alt Loader
			echo '<p><input type="checkbox" id="' . $this->get_field_id('load_style') . '" name="' . $this->get_field_name('load_style') . '" class="checkbox facet-stack-checkbox" ' . $load_style . '>';
			echo '<label for="' . $this->get_field_id('load_style') . '">' . esc_html__( 'Alternate Load Styles', 'facet-stack' ) . '</label></p>';


		echo '</div>';

	echo '</div>';
