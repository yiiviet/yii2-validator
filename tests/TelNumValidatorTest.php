<?php
/**
 * @link https://github.com/yiiviet/yii2-validator
 * @copyright Copyright (c) 2018 Yii Viet
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yiiviet\tests\unit\validator;

use yii\base\DynamicModel;

/**
 * Lớp TelNumValidatorTest
 *
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0
 */
class TelNumValidatorTest extends TestCase
{

    /**
     * @dataProvider telNumValidProvider
     */
    public function testValidTelNum($phone)
    {
        $model = DynamicModel::validateData(['tel' => $phone], [
            ['tel', 'telnumvn']
        ]);

        $this->assertFalse($model->hasErrors());

        $model = DynamicModel::validateData(['tel' => $phone], [
            ['tel', 'telnumvn', 'mobileFormat' => true]
        ]);

        $this->assertFalse($model->hasErrors());
        $this->assertNotEquals($phone, $model['tel']);
        $phone = $model['tel'];

        $model = DynamicModel::validateData(['tel' => $phone], [
            ['tel', 'telnumvn', 'mobileFormat' => true]
        ]);

        $this->assertFalse($model->hasErrors());
        $this->assertEquals($phone, $model['tel']);
    }

    /**
     * @dataProvider telNumInvalidProvider
     */
    public function testInvalidTelNum($phone)
    {
        $model = DynamicModel::validateData(['tel' => $phone], [
            ['tel', 'telnumvn']
        ]);

        $this->assertTrue($model->hasErrors());
    }

    public function testTelcoDetected()
    {
        $model = DynamicModel::validateData(['tel' => '0909113911'], [
            ['tel', 'telnumvn', 'onlyTelco' => ['landLine']]
        ]);

        $this->assertTrue($model->hasErrors());

        $model = DynamicModel::validateData(['tel' => '0909113911'], [
            ['tel', 'telnumvn', 'exceptTelco' => ['landLine']]
        ]);

        $this->assertFalse($model->hasErrors());
    }

    public function telNumValidProvider()
    {
        return [
            ['84982527982'],
            ['84973776072'],
            ['84917749254'],
            ['84904770053'],
            ['842838564399']
        ];
    }

    public function telNumInvalidProvider()
    {
        return [
            ['asdasdasdasd1231a'],
            ['!@#!@#1123123..123'],
            ['09091139111'],
            ['016485754635'],
            ['0703366854'],
            ['070336685a']
        ];
    }
}
