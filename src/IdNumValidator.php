<?php
/**
 * @link https://github.com/yiiviet/yii2-validator
 * @copyright Copyright (c) 2018 Yii Viet
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yiiviet\validator;

use yii\validators\RegularExpressionValidator;

/**
 * Lớp IdNumValidator dùng để kiểm tra số chứng minh thư có hợp lệ hay không.
 * Ví dụ khai báo kiểm tra số chứng minh thư trong model
 *
 * ```php
 *      public function rules() {
 *          return [
 *              ['idAttr', 'idnumvn', 'message' => 'Chứng minh nhân dân không hợp lệ.']
 *          ];
 *      }
 * ```
 *
 * Nếu bạn chấp nhận luôn thẻ căn cước vừa mới ban hành thì:
 *
 * ```php
 *      public function rules() {
 *          return [
 *              ['idAttr', 'idnumvn', 'message' => 'Chứng minh nhân dân hoặc thẻ căn cước không hợp lệ.', 'onlyId' => false]
 *          ];
 *      }
 * ```
 *
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0
 */
class IdNumValidator extends RegularExpressionValidator
{

    /**
     * @var bool Thiết lập nếu như bạn chỉ muốn kiểm tra chứng minh thư (không bao gồm thẻ căn cước).
     */
    public $onlyId = false;

    /**
     * @var string Pattern của chứng minh thư cũ.
     */
    public $id = '^((0[0-8]|1[0-9]|2[0-9]|3[0-8])\d{7})|((09[015]|23[01]|245|28[015])\d{6})$';

    /**
     * @var string Pattern của chứng minh thư mới.
     */
    public $idNew = '^((0[0-8]|1[0-9]|2[0-9]|3[0-8])\d{10})|((09[015]|23[01]|245|28[015])\d{9})$';

    /**
     * @var string Pattern của căn cước công dân.
     */
    public $cId = '^(0[012468]|1[0124579]|2[02]|2[4-7]|3[01]|3[3-8]|4[0245689]|5[12468]|6[024678]|7[024579]|8[0234679]|9[1-6])\d{10}$';

    /**
     * {@inheritdoc}
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $pattern = [$this->id, $this->idNew];

        if (!$this->onlyId) {
            $pattern[] = $this->cId;
        }

        $this->pattern = "/(" . implode(")|(", $pattern) . ")/";

        parent::init();
    }

}
