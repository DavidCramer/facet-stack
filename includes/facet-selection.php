<?php
/**
 * Facet Selection Panel template
 *
 * @package   facet_stack/widget_panels
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 */


	$selection = explode( ',', strip_tags( $instance['facets'] ) );

	echo '<div class="facet-stack-section-wrapper">';

		echo '<h4>' . esc_html__( 'Facet Selection', 'facet-stack' ) . ' <span class="facet-stack-section-toggle dashicons dashicons-arrow-down"></span></h4>';
		
		echo '<div class="facet-stack-section">';

			echo '<h3>' . esc_html__( 'Enabled Facets', 'facet-stack' ) . '</h3>';
			echo '<div id="' . $this->get_field_id('facets') . '_list" class="facet-stack-facets facet-stack-enabled-facets facet-stack-tray">';
				echo '<p class="description">' . esc_html__( 'Your Stack is empty, drag a facet from below to enable.', 'facet-stack' ) . '</p>';
				if(!empty($facets)){
					$enabled = array();
					$disabled = array();
					foreach ( $facets as $facet ) {
						
						$facetline = '<p class="facet-stack-facet" data-for="' . $this->get_field_id('facets') . '" data-facet="' . esc_attr( $facet['name'] ) . '"><span class="dashicons dashicons-menu sortable-item"></span>';
							$facetline .= '<span class="facet-stack-label">' . esc_html( $facet['label'] ) . '</span>';
						$facetline .= '</p>';

						if( in_array( $facet['name'], $selection ) ){
							$enabled[] = $facetline;
						}else{
							$disabled[] = $facetline;
						}
					}
				}
				echo implode( $enabled );
			echo '</div>';

			echo '<h3>' . esc_html__( 'Disabled Facets', 'facet-stack' ) . '</h3>';
			
			echo '<div class="facet-stack-facets facet-stack-disabled-facets facet-stack-tray">';
				echo implode( $disabled );
			echo '</div>';

		echo '</div>';

	echo '</div>';


	echo '<input id="' . $this->get_field_id('facets') . '" name="' . $this->get_field_name('facets') . '" type="hidden" value="' . esc_html( implode(',', $selection ) ) . '" />';

