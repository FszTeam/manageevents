<?php namespace FszTeam\ManageEvents\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

class Calendars extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('FszTeam.ManageEvents', 'manageevents', 'calendars');
    }
}