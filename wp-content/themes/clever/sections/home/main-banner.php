  <section class="main-banner">
    <div class="main-banner__content">
      <?php $args = array('post_type' => 'itemsbanner', 'order'=> 'ASC','post_status' => 'publish', 'posts_per_page' => 100); ?>        
      <?php $loop = new WP_Query( $args ); ?>
      <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>     
     <?php if (get_field('banner_option') == "Imagen") { ?>
		<div class="main-banner__item">
		  
        <div class="main-banner__text wow animated fadeIn" style="visibility: visible; animation-delay: .3s  ;">
          <div class="main-banner__width">
            <h2 class="main-banner__title">
              <?php the_field('banner_subtitle'); ?>
            </h2>
            <p class="main-banner__subtitle">
              <?php the_field('banner_description'); ?>
            </p>
            <br>
            <a class="main-general__button main-general__button--white" href="<?php the_field('banner_urlbutton'); ?>"><?php the_field('banner_button'); ?></a>
          </div>
        </div>
        <div class="main-banner__img">
        
          <img alt="Imagen Banner" src="<?php the_field('banner_image'); ?>">
          
        </div>
			        </div>

		<?php }else{ ?>  
		<div class="main-banner__item">
		   <div class="main-banner__text wow animated fadeIn" style="visibility: visible; animation-delay: .3s  ;">
          <div class="main-banner__width">
			  <div class="main-banner__title--video">
				 <h2 class="main-banner__title">
              <?php the_field('banner_subtitle'); ?>
				
            </h2> 
				  	  	<div class="buttons">
							  <button class="uk-button button uk-button-primary first" onclick="playVid()" type="button">
    <i class="uk-icon-play fa fa-play"></i></button>
  <button class="uk-button button uk-button-primary second" onclick="pauseVid()" type="button">
    <i class="uk-icon-pause fa fa-pause"></i></button>

							<button class="mute-video"></button>
</div>
			  </div>
            
		
            <p class="main-banner__subtitle">
              <?php the_field('banner_description'); ?>
            </p>
            <br>
            <a class="main-general__button main-general__button--white" href="<?php the_field('banner_urlbutton'); ?>"><?php the_field('banner_button'); ?></a>
          </div>
        </div>
		  <div class="main-banner__img">
        
        
          <video autoplay="true" muted="true" id="myVideo" src="<?php the_field('banner_video'); ?>"> </video>
		
         </div>
  </div>
		      <?php } ?> 
    <?php endwhile; ?>   
    </div>
  </section>
<style>
.button {width: 40px; height: 40px;
	border: none;
	border-radius: 50%;
	    margin-right: 5px;
	    background-color: #c3c3c3;
	display: inline-block}
.first {display: none;}
.buttons { text-align: center;
	    margin-bottom: 9px;
    margin-left: 24px;
	    display: flex;
    align-items: center;
	}
	
	.mute-video {
    background:url(https://www.flaticon.com/svg/static/icons/svg/727/727240.svg) no-repeat center;
background-size: 14px;    border:0;
       width: 40px;
    height: 40px;
    border: none;
    border-radius: 50%;
    display: inline-block;
		    background-color: #c3c3c3;
}
.unmute-video {
    background:url(https://www.flaticon.com/svg/static/icons/svg/565/565296.svg) no-repeat center;
  background-size: 14px;
	    width: 40px;
    height: 40px;
    border: none;
    border-radius: 50%;
    display: inline-block;
	    background-color: #c3c3c3;
}
	
	@media (min-width: 0px) and (max-width: 997px) {
		
		.buttons {
			margin-left: 11px;
		
		}
		
		.button {

		}
	}
</style>
<script>
// get video element id
var vidClip = document.getElementById("myVideo"); 

// play video event
function playVid() { 
    myVideo.play();
} 

// pause video event
function pauseVid() { 
  myVideo.pause(); 
}

// toggle button class on click
$('.button').on('click', function() {
  $('.first, .second').toggle();
});

// toggle button class when finished
vidClip.onended = function(e) {
  $('.first, .second').toggle();
};
	
	$("video").prop('muted', true);

$(".mute-video").click(function () {
    if ($("video").prop('muted')) {
        $("video").prop('muted', false);
        $(this).addClass('unmute-video');

    } else {
        $("video").prop('muted', true);
        $(this).removeClass('unmute-video');
    }
});

</script>