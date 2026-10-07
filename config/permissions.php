<?php

return [
    'dashboard' => ['dashboard.view'],
    'projects' => ['projects.view','projects.create','projects.edit','projects.delete'],
    'contracts' => ['contracts.view','contracts.create','contracts.edit'],
    'progress' => ['progress.view','progress.create','progress.edit'],
    'man_days' => ['man_days.view','man_days.create','man_days.edit'],
    'costs' => ['costs.view','costs.create','costs.edit','costs.delete'],
    'invoices' => ['invoices.view','invoices.create','invoices.edit','invoices.approve'],
    'collections' => ['collections.view','collections.create'],
    'forecasts' => ['forecasts.view','forecasts.create','forecasts.edit'],
    'reports' => ['reports.view','reports.export'],
    'alerts' => ['alerts.view','alerts.manage'],
    'settings' => ['settings.view','settings.edit'],
    'users' => ['users.view','users.create','users.edit','users.delete'],
];
