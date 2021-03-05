<?php
// msCatalogFilter
// https://github.com/TrywaR/msCatalogFilter

//Filter Fields Settings
$filter = array(); # where

// price
if(isset($_REQUEST['price_from'])) $filter[] = 'price>='.$_GET['price_from'];
if(isset($_REQUEST['price_to'])) $filter[] = 'price<='.$_GET['price_to'];
// price x

// search
if(!empty($_REQUEST['search'])) $filter[] = "pagetitle LIKE '%".$_REQUEST['search']."%'";
// search x

// vendors
if(!empty($_REQUEST['vendors'])) $filter[] = "vendor IN (".$_REQUEST['vendors'].")";
// vendors x

// more vendors
// $sTvFilters = '';
// if (!empty($_REQUEST['vendors']) ) {
//   // &tvFilters = "&tvFilters=`dop_vendor==one%,filter1==bar%||filter1==foo`"
//   $parents = $_REQUEST['vendors'];
//   $ArrParents = explode(',', $parents);
//   if ( count($ArrParents) ) {
//     $sSeporator = '';
//     foreach ($ArrParents as $iParent) {
//       $sTvFilters .= $sSeporator . "dop_vendor==%" . $iParent . '%';
//       if ( $sTvFilters ) $sSeporator = '||';
//     }
//   }
//   else {
//     $sTvFilters .= "dop_vendor==" . $parents . '%';
//   }
// }
// more vendors x

// options filter
$optionFilters = array(); # optionFilters

// parents
if (!empty($_REQUEST['parents']) ) $parents = $_REQUEST['parents'];
// parents x

// if need more TV checkbox like text
if($_GET['tv_names']) $filter[] = "tv_name IN (".$_GET['tv_names'].")";

// not empty old_price
if($_GET['old_price']) $filter[] = 'old_price>0';

//Checkbox Type
// if($_GET['garage']) {
//     $filter[] = 'garage=1';
// }

// availability
if(isset($_REQUEST['availability'])) $optionFilters[] = '"availability:=":1';
// availability x

$optionFiltersJson = '';
if(count($optionFilters)){
  foreach ($optionFilters as $optionFilter) {
    if ($optionFiltersJson) $optionFiltersJson .= ',';
    $optionFiltersJson .= $optionFilter;
  }
  $optionFiltersJson = '{'.$optionFiltersJson.'}';
}
// options filter x


// sale
if( isset($_GET['old_price']) ) $filter[] = 'old_price>0';
// sale x

//Sort
$sortby = 'pagetitle';
$sortdir = 'ASC';

if( $_GET['sortby'] ) $sortby = $_GET['sortby'];
if( $_GET['sortdir'] ) $sortdir = $_GET['sortdir'];

if (isset($_SESSION['msCatalogFilter']['filter_data_sort'])) {
  $sortby = $_SESSION['msCatalogFilter']['filter_data_sort'];
  $sortdir = '';
}
//Sort x

//Offset
$offset = 0;
if( isset($_GET['offset']) ) $offset = $_GET['offset'];

$where = $filter ? $modx->toJSON(array($filter)) : '';
$params_count = array(
  'parents' => $parents,
  'limit' => 0,
  'tpl' => '@INLINE ,',
  'select' => 'id',
  'includeTVs' => $fields,
  'showHidden' => '1',
  // 'tvFilters' => $sTvFilters,
  'where' => $where,
  'optionFilters' => $optionFiltersJson
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
  // 'tvFilters' => $sTvFilters,
  'where' => $where,
  'optionFilters' => $optionFiltersJson
);

$more = $count - $offset - $limit;
$lim = $more > $limit ? $limit : $more;
$button = '';
if($more > 0){
  $button = '<div class="ajax-filter-count w-100 d-flex justify-content-center" data-count="'.$count.'"><button href="#" class="btn ajax-more btn">Загрузить еще '.$lim.' из '.$more.'</button></div>';
}
$arrData = $modx->runSnippet('msProducts',$params);
return $arrData.$button;
