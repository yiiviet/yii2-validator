# YII2 Việt Nam Validator
**Yii2 Extension hổ trợ bạn kiểm tra dữ liệu đặc thù trong nước ta.**

[![Latest Stable Version](https://poser.pugx.org/yiiviet/yii2-validator/v/stable)](https://packagist.org/packages/yiiviet/yii2-validator)
[![Total Downloads](https://poser.pugx.org/yiiviet/yii2-validator/downloads)](https://packagist.org/packages/yiiviet/yii2-validator)
[![Build Status](https://travis-ci.org/yiiviet/yii2-validator.svg?branch=master)](https://travis-ci.org/yiiviet/yii2-validator)
[![Code Coverage](https://scrutinizer-ci.com/g/yiiviet/yii2-validator/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/yiiviet/yii2-validator/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yiiviet/yii2-validator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yiiviet/yii2-validator/?branch=master)
[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com/)

Khi bạn xây dựng hệ thống trong nước thì chắc chắn rằng việc xây dựng các `validator` để kiểm tra dữ liệu
đặc thù như: số điện thoại, chứng minh thư, ip Việt Nam, domain Việt Nam... sẽ thường xuyên xảy ra. 
Chính vì vậy extension này được xây dựng nên để cung cấp các `validator` phổ biến nhất về các dữ liệu
cơ bản tại nước ta.


Các kiểu dữ liệu hiện được hổ trợ:

* Số điện thoại bao gồm số di động và số bàn.
* Chứng minh thư và thẻ căn cước.
* IP Việt Nam
* Tên miền Việt Nam


## Cài đặt

Cài đặt thông qua `composer` nếu như đó là một khái niệm mới với bạn xin click vào 
[đây](http://getcomposer.org/download/) để tìm hiểu nó.

```sh
composer require "yiiviet/yii2-validator"
```

hoặc thêm

```json
"yiiviet/yii2-validator": "*"
```

vào phần `require` trong file composer.json.

## Cách sử dụng cơ bản

Về cách sử dụng thì bạn khai báo nó vào `rules` của `model`, `AR` như các `validator`
thuần của `yii2`


Ví dụ:

```php

class Info extends Model {

    public function rules() {
    
        return [
            ['IP', 'ipvn'],
            ['SDT', 'telnumvn'],
            ['CMND', 'idnumvn'],
            ['domain', 'domainvn']
        ];
    
    }
}
```

Bảng chú thích tên các `validator`:

| Validator | Chú thích | Cách dùng |
| :--------: | ---------- | -------- |
| telnumvn | Dùng để kiểm tra số điện thoại Việt Nam (viettel, vina, vsat, beeline, mobi, vietnammobi, số bàn...) | [Nhấn vào đây](#telnumvn)
| idnumvn | Dùng để kiểm tra chứng minh thư, thẻ căn cước (chứng minh 9 số, 12 số, thẻ căn cước) | [Nhấn vào đây](#idnumvn)
| ipvn | Dùng để kiểm tra IP Việt Nam | [Nhấn vào đây](#ipvn)
| domainvn | Dùng để kiểm tra tên miền Việt Nam (là tên miền hợp lệ và kết thúc bằng `.vn`) | [Nhấn vào đây](#domainvn)

### `telnumvn`

Khai báo rules:

```php

    return [
        ['SDT', 'telnumvn', 'message' => '{attribute} không phải là số điện thoại Việt Nam'],
    ];

```

Chỉ muốn kiểm tra số di động loại bỏ số bàn

```php

    return [
        ['SDT', 'telnumvn', 'exceptTelco' => ['landLine']],
    ];

```

Chỉ muốn kiểm tra số `viettel`

```php

    return [
        ['SDT', 'telnumvn', 'onlyTelco' => ['viettel']],
    ];

```

Chỉ muốn kiểm tra số `viettel`, `mobi`, `vina`

```php

    return [
        ['SDT', 'telnumvn', 'onlyTelco' => ['viettel', 'mobiFone', 'vinaPhone']],
    ];

```

Danh sách tên các telco (nhà mạng)

| Telco | Đại diện | 
| :--------: | ---------- |
| landLine | Số điện thoại bàn | 
| viettel | Viettel |
| vinaPhone | Vinaphone | 
| mobiFone | Mobifone |
| vietNamMobile | Viet Nam Mobile |
| gMobile | G Mobile |
| indoChina | IndoChina |

### `idnumvn`

Khai báo rules:

```php

    return [
        ['CMND', 'idnumvn', 'message' => '{attribute} không phải là chứng minh thư Việt Nam'],
    ];

```

Chỉ muốn kiểm tra số chứng minh (9 và 12 số) thư loại bỏ thẻ căn cước

```php

    return [
        ['SDT', 'telnumvn', 'onlyId' => true],
    ];

```

### `ipvn`

Khai báo rules:

```php

    return [
        ['IP', 'ipvn', 'message' => '{attribute} phải là IP Việt Nam!'],
    ];

```

Do `validator` này kế thừa `IpValidator` của `Yii2` nên tất cả các tham số thiết lập nâng cao
bạn có thể kham khảo thêm tại [đây](https://www.yiiframework.com/doc/guide/2.0/en/tutorial-core-validators#ip), còn không bạn chỉ cần khai báo như trên là đủ.

### `domainvn`


Khai báo rules:

```php

    return [
        ['domain', 'domainvn', 'message' => '{attribute} phải là tên miền Việt Nam!'],
    ];

```

Do `validator` này kế thừa `DomainValidator` của `Dmitry Kulikov` nên tất cả các tham số thiết lập nâng cao
bạn có thể kham khảo thêm tại [đây](https://github.com/dmitry-kulikov/yii2-domain-validator), còn không bạn chỉ cần khai báo như trên là đủ.

## Dành cho nhà phát triển

Nếu như bạn cảm thấy các `validators` bên trên vẫn chưa đủ đối với thị trường trong nước và bạn muốn
đóng góp để phát triển chung, chúng tôi rất hoan nghênh! Hãy tạo các `issue` để đóng góp ý tưởng cho
phiên bản kế tiếp hoặc tạo `PR` để đóng góp thêm các `validator` còn thiếu sót. Cảm ơn!
