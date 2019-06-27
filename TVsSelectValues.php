<?php
// <!--Основные параметры (выводим просто список)-->
// [[!TVsSelectValues?
//   &tv=`category`
//   &tpl=`tpl.optionList`
// ]]
//
// <!--Выводим список с выбором активных элементов -->
// [[!TVsSelectValues?
//   &tv=`category`
//   &tpl=`tpl.optionList`
//   &param=`category`
//   &active=`selected`
// ]]
//
// <!--Все параметры-->
// [[!TVsSelectValues?
//   &tv=`category`
//   &tpl=`tpl.optionList`
//   &param=`category`
//   &active=`selected`
//   &parent=`32`
//   &hideEmpty=`1`
//   &strict=`0`
// ]]

// tpl.optionList
// <option value="[[+value]]" [[+active]]>[[+name]] ([[+count]])</option>
// --
// <label class="input_block_item">
//   <input class="ajax-disabled" name="[[+tv_name]]" value="[[+name]]" type="checkbox"/>
//   [[+name]]
// </label>


$output = '';
$tv = $modx->getOption('tv', $scriptProperties, 'list');
$tpl = $modx->getOption('tpl', $scriptProperties, '');
$hideEmpty = $modx->getOption('hideEmpty', $scriptProperties, false);

$parent = $modx->getOption('parent', $scriptProperties, false);
$strict = $modx->getOption('strict', $scriptProperties, false);

$param = $modx->getOption('param', $scriptProperties, 'false');
$active = $modx->getOption('active', $scriptProperties, 'active');
$filter = isset($_GET[$param]) ? $_GET[$param] : false;

$query = $modx->newQuery('modTemplateVar',array('name'=>$tv));
$query->select('elements,id');
if ($query->prepare() && $query->stmt->execute()) {
    $row = $query->stmt->fetch(PDO::FETCH_ASSOC);
}
$elmts = explode('||',$row['elements']);
$tvid = $row['id'];

$elements = array();
foreach($elmts as $idx => $elmt){
    $elmt = explode('==',trim($elmt));
    $name = $value = $elmt[0];
    if(count($elmt) == 2){
        $value = $elmt[1];
    }
    $modx->setPlaceholder("tv_name", $tv);
    $modx->setPlaceholder("name", $name);
    $modx->setPlaceholder("value", $value);
    $modx->setPlaceholder("idx", $idx+1);
    $count = 1;
    if($parent){
        $ids = $modx->getChildIds($parent,2);
        $where = array('contentid:IN' => $ids, 'tmplvarid' => $tvid, 'value:LIKE' => '%'.$value.'%');
        if($strict){
            $where = array('tmplvarid' => $tvid, 'value' => $value);
        }
        $query = $modx->newQuery('modTemplateVarResource', $where);
        $query->select(array('count'=>'count(id)'));
        if ($query->prepare() && $query->stmt->execute()) {
            $count = $query->stmt->fetch(PDO::FETCH_ASSOC);
        }
        $count = intval($count['count']);
        $modx->setPlaceholder("count", $count);
    }
    $status = '';
    if($filter){
        if(is_array($filter)){
            $status = in_array($value, $filter) ? $active : '';
        }else{
            $status = $value == $filter ? $active : '';
        }
    }

    $modx->setPlaceholder("active", $status);

    if($hideEmpty){
        if($count > 0){
            $output .= $modx->getChunk($tpl);
        }
    }else{
        $output .= $modx->getChunk($tpl);
    }
}
return $output;
