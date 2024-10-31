<?php

class NSU_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname' => 'nsu_widget',
			'description' => __( 'Displays a newsletter sign-up form.', 'newsletter-sign-up' ),
		);
		$control_ops = array(
			'width' => 400,
			'height' => 350,
		);
		parent::__construct( 'newslettersignupwidget', 'Newsletter Sign-Up', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		/* Provide some defaults */
		$defaults = array(
			'title' => 'Sign up for our newsletter!',
			'text_before_form' => '',
			'text_after_form' => '',
		);
		$instance = array_merge( $defaults, (array) $instance );

		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget'];
		echo $args['before_title'] . esc_html( $title ) . $args['after_title'];

		if ( ! empty( $instance['text_before_form'] ) ) {
			echo '<div class="nsu-text-before-form">';
			echo $instance['filter'] ? wpautop( $instance['text_before_form'] ) : $instance['text_before_form'];
			echo '</div>';
		}

		NSU::form()->output_form( true );

		if ( ! empty( $instance['text_after_form'] ) ) {
			echo '<div class="nsu-text-after-form">';
			echo $instance['filter'] ? wpautop( $instance['text_after_form'] ) : $instance['text_after_form'];
			echo '</div>';
		}

		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );

		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text_before_form'] = $new_instance['text_before_form'];
			$instance['text_after_form'] = $new_instance['text_after_form'];
		} else {
			$instance['text_before_form'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text_before_form'] ) ) );
			$instance['text_after_form'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text_after_form'] ) ) );
		}
		$instance['filter'] = isset( $new_instance['filter'] );

		return $instance;
	}

	function form( $instance = array() ) {
		$defaults = array(
			'title' => 'Sign up for our newsletter!',
			'text_before_form' => '',
			'text_after_form' => '',
		);
		$instance = array_merge( $defaults, (array) $instance );
		?>
		 <p>
		  <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'newsletter-sign-up' ); ?></label>
		  <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<label title="You can use the following HTML-codes:  &lt;a&gt;, &lt;strong&gt;, &lt;br /&gt;,&lt;em&gt; &lt;img ..&gt;" for="<?php echo $this->get_field_id( 'text_before_form' ); ?>"><?php _e( 'Text to show before the form', 'newsletter-sign-up' ); ?></label>
		<textarea rows="8" cols="10" class="widefat wysiwyg-overlay-toggle" id="<?php echo $this->get_field_id( 'text_before_form' ); ?>" name="<?php echo $this->get_field_name( 'text_before_form' ); ?>"><?php echo esc_attr( $instance['text_before_form'] ); ?></textarea>
		<br />
		<label for="<?php echo $this->get_field_id( 'text_after_form' ); ?>"><?php _e( 'Text to show after the form', 'newsletter-sign-up' ); ?></label>
		<textarea rows="8" cols="10" class="widefat wysiwyg-overlay-toggle" id="<?php echo $this->get_field_id( 'text_after_form' ); ?>" name="<?php echo $this->get_field_name( 'text_after_form' ); ?>"><?php echo esc_attr( $instance['text_after_form'] ); ?></textarea>

		<p><input id="<?php echo $this->get_field_id( 'filter' ); ?>" name="<?php echo $this->get_field_name( 'filter' ); ?>" type="checkbox" <?php checked( isset( $instance['filter'] ) ? $instance['filter'] : 0 ); ?> />&nbsp;<label for="<?php echo $this->get_field_id( 'filter' ); ?>"><?php _e( 'Automatically add paragraphs', 'newsletter-sign-up' ); ?></label></p>

		<p>
			Configure the sign-up form at the <a href="<?php echo admin_url( 'admin.php?page=newsletter-sign-up-form-settings' ); ?>">Newsletter Sign-Up configuration page</a>.
		</p>
		<?php
	}

}

