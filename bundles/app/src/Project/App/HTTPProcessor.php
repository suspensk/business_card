<?php

namespace Project\App;

/**
 * Handles processing of the HTTP requests
 */
class HTTPProcessor extends \PHPixie\DefaultBundle\Processor\HTTP\Builder
{
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * Constructor
     * @param Builder $builder
     */
    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    /**
     * Build 'greet' processor
     * @return HTTPProcessors\Auth
     */
    protected function buildAuthProcessor()
    {
        return new HTTPProcessors\Auth(
            $this->builder
        );
    }

    /**
     * Build 'dashboard' processor
     * @return HTTPProcessors\Greet
     */
    protected function buildDashboardProcessor()
    {
        return new HTTPProcessors\Pages($this->builder);
    }

    /**
     * Build 'frontpage' processor
     * @return HTTPProcessors\Greet
     */
    protected function buildFrontpageProcessor()
    {
        return new HTTPProcessors\Frontpage($this->builder);
    }

    /**
     * Build 'admin' processor group
     * @return HTTPProcessors\Admin\
     */
    protected function buildAdminProcessor()
    {
        return new HTTPProcessors\AdminProcessors($this->builder);
    }
    protected function buildQuickstartProcessor()
    {
        return new HTTPProcessors\Quickstart(
            $this->builder
        );
    }
    protected function buildCampaignsProcessor()
    {
        return new HTTPProcessors\Campaigns(
            $this->builder
        );
    }

    protected function buildPagesProcessor()
    {
        return new HTTPProcessors\Pages(
            $this->builder
        );
    }
}