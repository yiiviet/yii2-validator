<?php
/**
 * @link https://github.com/yiiviet/yii2-validator
 * @copyright Copyright (c) 2018 Yii Viet
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yiiviet\tests\unit\validator;

use yii\base\DynamicModel;

/**
 * Lớp DomainValidatorTest
 *
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0
 */
class DomainValidatorTest extends TestCase
{

    /**
     * @dataProvider validDomainProvider
     */
    public function testValidDomain($domain)
    {
        $model = DynamicModel::validateData([
            'domain' => $domain
        ], [
            ['domain', 'domainvn']
        ]);

        $this->assertFalse($model->hasErrors());
    }

    /**
     * @dataProvider invalidDomainProvider
     */
    public function testInvalidDomain($domain)
    {
        $model = DynamicModel::validateData([
            'domain' => $domain
        ], [
            ['domain', 'domainvn']
        ]);

        $this->assertTrue($model->hasErrors());
    }

    public function validDomainProvider()
    {
        return [
            ['yiiframework.vn'],
            ['chinhphu.vn'],
            ['edu.vn'],
            ['fpt.edu.vn'],
            ['zing.vn'],
            ['mp3.zing.vn'],
            ['gov.vn'],
            ['google.com.vn'],
            ['vnexpress.vn'],
            ['momo.vn']
        ];
    }


    public function invalidDomainProvider()
    {
        return [
            ['yiiframework.com'],
            ['github.com'],
            ['google.com'],
            ['stackoverflow.com'],
            ['blog.jetbrains.com']
        ];
    }


}
