<?php
/**
 * @link https://github.com/yiiviet/yii2-validator
 * @copyright Copyright (c) 2018 Yii Viet
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yiiviet\validator;

use yii\base\InvalidConfigException;
use yii\validators\RegularExpressionValidator;

/**
 * Lớp TelNumValidator dùng để kiểm tra số điện thoại trong nước có hợp lệ hay không. Nó được phát triển theo tài liệu wiki
 * link: https://vi.wikipedia.org/wiki/M%C3%A3_%C4%91i%E1%BB%87n_tho%E1%BA%A1i_Vi%E1%BB%87t_Nam
 *
 * Ví dụ khai báo kiểm tra số điện thoại hợp lệ trong `model`
 *
 * ```php
 *      public function rules() {
 *          return [
 *              ['telAttr', 'telnumvn', 'message' => 'Số điện thoại phải là số trong nước']
 *          ];
 *      }
 * ```
 *
 * Chỉ kiểm tra số di động (bỏ số bàn)
 *
 * ```php
 *      public function rules() {
 *          return [
 *              ['telAttr', 'telnumvn', 'message' => 'Số điện thoại phải là số trong nước', 'exceptTelco' => 'landLine']
 *          ];
 *      }
 * ```
 *
 * Chỉ kiểm tra số bàn (bỏ số di động)
 *
 * ```php
 *      public function rules() {
 *          return [
 *              ['telAttr', 'telnumvn', 'message' => 'Số điện thoại phải là số trong nước', 'onlyTelco' => 'landLine']
 *          ];
 *      }
 * ```
 *
 * danh sách các telco (nhà mạng) hổ trợ: mobiFone, vinaPhone, viettel, vietNamMobile, gMobile, beeline, vsat, indoChina, landLine.
 *
 * Sử dụng trong DynamicModel tương tự.
 *
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0
 */
class TelNumValidator extends RegularExpressionValidator
{

    /**
     * @var array Mảng chứa tên các telco (nhà mạng). Các nhà mạng nằm trong mảng sẽ là kiểu ràng buộc của dữ liệu.
     * Lưu ý nếu như tên telco cũng nằm ở mảng `exceptTelco` thì mặc định telco đó sẽ bị loại bỏ.
     *
     * Nếu mảng là rổng động nghĩa với dữ liệu kiểm tra chỉ cần là số điện thoại Việt Nam.
     *
     * @see exceptTelco
     */
    public $onlyTelco = [];

    /**
     * @var array Mảng chứa tên các telco (nhà mạng). Các nhà mạng nằm trong mảng sẽ được bỏ qua (không kiểm tra).
     * @see onlyTelco
     */
    public $exceptTelco = [];

    /**
     * @var string Pattern kiểm tra số viettel.
     */
    public $viettel = '^(\+?84|0)?(3[2-9]|86|9[6-8])\d{7}$';

    /**
     * @var string Pattern kiểm tra số vinaphone.
     */
    public $vinaPhone = '^(\+?84|0)?(8[1-5]|88|9[14])\d{7}$';

    /**
     * @var string Pattern kiểm tra số mobiphone.
     */
    public $mobiFone = '^(\+?84|0)?(70|7[6-9]|89|9[03])\d{7}$';

    /**
     * @var string Pattern kiểm tra số vnmobi.
     */
    public $vietNamMobile = '^(\+?84|0)?(5[68]|92)[\d]{7}$';

    /**
     * @var string Pattern kiểm tra số gmobile.
     */
    public $gMobile = '^(\+?84|0)?([59]9|95)[\d]{7}$';

    /**
     * @var string Pattern kiểm tra số indochina.
     */
    public $indoChina = '^(\+?84|0)?87[\d]{7}$';

    /**
     * @var string Pattern kiểm tra số điện thoại bàn.
     */
    public $landLine = '^(\+?84|0)?(((20[3-9]|21[0-6]|21[89]|22[0-2]|22[5-9]|23[2-9]|24[2-5]|248|25[12]|25[4-9]|26[0-3]|27[0-7]|28[2-5]|29([0-4]|[67])|299)\d{7})|((246[236]|247[13]|286[23]|287[13])\d{6}))$';

    /**
     * @var bool|string Thiết lập kiểu `format` di động thêm '0' sau khi thực thi kiểm tra hoàn tất (dữ liệu attr hợp lệ).
     * Nó dùng để chuẩn hóa dữ liệu cho bạn. Mặc định `FALSE` sẽ không can thiệp đến dữ liệu của bạn.
     */
    public $mobileFormat = false;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        $this->onlyTelco = (array)$this->onlyTelco;
        $this->exceptTelco = (array)$this->exceptTelco;

        $pattern = [];
        foreach (['viettel', 'vinaPhone', 'mobiFone', 'vietNamMobile', 'indoChina', 'gMobile', 'landLine'] as $telco) {
            if ($this->isUse($telco)) {
                $pattern[] = $this->{$telco};
            }
        }

        if (!empty($pattern)) {
            $this->pattern = "~(" . implode(")|(", $pattern) . ")~";
        } else {
            throw new InvalidConfigException('Your telco setup is not valid!');
        }

        parent::init();
    }


    /**
     * Phương thức kiểm tra telco (nhà mạng) có phải là thành phần cần kiểm tra hay không.
     * Nó được trích từ [yii\base\ActionFilter::isActive()].
     *
     * @param string $telco Tên nhà mạng cần kiểm tra
     * @return bool Trả về `TRUE` nếu như telco la thành phần kiểm tra.
     */
    protected function isUse($telco)
    {
        if (empty($this->onlyTelco)) {
            $only = true;
        } else {
            $only = false;
            foreach ($this->onlyTelco as $expect) {
                if ($telco === $expect) {
                    $only = true;
                    break;
                }
            }
        }

        $except = false;
        foreach ($this->exceptTelco as $expect) {
            if ($telco === $expect) {
                $except = true;
                break;
            }
        }

        return $only && !$except;
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        if (($result = parent::validateAttribute($model, $attribute)) === null) {
            if ($this->mobileFormat) {
                $model->{$attribute} = preg_replace('/^(\+?84|0)?(\d+)$/', '0$2', $model->{$attribute});
            }
        }

        return $result;
    }

}
