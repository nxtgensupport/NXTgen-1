<?php

if( !function_exists( 'exponent_modules_wcf7_presets' ) ) {
  function exponent_modules_wcf7_presets($args){
    ?>	
      <style>.metabox-holder .dev-cta{display:none!important;}</style>
      <div class="metabox-holder">
      <p style="font-size: 1.5em; background-color: rgba(0, 130, 0, 0.09); padding:15px;">
        Copy and paste a form preset into the 'Form' tab.
        <a href="#">Learn more here..</a>
      </p>

      <!-- Contact form -->
      <h3>Simple 2 column contact form</h3>
      <textarea style = "width : 100%; min-height : 400px;">
          [be_form_row]
            [be_form_col layout = "one-half"]
                [text* your-name placeholder "Name"]
            [/be_form_col]
            [be_form_col layout = "one-half"]
                [email* your-email placeholder "Email"]
            [/be_form_col]
          [/be_form_row]
          [text your-subject placeholder "Subject"] 
          [textarea your-message placeholder "Message"]
          [submit "Submit"]
      </textarea>

      <!-- Contact form -->
      <h3>Simple 3 column contact form</h3>
      <textarea style = "width : 100%; min-height : 400px;">
          [be_form_row]
            [be_form_col layout = "one-third"]
              [text* your-name placeholder "Name"]
            [/be_form_col]
            [be_form_col layout = "one-third"]
              [email* your-email placeholder "Email"]
            [/be_form_col]
            [be_form_col layout = "one-third"]
              [text your-subject placeholder "Subject"]
            [/be_form_col]
          [/be_form_row]
          [textarea your-message placeholder "Message"]
          [submit "Submit"]
      </textarea>

      </div><!-- .metabox-holder -->
    <?php
  }
}

if( !function_exists( 'exponent_modules_wcf7_presets_tab' ) ) {
  function exponent_modules_wcf7_presets_tab( $panels ) {
    $new_page = array(
      'exponent-presets' => array(
        'title' => __( 'Be Presets', 'exponent' ),
        'callback' => 'exponent_modules_wcf7_presets'
      )
    );
    $panels = array_merge( $panels, $new_page );
    return $panels;
  }
  add_filter( 'wpcf7_editor_panels', 'exponent_modules_wcf7_presets_tab' );
}


if( !function_exists( 'exponent_modules_wcf7_modify_default_form_template' ) ) {
  function exponent_modules_wcf7_modify_default_form_template( $default_template, $prop ) {
      if( 'form' === $prop ) {
        $template = sprintf('
          [text* your-name placeholder "%s"]
          [email* your-email placeholder "%s"]
          [text your-subject placeholder "%s"] 
          [textarea your-message placeholder "%s"]
          [submit "%s"]
          ',
          __( 'Name', 'contact-form-7' ),
          __( 'Email', 'contact-form-7' ),
          __( 'Subject', 'contact-form-7' ),
          __( 'Message', 'contact-form-7' ),
          __( 'Send', 'contact-form-7' ) );

          return $template;
      }
      return $default_template;
  }
  add_filter( 'wpcf7_default_template', 'exponent_modules_wcf7_modify_default_form_template', 10, 2 );
}

if( !function_exists( 'exponent_modules_wcf7_prevent_autop' ) ) {
    function exponent_modules_wcf7_prevent_autop() {
      return false;
    }
    add_filter( 'wpcf7_autop_or_not', 'exponent_modules_wcf7_prevent_autop' );
}

if( !function_exists( 'exponent_modules_wcf7_class' ) ) {
  function exponent_modules_wcf7_class( $class ) {
      $form_classes = 'exp-form-';
      $button_class = 'exp-button-';
      if( false === strpos( $class, $form_classes ) ) {
        $form_style = function_exists( 'be_themes_get_option' ) ? be_themes_get_option( 'form_style' ) : false;
        if( !empty( $form_style ) ) {
          $class .= ' ' . 'exp-form-' . $form_style;
        }
      }
      if( false === strpos( $class, $button_class ) ) {
        $button_style = function_exists( 'be_themes_get_option' ) ? be_themes_get_option( 'button_style' ) : false;
        if( !empty( $button_style ) ) {
          $class .= ' ' . 'exp-button-' . $button_style; 
        }
      }
      $class .=  ' ' . 'exp-form';
      return $class;
  }
  add_filter( 'wpcf7_form_class_attr', 'exponent_modules_wcf7_class' );
}

if( !function_exists( 'exponent_modules_wcf7_enable_shortcode' ) ) {
  add_filter( 'wpcf7_form_elements', 'exponent_modules_wcf7_enable_shortcode' );
  function exponent_modules_wcf7_enable_shortcode( $form_content ) {
      return do_shortcode( $form_content );
  }
}

if( !function_exists( 'exponent_modules_wcf7_form_row_cb' ) ) {
  function exponent_modules_wcf7_form_row_cb( $atts, $content ) {
    ob_start();
    ?>
      <div class = "be-form-field-row-wrap">
        <div class = "be-form-field-row">
          <?php echo do_shortcode( $content ); ?>
        </div>
      </div>
    <?php
    return ob_get_clean();
  }
  add_shortcode( 'be_form_row', 'exponent_modules_wcf7_form_row_cb' );
}

if( !function_exists( 'exponent_modules_wcf7_form_col_cb' ) ) {
  function exponent_modules_wcf7_form_col_cb( $atts, $content ) {
      $atts = shortcode_atts( array (
          'layout'  => ''
      ), $atts );
      extract( $atts );
      $layout_class = "";
      if( !empty( $layout ) ) {
          $layout_class = "be-col-" . $layout;
      }
      ob_start();
      ?>
          <div class = "be-form-field-col <?php echo $layout_class;  ?>">
              <?php echo do_shortcode( $content ); ?>
          </div>
      <?php
      return ob_get_clean();
  }
  add_shortcode( 'be_form_col', 'exponent_modules_wcf7_form_col_cb' );
}