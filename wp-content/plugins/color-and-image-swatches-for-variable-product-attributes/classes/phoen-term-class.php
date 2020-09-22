<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PHOEN_ADD_TERM_ {

    public $attribute_meta_key;
    
	public $term_id;
    
	public $term;
    
	public $term_label;
    
	public $term_slug;
    
	public $taxonomy_slug;
    
	public $selected;
    
	public $type;
    
	public $thumbnail_src;
    
	public $thumbnail_id;
    
	public $size;
	
	public $phoen_color;
	
	public $phoen_image;
	
	public $phoen_icon;
    
	public $width = 32;
    
	public $height = 32;

    public function __construct($attribute_data_key, $term_id, $taxonomy, $selected = false, $size = 'swatches_image_size') {

        $this->attribute_meta_key = $attribute_data_key;
        $this->term_id = $term_id;
        $this->term = get_term($term_id, $taxonomy);
        $this->term_label = $this->term->name;
        $this->term_slug = $this->term->slug;
	
        $this->taxonomy_slug = $taxonomy;
        $this->selected = $selected;
        $this->size = $size;

        $this->on_init();
    }

    public function on_init() {

       
		global $woocommerce, $_wp_additional_image_sizes;

        $this->init_size($this->size);

        $type = get_woocommerce_term_meta($this->term_id, $this->meta_key() . '_type', true);
		
		if($type == 'phoen_color'){
			  $this->phoen_color = get_woocommerce_term_meta($this->term_id, $this->meta_key() . '_phoen_color', true);
			  $this->phoen_bicolor = get_woocommerce_term_meta($this->term_id, $this->meta_key() . '_phoen_bicolor', true);
			  $this->phoen_bicolor_enable = get_woocommerce_term_meta($this->term_id, $this->meta_key() . '_phoen_bicolor_enable', true);
		}
		else if($type == 'phoen_image'){
			  $this->phoen_image = get_woocommerce_term_meta($this->term_id, $this->meta_key() . '_phoen_image', true);
		}
		else if($type == 'phoen_icon'){
			  $this->phoen_icon = get_woocommerce_term_meta($this->term_id, $this->meta_key() . '_phoen_icon', true);
		}

        $this->type = $type;
		
        $this->thumbnail_src = $woocommerce->plugin_url() . '/assets/images/placeholder.png';

        if ($type == 'phoen_image') {
            if ($this->thumbnail_id) {
                $imgsrc = wp_get_attachment_image_src($this->thumbnail_id, $this->size);
                if ($imgsrc && is_array($imgsrc)) {
                    $this->thumbnail_src = current($imgsrc);
                } else {
                    $this->thumbnail_src = $woocommerce->plugin_url() . '/assets/images/placeholder.png';
                }
            } else {
                $this->thumbnail_src = $woocommerce->plugin_url() . '/assets/images/placeholder.png';
            }
        }
    }

    public function init_size($size) {
       
		global $woocommerce, $_wp_additional_image_sizes;
        
		$this->size = $size;
        
		$the_size = isset($_wp_additional_image_sizes[$size]) ? $_wp_additional_image_sizes[$size] : $_wp_additional_image_sizes['shop_thumbnail'];
        
		if (isset($the_size['width']) && isset($the_size['height'])) {
        
			$this->width = $the_size['width'];
            
			$this->height = $the_size['height'];
        
		} else {
            
			$this->width = 40;
            
			$this->height = 40;
        
		}
    }

    public function get_output($placeholder = true, $placeholder_src = 'default') {
        
		global $woocommerce;
	
        $picker = '';
        
        $href = apply_filters('woocommerce_swatches_get_swatch_href', '#', $this);
       
		$anchor_class = apply_filters('woocommerce_swatches_get_swatch_anchor_css_class', 'swatch-anchor', $this);
        
		$image_class = apply_filters('woocommerce_swatches_get_swatch_image_css_class', 'swatch-img', $this);
        
		$image_alt = apply_filters('woocommerce_swatches_get_swatch_image_alt', 'thumbnail', $this);
       
        if ($this->type == 'phoen_color') {
          
		$phoen_bicolor=  $this->phoen_bicolor;
		
		$phoen_bicolor_enable=  $this->phoen_bicolor_enable ;
		
		  if($phoen_bicolor_enable==1){
			  $picker .= '<span class="" style="background:linear-gradient(to right bottom, '.$phoen_bicolor.' 49%, '.$this->phoen_color.' 50%);   display:block; width:' . $this->width . 'px; height:' . $this->height . 'px;"></span>';
		  }else{
			  $picker .= '<span class="" style=" background:'.$this->phoen_color.'; display:block; width:' . $this->width . 'px; height:' . $this->height . 'px;"></span>';
		  }
          
        }else if ($this->type == 'phoen_image') {
			
          if($this->phoen_image == '')
		  {
			  $phoen_image = $woocommerce->plugin_url() . '/assets/images/placeholder.png';
			  
		  }
		  else
		  {
			  $phoen_image = $this->phoen_image;
		  }
            $picker .= '<span class="" style=" display:block; width:' . $this->width . 'px; height:' . $this->height . 'px;"><img style=" width:' . $this->width . 'px; height:' . $this->height . 'px;" src="'.$phoen_image.'"></span>';
          
        }else if ($this->type == 'phoen_icon') {
          
            $picker .= '<span class="" style="text-align:center;  display:block; width:' . $this->width . 'px; height:' . $this->height . 'px;"><i style="line-height:33px;"class="fa '.$this->phoen_icon.'"></i></span>';
          
        }else if ($placeholder) {
            if ($placeholder_src == 'default') {
                $src = $woocommerce->plugin_url() . '/assets/images/placeholder.png';
            } else {
                $src = $placeholder_src;
            }

            $picker .= '<a href="' . $href . '" style="width:' . $this->width . 'px;height:' . $this->height . 'px;" title="' . $this->term_label . '"  class="' . $anchor_class . '">';
            $picker .= '<img src="' . $src . '" alt="' . $image_alt . '" class="wp-post-image swatch-photo' . $this->meta_key() . ' ' . $image_class . '" width="' . $this->width . '" height="' . $this->height . '"/>';
            $picker .= '</a>';
        } else {
            return '';
        }

        $out = '<div class="select-option swatch-wrapper" data-name="' . esc_attr($this->term_label) . '" data-value="' . md5( $this->term_slug ) . '" ' . ($this->selected ? 'data-default="true"' : '') . '>';
        $out .= apply_filters('woocommerce_swatches_picker_html', $picker, $this);
        $out .= '</div>';

        return $out;
    }

    public function get_type() {
        return $this->type;
    }

    public function get_image_src() {
        return $this->thumbnail_src;
    }

    public function get_image_id() {
        return $this->thumbnail_id;
    }

    public function get_width() {
        return $this->width;
    }

    public function get_height() {
        return $this->height;
    }

    public function meta_key() {
        return $this->taxonomy_slug . '_' . $this->attribute_meta_key;
    }

}