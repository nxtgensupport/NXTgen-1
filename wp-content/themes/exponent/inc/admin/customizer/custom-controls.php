<?php    
if(class_exists('Kirki_Control_Base')){
//Backward compatibility: Kirki Customizer Framework Version 3.1.9 or lower
/**
 * be_responsive_number type definition
 */
class Be_Responsive_Number extends Kirki_Control_Base {
    public $type = 'be_responsive_number';
    /*
    *  Content for this custom control
    */ 
    public function render_content() {
        $label = $this->label;
        $input_id = '_customize-input-' . $this->id;
        $name = $this->id;
        $description = $this->description;
        ?>
            <div class="be-custom-control-wrap">
                <?php
                    if( !empty( $label ) ) :
                ?>
                        <span class="be-custom-control-title"> <?php echo esc_html( $label ); ?> </span>
                <?php 
                    endif; 
                    if( !empty( $description ) ) : 
                ?>
                        <span class="be-custom-control-description"><?php echo esc_html( $description ); ?></span>
                <?php 
                    endif;    
                ?>
                <input 
                    type = "hidden"
                    id="<?php echo esc_attr( $input_id ); ?>"
                    name = "<?php echo esc_attr( $name ); ?>"
                    <?php $this->link(); ?>
                    value="<?php echo esc_attr( $this->value() ); ?>"
                />
                <div class="be-control-docker">
                </div>
            </div>
        <?php
    }
}

    /**
     * be_text type definition
     */
    class Be_Color_Picker extends Kirki_Control_Base {
        public $type = 'be_color';
        public $enable_gradient = true;

        /*
        *  Extra data to js api
        */
        public function json() {
            $this->to_json();
            $this->json[ 'enableGradient' ] = $this->enable_gradient;
            return $this->json;
        }

        /*
        *  Content for this custom control
        */ 
        public function render_content() {
            $label = $this->label;
            $input_id = '_customize-input-' . $this->id;
            $name = $this->id;
            $description = $this->description;
            ?>
                <div class="madras-custom-control-wrap">
                    <?php
                        if( !empty( $label ) ) :
                    ?>
                            <span class="madras-custom-control-title"> <?php echo esc_html( $label ); ?> </span>
                    <?php 
                        endif; 
                        if( !empty( $description ) ) : 
                    ?>
                            <span class="madras-custom-control-description"><?php echo esc_html( $description ); ?></span>
                    <?php 
                        endif;    
                    ?>
                    <input 
                            type = "hidden"
                            id="<?php echo esc_attr( $input_id ); ?>"
                            name = "<?php echo esc_attr( $name ); ?>"
                            value="<?php echo esc_attr( $this->value() ); ?>"
                            <?php $this->link(); ?>
                    />
                    <div class="madras-colorpicker-docker">
                    </div>
                </div>
            <?php
        }
    }


    /**
     * be_title type definition
     */
    class Be_Title extends Kirki_Control_Base {
        public $type = "be_title";
        public function render_content() {
            $label = $this->label;
            ?>
                <div class="be-customizer-title-wrap">
                    <span class="be-customizer-title">
                        <?php echo esc_html( $label ); ?>
                    </span>
                </div>
            <?php
        }
    }

    /** 
     *  be_sub_title type definition
     */
    class Be_Sub_Title extends Kirki_Control_Base {
        public $type = "be_sub_title";
        public function render_content() {
            $label = $this->label;
            ?>
                <div class="be-customizer-sub-title-wrap">
                    <?php echo esc_html( $label ); ?>
                </div>
            <?php
        }
    }

    /**
     *  be_separator
     */
    class Be_Separator extends Kirki_Control_Base {
        public $type = "be_separator";
        public function render_content() {
            ?>
                <hr class="be-customizer-separator"/>
            <?php 
        }
    }    
}else if(class_exists('Kirki\Control\Base')){
    //Compatibility: Kirki Customizer Framework Version 4.0.20 or higher
	/**
     * be_responsive_number type definition
     */
    class Be_Responsive_Number extends Kirki\Control\Base {
        public $type = 'be_responsive_number';
        /*
        *  Content for this custom control
        */ 
        public function render_content() {
            $label = $this->label;
            $input_id = '_customize-input-' . $this->id;
            $name = $this->id;
            $description = $this->description;
            ?>
                <div class="be-custom-control-wrap">
                    <?php
                        if( !empty( $label ) ) :
                    ?>
                            <span class="be-custom-control-title"> <?php echo esc_html( $label ); ?> </span>
                    <?php 
                        endif; 
                        if( !empty( $description ) ) : 
                    ?>
                            <span class="be-custom-control-description"><?php echo esc_html( $description ); ?></span>
                    <?php 
                        endif;    
                    ?>
                    <input 
                        type = "hidden"
                        id="<?php echo esc_attr( $input_id ); ?>"
                        name = "<?php echo esc_attr( $name ); ?>"
                        <?php $this->link(); ?>
                        value="<?php echo esc_attr( $this->value() ); ?>"
                    />
                    <div class="be-control-docker">
                    </div>
                </div>
            <?php
        }
    }

    /**
     * be_text type definition
     */
    class Be_Color_Picker extends Kirki\Control\Base {
        public $type = 'be_color';
        public $enable_gradient = true;

        /*
        *  Extra data to js api
        */
        public function json() {
            $this->to_json();
            $this->json[ 'enableGradient' ] = $this->enable_gradient;
            return $this->json;
        }

        /*
        *  Content for this custom control
        */ 
        public function render_content() {
            $label = $this->label;
            $input_id = '_customize-input-' . $this->id;
            $name = $this->id;
            $description = $this->description;
            ?>
                <div class="madras-custom-control-wrap">
                    <?php
                        if( !empty( $label ) ) :
                    ?>
                            <span class="madras-custom-control-title"> <?php echo esc_html( $label ); ?> </span>
                    <?php 
                        endif; 
                        if( !empty( $description ) ) : 
                    ?>
                            <span class="madras-custom-control-description"><?php echo esc_html( $description ); ?></span>
                    <?php 
                        endif;    
                    ?>
                    <input 
                            type = "hidden"
                            id="<?php echo esc_attr( $input_id ); ?>"
                            name = "<?php echo esc_attr( $name ); ?>"
                            value="<?php echo esc_attr( $this->value() ); ?>"
                            <?php $this->link(); ?>
                    />
                    <div class="madras-colorpicker-docker">
                    </div>
                </div>
            <?php
        }
    }


    /**
     * be_title type definition
     */
    class Be_Title extends Kirki\Control\Base {
        public $type = "be_title";
        public function render_content() {
            $label = $this->label;
            ?>
                <div class="be-customizer-title-wrap">
                    <span class="be-customizer-title">
                        <?php echo esc_html( $label ); ?>
                    </span>
                </div>
            <?php
        }
    }

    /** 
     *  be_sub_title type definition
     */
    class Be_Sub_Title extends Kirki\Control\Base {
        public $type = "be_sub_title";
        public function render_content() {
            $label = $this->label;
            ?>
                <div class="be-customizer-sub-title-wrap">
                    <?php echo esc_html( $label ); ?>
                </div>
            <?php
        }
    }

    /**
     *  be_separator
     */
    class Be_Separator extends Kirki\Control\Base {
        public $type = "be_separator";
        public function render_content() {
            ?>
                <hr class="be-customizer-separator"/>
            <?php 
        }
    }    
}
?>