<?php
/**
 * @link https://github.com/yiiviet/yii2-validator
 * @copyright Copyright (c) 2018 Yii Viet
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yiiviet\validator;

use yii\validators\IpValidator as BaseIpValidator;

/**
 * Lớp IpValidator dùng để kiểm tra `ip` Việt Nam.
 * Ví dụ khai báo kiểm tra ip trong model
 *
 * ```php
 *      public function rules() {
 *          return [
 *              ['telAttr', 'ipvn', 'message' => 'Ip phải là ip Việt Nam!']
 *          ];
 *      }
 * ```
 *
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0
 */
class IpValidator extends BaseIpValidator
{

    /**
     * @var array Thuộc tính hổ trợ cache range ip Việt Nam.
     */
    private static $_ipRanges = [];

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if (!empty(self::$_ipRanges)) {
            $this->setRanges(self::$_ipRanges);
        } else {
            $this->setRanges(self::$_ipRanges = require(__DIR__ . '/resource/ip-ranges.php'));
        }
    }


}
