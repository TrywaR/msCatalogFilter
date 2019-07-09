<?php
// msCatalogFilter
// https://github.com/TrywaR/msCatalogFilter

switch($modx->event->name) {
	case 'OnPageNotFound':
		switch($_GET['q']){

      case 'msCatalogFilter':

        // Запоминаем сортировку
        if (isset($_POST['filter_data_sort']))
          $_SESSION['msCatalogFilter']['filter_data_sort'] = $_POST['filter_data_sort'];

        // Выводим сортировку если есть
        if (isset($_SESSION['msCatalogFilter']['filter_data_sort']) && isset($_POST['show']))
          echo $_SESSION['msCatalogFilter']['filter_data_sort'];

      	die();
      	break;
    }
}
