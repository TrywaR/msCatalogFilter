# msCatalogFilter
Для работы нид pdoTools и minishop2

Поехали:

* создаём сниппет _CatalogFilter_ и пихаем в него код из файла _CatalogFilter.php_
* Подключаем к документу скрипт из файла _CatalogFilter.js_

В начале файла _CatalogFilter.php_ необходимо указать TV поля и name полей которые используются для сортировки

Вызываем сниппет
```
[[!msCatalogFilter?
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
ajaxContainerSelector = '.ajax-container', // Блок с результатами
ajaxItemSelector      = '.ajax-item', // Элемент выдачи (tpl)
ajaxFormSelector      = '.ajax-form', // Форма с фильтрами
ajaxFormButtonStart   = '.ajax-start', // Старт фильтрации
```
Класс _.ajax-disabled_ для _input_ отменяет его моментальную обработку при изменении его значения

## html
Если трудности с пониманием html, то пример в _index.html_ разбит на кусски с комментами

## Максимальная цена в каталоге
Может понадобится для фильтра с ценой, чтобы нельзя было указать цену выше той что есть в каталоге

Нужно создать сниппет с кодом из файла _msMaxPrice.php_

Выводить его следующим образом

```
[[msMaxPrice? parents=`[[*id]]`]]
```

## Подключение jQuery UI slider (Ползунок для цен)
Естетственно нужно подключить сам jQuery UI slider, его можно найти тут https://jqueryui.com/download/
Необходимый код есть в index.html и отдельно в jQueryUISlider.js запихать туда куда сочтёте нужным (:

## Если используется TV checkbox

для того чтобы вывести возможные значения можно воспользоватся кодом из TVsSelectValues.php
Он <strike>нагло сп</strike> скромно взят с замечательного блога http://mycode.in.ua/modx/snippets/list-tv-elements.html

# Сортировка
Для работы сортировки в `index.html` лежит форма сортировки и в форме фильтра есть input `sortBy`.

Весь необходимый js в `msCatalogFilter.js`.

Также понадобится подключить плагин `plugin.msCatalogFilter.php` с обработкой события `OnPageNotFound` для хранения данных в сессии.

Все параметры сортировки хранятся в сессии, и после обновления страницы сортировка сохраняется.

# Поиск
Для поиска надо добавить input с _.ajax-search_ в форму фильтра, или дублировать в него значения если поле поиска находится за пределами формы
