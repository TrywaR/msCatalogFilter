# CatalogFilter
[ MODX Revo > PDOTols > Resource filter ]

Вызов
```
[[!catalogFilter?
  &tpl=`tpl`
  &limit=`8`
  &parents=`[[*id]]`
  &fields=`price`
  &sortby=`menuindex`
  &sortdir=`ASC`
]]
```
Где _fields_ необходимые tv поля

Так же можно юзать всё что есть в pdoResources

## Для работы Ajax нид
Нужно чтобы были указаны все необходимые классы
```
ajaxCountSelector     = '.ajax-count', // CSS Selector of Items Counter
ajaxContainerSelector = '.ajax-container', // CSS Selector of Ajax Container
ajaxItemSelector      = '.ajax-item', // CSS Selector of Ajax Item
ajaxFormSelector      = '.ajax-form', // CSS Selector of Ajax Filter Form
ajaxFormButtonStart   = '.ajax-start', // CSS Selector of Button Start Filtering
```

## Подключение jQuery UI slider
Необходимый код в jQueryUISlider.js запихать туда куда сочтёте нужным (:
