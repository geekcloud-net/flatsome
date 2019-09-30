<?php
// [lightbox]
function ux_lightbox($atts, $content=null) {
    $sliderrandomid = rand();
    extract( shortcode_atts( array(
        'id' => 'enter-id-here',
        'width' => '650px',
        'padding' => '20px',
        'class' => '',
        'auto_open' => false,
        'auto_timer' => '2500',
        'auto_show' => ''
    ), $atts ) );
    ob_start();
    ?>
<div id="<?php echo $id; ?>"
    class="lightbox-by-id lightbox-content mfp-hide lightbox-white <?php echo $class; ?>"
    style="max-width:<?php echo $width ?> ;padding:<?php echo $padding; ?>">
    <?php echo flatsome_contentfix($content); ?>
</div>
<?php if($auto_open) { ?>
<script>
// Auto open lightboxes
jQuery(document).ready(function($) {

    // auto open lightbox
     <?php if($auto_show == 'always') { ?>
      cookie("lightbox_<?php echo $id; ?>", false);<?php } ?>
    // run lightbox if no cookie is set
     if(cookie("lightbox_<?php echo $id; ?>") !== 'opened'){
          // Open lightbox
          setTimeout(function(){
              $.magnificPopup.open({midClick: true, removalDelay: 300, items: { src: '#<?php echo $id; ?>', type: 'inline'}});
          }, <?php echo $auto_timer; ?>);

          // set cookie
          cookie("lightbox_<?php echo $id; ?>", "opened");
      }
});
</script>
<?php } ?>

<?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode("lightbox", "ux_lightbox");
