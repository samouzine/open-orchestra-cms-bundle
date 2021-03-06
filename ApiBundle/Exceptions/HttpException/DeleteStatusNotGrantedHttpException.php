<?php

namespace OpenOrchestra\ApiBundle\Exceptions\HttpException;

use OpenOrchestra\BaseApi\Exceptions\HttpException\ApiException;

/**
 * Class DeleteStatusNotGrantedHttpException
 */
class DeleteStatusNotGrantedHttpException extends ApiException
{
    const DEVELOPER_MESSAGE  = 'open_orchestra_api.status.delete_not_granted';
    const HUMAN_MESSAGE      = 'open_orchestra_api.status.delete_not_granted';
    const STATUS_CODE        = '403';
    const ERROR_CODE         = 'x';

    /**
     * Constructor
     */
    public function __construct()
    {
        $developerMessage   = self::DEVELOPER_MESSAGE;
        $humanMessage       = self::HUMAN_MESSAGE;
        $statusCode         = self::STATUS_CODE;
        $errorCode          = self::ERROR_CODE;

        parent::__construct($statusCode, $errorCode, $developerMessage, $humanMessage);
    }
}
