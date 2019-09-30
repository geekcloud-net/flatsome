<?php

/**
* @global string    $title
* @global string    $hook_suffix
* @global WP_Screen $current_screen
* @global WP_Locale $wp_locale
* @global string    $pagenow
* @global string    $wp_version
* @global string    $update_title
* @global int       $total_update_count
* @global string    $parent_file
*/

/** WordPress Administration Bootstrap */
require_once( ABSPATH . 'wp-admin/admin.php' );

wp_user_settings();
wp_enqueue_style( 'colors' );
wp_enqueue_style( 'ie' );
wp_enqueue_script('utils');
wp_enqueue_script( 'svg-painter' );

global $title, $hook_suffix, $current_screen, $wp_locale, $pagenow,
  $update_title, $total_update_count, $parent_file;

?><!DOCTYPE html>
<html>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <script type="text/javascript">
  var addLoadEvent = function(func){if(typeof jQuery!="undefined")jQuery(document).ready(func);else if(typeof wpOnload!='function'){wpOnload=func;}else{var oldonload=wpOnload;wpOnload=function(){oldonload();func();}}};
  var ajaxurl = '<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>',
    pagenow = '<?php echo $current_screen->id; ?>',
    typenow = '<?php echo $current_screen->post_type; ?>',
    thousandsSeparator = '<?php echo addslashes( $wp_locale->number_format['thousands_sep'] ); ?>',
    decimalPoint = '<?php echo addslashes( $wp_locale->number_format['decimal_point'] ); ?>',
    isRtl = <?php echo (int) is_rtl(); ?>;
  </script>
  <?php do_action( 'admin_enqueue_scripts', $hook_suffix ); ?>
  <?php do_action( "admin_print_styles-{$hook_suffix}" ); ?>
  <?php do_action( 'admin_print_styles' ); ?>
  <?php do_action( "admin_print_scripts-{$hook_suffix}" ); ?>
  <?php do_action( 'admin_print_scripts' ); ?>
  <?php do_action( "admin_head-{$hook_suffix}" ); ?>
  <?php do_action( 'admin_head' ); ?>
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      height: 100vh !important;
      padding: 1.5rem !important;
      background-color: transparent;
    }
    #wp-uxbuilder-wrap {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      height: 100%;
    }
    #wp-uxbuilder-editor-container {
      flex: 1;
    }
    #wp-uxbuilder-editor-container .mce-panel,
    #wp-uxbuilder-editor-container .mce-stack-layout {
      height: 100%;
      min-height: 20px;
    }
    #wp-uxbuilder-editor-container .mce-edit-area {
      flex: 1;
    }
    #wp-uxbuilder-editor-container .mce-edit-area iframe {
      height: 100% !important;
    }
    #wp-uxbuilder-editor-container .mce-statusbar {
      flex: 0;
    }
    #wp-uxbuilder-editor-container .mce-resizehandle {
      display: none !important;
    }
    .mce-container-body {
      display: flex !important;
      flex-direction: column;
    }
    .media-modal {
      top: 0 !important;
      right: 0 !important;
      bottom: 0 !important;
      left: 0 !important;
    }
    .media-modal-close {
      top: 5px !important;
      right: 20px !important;
    }
    .wp-editor-tools {
      user-select: none;
      margin-bottom: 10px;
    }
    .wp-editor-tools .wp-media-buttons .button {
      padding-right: 10px;
    }
    .wp-editor-tools .wp-media-buttons .dashicons {
      display: inline-block;
      margin-right: 5px;
      width: 18px;
      height: 18px;
      font-size: 18px;
    }
    .wp-editor-tools .wp-media-buttons .separator {
      display: inline-block;
      margin-right: 15px;
    }
    .wp-core-ui .quicktags-toolbar input.button.button-small {
        width: auto;
    }
  </style>
</head>
<body>
  <?php wp_editor( '', 'uxbuilder', array( 'wpautop' => false, 'quicktags' => false ) ); ?>
  <?php do_action( 'admin_footer', '' ); ?>
  <?php do_action( "admin_print_footer_scripts-{$hook_suffix}" ); ?>
  <?php do_action( 'admin_print_footer_scripts' ); ?>
  <?php do_action( "admin_footer-{$hook_suffix}" ); ?>
  <script>
    var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
    var textarea = document.getElementById('uxbuilder');
    var source = 'uxBuilderWpEditor';
    var eventNames = 'change keyup ExecCommand';
    var editor = null;

    tinyMCE.on('AddEditor', function (event) {
      editor = event.editor;
    });

    window.uxBuilderHide = function () {
      parent.postMessage({ source: source, type: 'hide' }, '*');
    }

    window.uxBuilderDiscard = function () {
      parent.postMessage({ source: source, type: 'discard' }, '*');
    }

    window.addEventListener('message', function (event) {
      if (event.data.source !== 'uxbuilder') return;

      editor = tinyMCE.activeEditor;

      switch (event.data.type) {
        case 'close':
          textarea.removeEventListener('input', onTextAreaChange);
          editor.off(eventNames, onEditorChange);

          textarea.value = '';
          editor.setContent('');
          editor.undoManager.clear();
          break;
        case 'setContent':
          textarea.removeEventListener('input', onTextAreaChange);
          editor.off(eventNames, onEditorChange);

          editor.undoManager.clear();
          textarea.value = event.data.content;
          editor.setContent(event.data.content);

          textarea.addEventListener('input', onTextAreaChange, false);
          editor.on(eventNames, onEditorChange);

          prevContent = editor.getContent();
          break;
        case 'updateContent':
          textarea.removeEventListener('input', onTextAreaChange);
          editor.off(eventNames, onEditorChange);

          textarea.value = event.data.content;
          editor.setContent(event.data.content);

          textarea.addEventListener('input', onTextAreaChange, false);
          editor.on(eventNames, onEditorChange);
          break;
      }
    }, false);

    function onTextAreaChange (event) {
      parent.postMessage({
        source: source,
        type: 'change',
        content: event.target.value
      }, '*');
    }

    function onEditorChange (event) {
      var content = editor.getContent();

      if (content === prevContent) {
        return;
      }

      parent.postMessage({
        source: source,
        type: 'change',
        content: content
      }, '*');

      prevContent = content;
    }
  </script>
</body>
</html>
