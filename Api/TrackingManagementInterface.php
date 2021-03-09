<?php
declare(strict_types=1);

namespace Loop\Tracker\Api;

interface TrackingManagementInterface
{

    /**
     * Output tracking data.
     * @api
     * @return array
     */
    public function getTracking();
}

