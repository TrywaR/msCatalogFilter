<?php
//Filter Fields Settings
$filter = array();

//Radio, Select & Text Fields Type
// if($_GET['floor']) {
//     $filter[] = 'floor='.$_GET['floor'];
// }

//Two Text Fields From To
if($_GET['price_from']) {
    $filter[] = 'price>='.$_GET['price_from'];
}
if($_GET['price_to']) {
    $filter[] = 'price<='.$_GET['price_to'];
}

//Checkbox Type
// if($_GET['garage']) {
//     $filter[] = 'garage=1';
// }

//End Settings

//Sort
if($_GET['sortby']) {
    $sortby = $_GET['sortby'];
} else {
    $sortby = 'pagetitle';
}
if($_GET['sortdir']) {
    $sortdir = $_GET['sortdir'];
} else {
    $sortdir = 'asc';
}
//End Sort

//Offset
$offset = 0;
if($_GET['offset']){
    $offset = $_GET['offset'];
}

if($filter) {
    $where = $modx->toJSON(array($filter));
} else {
    $where = '';
}

$params_count = array(
    'parents' => $parents,
    'limit' => 0,
    'tpl' => '@INLINE ,',
    'select' => 'id',
    'includeTVs' => $fields,
    'showHidden' => '1',
    'where' => $where
);

$count = $modx->runSnippet('msProducts',$params_count);
$count = count(explode(',',$count))-1;
$modx->setPlaceholder('count',$count);

$params = array(
    'parents' => $parents,
    'limit' => $limit,
    'offset' => $offset,
    'tpl' => $tpl,
    'select' => 'id,pagetitle,introtext,content',
    'includeTVs' => $fields,
    'showHidden' => '1',
    'sortby' => $sortby,
    'sortdir' => $sortdir,
    'where' => $where
);

$more = $count - $offset - $limit;
$lim = $more > $limit ? $limit : $more;

$button = '';
if($more > 0){
    $button = '<div class="ajax-filter-count" data-count="'.$count.'"><a href="#" class="ajax-more">Загрузить еще '.$lim.' из '.$more.'</a></div>';
}

return $modx->runSnippet('msProducts',$params).$button;
