<?php

return array(
  'type' => 'group',
  'heading' => 'Advanced',
  'options' => array(
    'class' => array(
        'type' => 'textfield',
        'heading' => 'Class',
        'param_name' => 'class',
        'default' => '',
    ),
    'visibility'  => require( __DIR__ . '/visibility.php' ),
  ),
);