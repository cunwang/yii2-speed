
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

如，测试脚本1.php

```php
require "vendor/autoload.php";
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
stdClass Object
(
	 [title] => Speed-20180316114041
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
		  [0] => Option-5aab3cb9396fe
		  [1] => Option-5aab3cb93976d
		  [2] => Option-5aab3cba3985a
		  [3] => Option-5aab3cbc39973
		  [4] => Option-5aab3cbd39aa0
	 )

	 [time] => Array
	 (
		  [0] => 1521171641.2353
		  [1] => 1521171641.2354
		  [2] => 1521171642.2356
		  [3] => 1521171644.2359
		  [4] => 1521171645.2362
	 )

	 [optionSpeed] => Array
	 (
		  [0] => 0.00011
		  [1] => 1.00024
		  [2] => 2.00028
		  [3] => 1.00030
	 )

	 [allSpeed] => 4.00093
	 [average] => 0.800186
 )

 ```

以上

