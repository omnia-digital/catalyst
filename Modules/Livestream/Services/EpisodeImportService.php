<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Http\Requests\EpisodeImportRequest;

/**
 * Handles Importing Episodes from another provider
 *
 * Class EpisodeImportService
 * @package App\Services
 */
class EpisodeImportService extends EpisodeService
{
    protected $_provider_name;
    protected $_import_type;
    protected $_params;

    protected $_provider_adapter;

    public function __construct(EpisodeImportRequest $request)
    {
        if (!empty($request->livestream_account_id)) {
            $livestream_account_id = $request->livestream_account_id;
        } else {
            $livestream_account_id = null;
        }
        parent::__construct($livestream_account_id);

        $this->_provider_name                   = $request->provider;
        $this->_import_type                     = $request->import_type;
        $this->_params                          = $request->toArray();

        if (!empty($this->_livestreamAccount)) {
            $this->_params['livestream_account_id'] = $this->_livestreamAccount->id;
        }

    }

    protected function getProviderAdapter()
    {
        // get list of hosting providers we allow
        // instantiate the hosting provider
        // call the handle method and let that hosting provider adapter determine whether it supports rss or any other type
        // if no import type is provided, use the default type for that provider
        $hostingProvidersList = new Collection([
            'sermon-browser-wp-plugin' => 'App\Services\Adapters\SermonBrowserWPPluginAdapter'
        ]);
        $providerClass = $hostingProvidersList->get($this->_provider_name);

        // @TODO [Josh] - if class doesn't exist, through an error that says we don't know how to parse this because there is no registered handler for this hostingProvider
        return $this->_provider_adapter = new $providerClass();
    }

    /**
     * Import Episodes from External Source into Omnia
     */
    public function import()
    {
        $this->getProviderAdapter();
        return $this->_provider_adapter->import($this->_import_type, $this->_params);
    }
}
