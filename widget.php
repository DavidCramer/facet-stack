<?php


class Facet_Stack_Widget extends WP_Widget {

	/**
	 * Create widget
	 *
	 * @since 1.0.0
	 */
	function __construct() {
		// Instantiate the parent object
		parent::__construct( false, __('Facet Stack', 'facet-stack' ), array(
			'description' => __('A stack of facets for FacetWP', 'facet-stack' )
		) );

		/**
		 * Runs after Facet Stack widget is initialized
		 *
		 * @since 1.4.0
		 */
		do_action( 'facet_stack_widget_init' );
		
	}

	/**
	 * Widget output
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {

		if( !empty( $instance['facets'] ) ){

			extract($args, EXTR_SKIP);

			if( isset( $instance['hide_on_pages'] ) ){
				// check loading
				if( false === FWP()->display->load_assets ){
					return;
				}
			}

			if( isset( $instance['load_style'] ) ){
				include_once FACET_STACK_PATH . 'load-style.php';
			}

			$facets = explode( ',', $instance['facets'] );

			echo $before_widget;
			
			foreach( $facets as $facet ){
				$facet = $facets = FWP()->helper->get_facet_by_name( $facet );				
				
				if( isset( $instance['show_titles'] ) ){
					echo $before_title . $facet['label'] . $after_title;
				}
				echo facetwp_display( 'facet', $facet['name'] );

			}
			echo $after_widget;
		}
	}

	/**
	 * Update widget settings
	 *
	 * @since 1.0.0
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {
		// Save widget options
		return $new_instance;
	}

	/**
	 * Widget UI form
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance
	 */
	function form( $instance ) {

		// get settings
		$instance = wp_parse_args( (array) $instance, array( 'facets' => '' ) );
		$selection = explode( ',', strip_tags( $instance['facets'] ) );
		$show_titles = isset( $instance['show_titles'] ) ? 'checked="checked"' : null;
		$load_style = isset( $instance['load_style'] ) ? 'checked="checked"' : null;
		$hide_on_pages = isset( $instance['hide_on_pages'] ) ? 'checked="checked"' : null;

		do_action( 'facet_stack_widget_form_start', $instance );
		
		$facets = FWP()->helper->get_facets();

		// Show Titles
		echo '<p><input type="checkbox" id="' . $this->get_field_id('show_titles') . '" name="' . $this->get_field_name('show_titles') . '" class="checkbox facet-stack-checkbox" ' . $show_titles . '>';
		echo '<label for="' . $this->get_field_id('show_titles') . '">' . esc_html__( 'Show Titles', 'facet-stack' ) . '</label></p>';

		// Alt Loader
		echo '<p><input type="checkbox" id="' . $this->get_field_id('load_style') . '" name="' . $this->get_field_name('load_style') . '" class="checkbox facet-stack-checkbox" ' . $load_style . '>';
		echo '<label for="' . $this->get_field_id('load_style') . '">' . esc_html__( 'Alternate Load Styles', 'facet-stack' ) . '</label></p>';

		// Hide if no facet templates
		echo '<p><input type="checkbox" id="' . $this->get_field_id('hide_on_pages') . '" name="' . $this->get_field_name('hide_on_pages') . '" class="checkbox facet-stack-checkbox" ' . $hide_on_pages . '>';
		echo '<label for="' . $this->get_field_id('hide_on_pages') . '">' . esc_html__( 'Only show on pages with a Template', 'facet-stack' ) . '</label></p>';


		echo '<h4>' . esc_html__( 'Enabled Facets', 'facet-stack' ) . '</h4>';
		echo '<div id="' . $this->get_field_id('facets') . '_list" class="facet-stack-facets facet-stack-enabled-facets facet-stack-tray">';
		echo '<p class="description">' . esc_html__( 'Your Stack is empty, drag a facet from below to enable.', 'facet-stack' ) . '</p>';
		if(!empty($facets)){
			$enabled = array();
			$disabled = array();
			foreach ( $facets as $facet ) {
				
				$facetline = '<p class="facet-stack-facet" data-facet="' . esc_attr( $facet['name'] ) . '"><span class="dashicons dashicons-menu sortable-item"></span>';
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

		echo '<h4>' . esc_html__( 'Disabled Facets', 'facet-stack' ) . '</h4>';
		echo '<div class="facet-stack-facets facet-stack-disabled-facets facet-stack-tray">';
		echo implode( $disabled );
		echo '</div>';

		echo '<input id="' . $this->get_field_id('facets') . '" name="' . $this->get_field_name('facets') . '" type="hidden" value="' . esc_html( implode(',', $selection ) ) . '" />';

		wp_enqueue_style( 'facet-stack-admin', FACET_STACK_URL . 'assets/css/admin.css', array(), FACET_STACK_VER );
		wp_enqueue_script( 'facet-stack-admin', FACET_STACK_URL . 'assets/js/admin.js', array( 'jquery' ), FACET_STACK_VER );

		?>
		<script>
			jQuery( function($){
				var facet_enabled_tray = $('#<?php echo $this->get_field_id('facets'); ?>_list');

				$( ".facet-stack-facets" ).sortable({
					connectWith: ".facet-stack-tray",
					axis: "y",
					handle: ".sortable-item",
					placeholder: "facet-stack-highlight-placeholder",
					forcePlaceholderSize: true,
					helper: "clone",
					start: function(ev, ui){
						console.log( ui );
					},
					update: function(ev, ui){
						//ui.item.find('input').trigger('change');
						var selection = $('#<?php echo $this->get_field_id('facets'); ?>'),
							facets = [];
						facet_enabled_tray.find('.facet-stack-facet').each( function(){
							facets.push( $(this).data('facet') );
						})

						if( facets.length ){
							facet_enabled_tray.find('.description').slideUp(100);
						}else{
							facet_enabled_tray.find('.description').slideDown(100);
						}
						selection.val( facets.join(',') ).trigger('change');

					}
				});

				$('#<?php echo $this->get_field_id('color'); ?>').wpColorPicker();

			})
		</script>
		<?php
		do_action( 'facet_stack_widget_form_end', $instance, $this );
	}
}

function facet_stack_register_widget() {
	if( ! did_action( 'facet_stack_widget_init' ) ){
		register_widget( 'Facet_Stack_Widget' );
	}

}

add_action( 'widgets_init', 'facet_stack_register_widget' );