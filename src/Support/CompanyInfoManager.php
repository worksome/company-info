<?php

declare(strict_types=1);

namespace Worksome\CompanyInfo\Support;

use Illuminate\Http\Client\Factory as Client;
use Illuminate\Support\Manager;
use Worksome\CompanyInfo\Providers\CvrApiProvider;
use Worksome\CompanyInfo\Providers\GazetteProvider;
use Worksome\CompanyInfo\Providers\VirkProvider;

class CompanyInfoManager extends Manager
{
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return '';
    }

    /**
     * Create CVR API service driver.
     */
    public function createCvrApiDriver(): CvrApiProvider
    {
        return new CvrApiProvider(
            $this->container->make(Client::class),
            $this->config->get('company-info.providers.cvrapi.base_url'),
            $this->config->get('company-info.providers.cvrapi.user_agent'),
        );
    }

    /**
     * Create Gazette service driver.
     */
    public function createGazetteDriver(): GazetteProvider
    {
        return new GazetteProvider(
            $this->container->make(Client::class),
            $this->config->get('company-info.providers.gazette.base_url'),
            $this->config->get('company-info.providers.gazette.key'),
            $this->config->get('company-info.max_results'),
        );
    }

    /**
     * Create VIRK service driver.
     */
    public function createVirkDriver(): VirkProvider
    {
        return new VirkProvider(
            $this->container->make(Client::class),
            $this->config->get('company-info.providers.virk.base_url'),
            $this->config->get('company-info.providers.virk.user_id'),
            $this->config->get('company-info.providers.virk.password'),
            $this->config->get('company-info.max_results'),
        );
    }
}
