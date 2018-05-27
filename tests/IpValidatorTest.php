<?php
/**
 * @link https://github.com/yiiviet/yii2-validator
 * @copyright Copyright (c) 2018 Yii Viet
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yiiviet\tests\unit\validator;

use yii\base\DynamicModel;

/**
 * Lớp IpValidatorTest
 *
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0
 */
class IpValidatorTest extends TestCase
{

    /**
     * @dataProvider validIpProvider
     */
    public function testValidIp($ip)
    {
        $model = DynamicModel::validateData(['ip' => $ip], [
            ['ip', 'ipvn']
        ]);

        $this->assertFalse($model->hasErrors());
    }

    /**
     * @dataProvider invalidIpProvider
     */
    public function testInvalidIp($ip)
    {
        $model = DynamicModel::validateData(['ip' => $ip], [
            ['ip', 'ipvn']
        ]);

        $this->assertTrue($model->hasErrors());
    }


    public function validIpProvider()
    {
        return [
            ['113.161.173.10'],
            ['171.255.199.129'],
            ['118.70.187.126'],
            ['115.78.225.211'],
            ['2405:4800:102:1::3'],
            ['2001:df0:66:40::16']
        ];
    }

    public function invalidIpProvider()
    {
        return [
            ['217.24.254.30'],
            ['82.114.86.1'],
            ['200.114.80.9'],
            ['190.123.83.251'],
            ['190.123.83.251'],
            ['190.123.83.251'],
            ['139.199.201.249'],
            ['52.80.73.123'],
            ['2a03:2880:f11f:83:face:b00c::25de'],
            ['2a00:1450:4007:809::200e']
        ];
    }
}
