<?php
/**
 * @link https://github.com/yiiviet/yii2-validator
 * @copyright Copyright (c) 2018 Yii Viet
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yiiviet\tests\unit\validator;

use yii\base\DynamicModel;

/**
 * Lớp IdNumValidatorTest
 *
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0
 */
class IdNumValidatorTest extends TestCase
{
    /**
     * @dataProvider idNumValidProvider
     */
    public function testValidIdNum($idOld, $idNew, $cId)
    {
        $model = DynamicModel::validateData([
            'idOld' => $idOld,
            'idNew' => $idNew,
            'cId' => $cId
        ], [
            [['idOld', 'idNew', 'cId'], 'idnumvn']
        ]);

        $this->assertFalse($model->hasErrors());
    }

    /**
     * @dataProvider idNumValidProvider
     */
    public function testValidIdNumExceptCID($idOld, $idNew, $cId)
    {
        $model = DynamicModel::validateData([
            'idOld' => $idOld,
            'idNew' => $idNew,
            'cId' => $cId
        ], [
            [['idOld', 'idNew', 'cId'], 'idnumvn', 'onlyId' => true]
        ]);

        $this->assertTrue($model->hasErrors());
    }

    /**
     * @dataProvider idNumInvalidProvider
     */
    public function testInValidIdNum($idOld, $idNew, $cId)
    {
        $model = DynamicModel::validateData([
            'idOld' => $idOld,
            'idNew' => $idNew,
            'cId' => $cId
        ], [
            [['idOld', 'idNew', 'cId'], 'idnumvn']
        ]);

        $this->assertTrue($model->hasErrors());
    }

    public function idNumValidProvider()
    {
        return [
            ['293422825', '001089000098', '405071000030'],
            ['025478996', '036087000067', '526099003096'],
            ['017351686', '016509820190', '722099000144'],
            ['293422825', '079301000099', '836200003212'],
            ['293422825', '2934228250', '961302004651'],
        ];
    }

    public function idNumInvalidProvider()
    {
        return [
            ['79a7sd9a7', '331089000098a', '415071000030'],
            ['987845687', '836087000067e', '506099003096'],
            ['465879754', '216509820190f', '782099000144'],
            ['39979800e', '079301000099e', '816200003212'],
            ['554979964', '2934228250fe', '981302004651'],
        ];
    }

}
