<?php
/**
 * @link https://github.com/yiiviet/yii2-validator
 * @copyright Copyright (c) 2018 Yii Viet
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yiiviet\validator;

use yii\base\BootstrapInterface;
use yii\validators\Validator;

/**
 * Lớp Bootstrap dùng để khai báo các validator vào built-in của YII2, từ đó tạo nên sự đơn giản hóa khi sử dụng.
 *
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0
 */
class Bootstrap implements BootstrapInterface
{

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        Validator::$builtInValidators = array_merge([
            'ipvn' => IpValidator::class,
            'idnumvn' => IdNumValidator::class,
            'telnumvn' => TelNumValidator::class,
            'domainvn' => DomainValidator::class
        ], Validator::$builtInValidators);
    }

}
