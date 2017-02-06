<?php
/**
 * Created by PhpStorm.
 * User: happy_ryo
 * Date: 2017/02/02
 * Time: 17:23
 */

namespace Munouni\Instagram\HttpRequests;

interface InstagramRequestInterface
{
    /**
     * @return string
     */
    public function getEndPoint();

    /**
     * @return string
     */
    public function getMethod();

    /**
     * @return array
     */
    public function getParams();
}