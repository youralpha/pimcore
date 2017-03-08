<?php
/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Enterprise License (PEL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) 2009-2016 pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PEL
 */

namespace Pimcore\Bundle\PimcoreBundle\Http;


use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Pimcore\Config;

class ClientFactory {

    public static function createHttpClient() {
        $systemConfig = Config::getSystemConfig();

        $guzzleConfig = [
            RequestOptions::TIMEOUT => 3600
        ];

        if($systemConfig['httpclient']['adapter'] == 'Proxy') {

            $authorization = "";
            if($systemConfig['httpclient']['proxy_user']) {
                $authorization = $systemConfig['httpclient']['proxy_user'] . ":" . $systemConfig['httpclient']['proxy_pass'] . "@";
            }
            $proxyUri = "tcp://" . $authorization . $systemConfig['httpclient']['proxy_host'] . ":" . $systemConfig['httpclient']['proxy_port'];

            $guzzleConfig[RequestOptions::PROXY] = $proxyUri;
        }

        return new Client($guzzleConfig);
    }

}