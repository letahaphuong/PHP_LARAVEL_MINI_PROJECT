<?php

namespace App\Repositories\Facilities;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AttachFacilityRepository.
 *
 * @package namespace App\Repositories\Facilities;
 */
interface AttachFacilityRepository extends RepositoryInterface
{
    function getAllAttachFacilities($filters, $keywords, $perPage);

    function createAttachFacility($data);

    function updateAttachFacility($data);
}
