
### 实现功能

可记录程序或方法运行中区块消耗（平均、区块、总量），记录过程中抛出的错误。
运行结果为json数据，可用于生成报表数据。


### 安装

此程序可以通过composer 进行安装

```php
composer require yii2-cmslib/speed
```

或者

在composer.json添加 ```"yii2-cmslib/speed":"1.1*"``` ，然后composer update 即可。


### 运行示例

[1.php]
```php
//引入自动加载
require "vendor/autoload.php";

//引入全名空间
use Yii2cms\lib\speed;

//类实例化
$s  = new speed();

//增加一个测试区间,别名叫test1 
$s->s('loop', 'test1');
sleep(1);

//增加一个测试区间,别名叫test2
$s->s('loop', 'test2');
sleep(2);

//增加一个测试区间,别名叫test3
$s->s('loop', 'test3');
sleep(1);

//结束数据收集
$s->end();

$d  = $s->data();	//返回json_encode($arr)后Json数据
$d  = $s->data('arr'); //返回数据
```

数据格式如下：

```php
Array
(
 [title] => Speed-20180316115016
 [flag] =>
 [alias] => Array
 (
  [0] => Start
  [1] => test1
  [2] => test2
  [3] => test3
  [4] => End
 )

 [option] => Array
 (
  [0] => Option-5aab3ef847c1a
  [1] => Option-5aab3ef847cb9
  [2] => Option-5aab3ef947dd4
  [3] => Option-5aab3efb47efe
  [4] => Option-5aab3efc48024
 )

 [time] => Array
 (
  [0] => 1521172216.2939
  [1] => 1521172216.2941
  [2] => 1521172217.2944
  [3] => 1521172219.2947
  [4] => 1521172220.295
 )

 [optionSpeed] => Array
 (
  [0] => 0.00016
  [1] => 1.00029
  [2] => 2.00030
  [3] => 1.00029
 )

 [allSpeed] => 4.00104
 [average] => 0.800208
 )

 ```

 以上

