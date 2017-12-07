<?php namespace Allatrack\Eurodrinks\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use System\Classes\SettingsManager;

/**
 * Addresses Back-end Controller
 */
class Addresses extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $bodyClass = 'compact-container';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.System', 'system');
        SettingsManager::setContext('Allatrack.Eurodrinks', 'manager_addresses');
    }

    public function create()
    {

        $this->addJs('/plugins/allatrack/eurodrinks/assets/js/lib/gmaps.js', 'core');
        $this->addJs('/plugins/allatrack/eurodrinks/assets/js/addresses/form/create.js', 'core');

        // Call the FormController behavior update() method
        return $this->asExtension('FormController')->create();
    }

    public function update($recordId, $context = null)
    {

        $this->addJs('/plugins/allatrack/eurodrinks/assets/js/lib/gmaps.js', 'core');
        $this->addJs('/plugins/allatrack/eurodrinks/assets/js/addresses/form/update.js', 'core');

        // Call the FormController behavior update() method
        return $this->asExtension('FormController')->update($recordId, $context);
    }
}
