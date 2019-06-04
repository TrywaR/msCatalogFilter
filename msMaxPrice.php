<?php
// Параметры
// $parents
// Параметры х

if (!$parents)
  $parents = $modx->resource->id;

$params_count = array(
    'parents' => $parents,
    'limit' => 1,
    'tpl' => '@INLINE {$price}',
    'select' => 'price',
    'sortby' => 'price',
    'sortdir' => 'desc',
    'showHidden' => '1'
);

return str_replace(' ', '', $modx->runSnippet('msProducts',$params_count));
