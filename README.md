# RE2BIT Generator

## Basic Ussage
* create ``codegen generator:create -c config.php.dist -d data.json``
* clear ``codegen generator:clear -c config.php.dist``

## Config File
See config.php.dist
```$php
<?php

return [
    Re2bit\Generator\Adapter\Php\ZendExpressiv\Generator::class =>  realpath(__DIR__ . '/Output/PHP'),
    Re2bit\Generator\Adapter\Js\ExtJs\Generator::class => realpath(__DIR__ . '/Output/Js')
];
```

## Data File
```$json
{
  "name": "Re2bit",
  "useNamespace": true,
  "modules": [
    {
      "name": "Report",
      "layout": "tab",
      "resources": [
        {
          "name": "ManualAdd",
          "icon": "icon-32",
          "associations": [],
          "fields": [
            {
              "name": "CsvData",
              "type": "string",
              "validators": [
                {
                  "type": "string"
                }
              ],
              "nullable": false,
              "description": "Csv Data which replaces the current data",
              "translations": [
                {
                  "language": "de",
                  "name": "Csv Daten",
                  "description": "Csv Daten welche die aktuellen Daten ersetzen"
                }
              ]
            }
          ],
          "actions": [
            {
              "type": "show"
            },
            {
              "type": "index"
            },
            {
              "type": "update"
            },
            {
              "type": "delete"
            },
            {
              "type": "create"
            }
          ]
        }
      ],
      "actions": [
      ]
    }
  ]
}
```
