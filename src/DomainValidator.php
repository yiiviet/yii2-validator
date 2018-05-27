<?php
/**
 * @link https://github.com/yiiviet/yii2-validator
 * @copyright Copyright (c) 2018 Yii Viet
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yiiviet\validator;

use kdn\yii2\validators\DomainValidator as BaseDomainValidator;

/**
 * Lớp DomainValidator dùng để kiểm tra tên miền có phải là của Việt Nam hay không.
 * Ví dụ khai báo kiểm tra domain Việt Nam trong `model`
 *
 * ```php
 *      public function rules() {
 *          return [
 *              ['domainAttr', 'domainvn', 'message' => 'Tên miền không phải miền VN!']
 *          ];
 *      }
 * ```
 *
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0
 */
class DomainValidator extends BaseDomainValidator
{

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if (empty($this->message)) {
            $this->message = '{attribute} is invalid `.vn` domain!';
        }
    }

    /**
     * @inheritdoc
     * @throws \yii\base\NotSupportedException
     */
    public function validateValue($value)
    {
        if ($result = parent::validateValue($value)) {
            return $result;
        } elseif (!preg_match('/\.vn$/', $value)) {
            return [$this->message, []];
        } else {
            return null;
        }
    }

}
