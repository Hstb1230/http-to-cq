HTTP API 插件
---
[![Last Commit]][commit]
[![Latest release]][Latest Release]
[![Pre-release]][Release]
[![Download Count]][Release]
[![Q群]][Q群链接]

## **说明**

HTTP对接插件 是一套给 Web网站 开发者使用的应用程序开发框架和工具包。 它的目标是让你能够使用其他语言开发酷Q插件，它提供了酷Q大部分原生API，以及插件自集成的API，通过这些丰富你的机器人功能。

## **功能**

1. 使用```JSON```/```key=value```数据格式
2. 使用```Socket```/```HTTP```方式提交数据
3. 使用```HTTP```协议动态调用 酷Q API
4. 使用 提交规则 和 校验数据 
5. 使用 定时任务 / 崩溃自重启 

## **安装与配置**

### 安装插件

1. 在 [Release] 中下载最新版文件(如果是压缩包, 需要先解压)，
2. 将`org.inlinc.inhttp.cpk`放到 **`\app\`** 目录下，在 **重启酷Q** 或 **重载应用** 后, 启用插件，

###  配置插件

* 打开设置，根据自身情况选择 提交方式 ，并合理设置相应的接口信息。
* 如果需要调用动态API，请设置 动态交互 的 监听端口。
* 如果需要保证数据一定的真实性，请开启 校验数据 开关，并设置key

## SDK

* 以下是部分语言的SDK，在感谢这些开发者的辛勤付出。

| 语言 | 地址 | 作者 | 备注 |
| --- | ---- | --- | --- |
| Java | [ForeverWJY/CoolQ_Java_Plugin] | ForeverWJY | 已兼容v2.x |
| Java | [ForteScarlet/simple-robot-component-httpapi] | ForteScarlet | 已兼容v2.x |
| PHP | [admin1234566/jailbot] | admin1234566 | 已兼容v2.x |
| PHP | [Hstb1230/http-to-cq/php] | Hstb1230 | 已兼容v2.x |
| PHP | [fastgoo/cq-http-phpsdk] | fastgoo | 已兼容v2.x |
| PHP | [HiiLee/CoolQQ] | HiiLee | 只兼容v1.3 |
| Python | [Hstb1230/http-to-cq/python] | Hstb1230 | 已兼容v2.x |
| Python | [HuskyBabyY/http-to-cq] | HuskyBabyY | 已兼容v2.x |

若您编写了SDK但未被收录, 请联系我添加.

## 使用文档

遇到问题时可以先翻翻文档
* [Zero Doc]（推荐）
* [Github Wiki]

### 还有其他问题？
试试以下沟通渠道：
* [Ask社区]
* [issue]

## 许可证的相关说明

许可证本身并无什么法律效力, 只是为了提醒使用者遵守道德规范, 保持职业操守（个人理解）.

很早以前开源过代码，目的是在为开源做贡献的同时，希望能有开发者一同完善功能。

但最后并没有一同完善功能的开发者，反而出现不合乎道德的重新分发行为，因此转为闭源。

但为防止哪天想不开, 又将代码开源, 却再出现类似的不道德行为, 因此花时间编写了自定义许可证.

关于特殊约定的修改权问题，本人可以保证所有限制都只为了保护作者的权益。

若您不放心，认为部分限制存在问题，可提出质疑，或使用其他具有相似功能的软件，但请勿人身攻击。

### 具有相似功能的软件

* [richardchien/coolq-http-api] (RCNB)

  这里只放最经典，酷Q或其他机器人社区上当然也有更多不同开发者作品。

### 耻辱柱

> 这里指间接或直接使用本人曾经发布的本插件源码，本人不反对二次开发，（因为不可能存在一套既适用于所有场景下，又足够精简的程序），但**拒绝未标明原作者的二次发布**，即使不存在许可证，但一个人应当具有一定的道德底线，更何况在发布应用时已经注明必须保留原作者版权。

本插件于16年发布，后面因想对开源社区做贡献，也想寻找一些能够一起改进代码的开发者，虽然代码很烂但还是发了（见commit），这里也贴出相应链接（有兴趣的同学可以自行下载学习，依赖的模块不全但网上都能找到，能耐心看到这里的，我想我应该不用再多说什么)
* [20160915] (插件雏形，不过早已发至[酷Q社区](https://cqp.cc/t/25331)，只是刚接触github，所以也搬过来了)
* [20170818] (不是很完善但已够的体系框架，引入WebSocket达到反向连接的效果，之所以能认出上柱者，主要是因为实现的功能与这份代码无差别，最多只是砍掉某些功能，加上项目描述，非常稳的认出来)

本来已经过了两三年，虽然“很感谢”这类人告诉我某些现实，也已经不想说了，但在哪里都能看到这种恶心身影的存在，实在是忍受不了，不如一吐为快。

* ksust/HTTP--API 

  已被二发至酷Q、（已经跑路的）IRQQ、QQLight、契约，
  
  MyPCQQ的那个HTTPAPI插件高度疑似，可能是从上面这位那拿的源码，不做更多猜测与评价。

虽然已经把我的源码开出花，但，不光彩的过去总归是抹不去。

正是因为这类同行外加某机器人起家史的“教导”，同时也没达到开源所要达成的目标，因此让我意识到本插件的开源是非常不必要的，
至于未来会不会开源，我想，如果仍然处于这样的环境下，答案一定是否定的，最多是除了本人都看不懂的代码，也可能是连本人都看不懂的代码，或者全混淆后二次发布也不错⑧。

[issue]: https://github.com/Hstb1230/http-to-cq/issues
[Q群链接]: https://jq.qq.com/?_wv=1027&k=4EvsX5W
[Github Wiki]: https://github.com/Hstb1230/http-to-cq/wiki
[Zero Doc]: https://www.kancloud.cn/zerolib/http-to-cq/387458
[Ask社区]: https://ask.1sls.cn/

[ForeverWJY/CoolQ_Java_Plugin]: https://github.com/ForeverWJY/CoolQ_Java_Plugin
[ForteScarlet/simple-robot-component-httpapi]: https://github.com/ForteScarlet/simple-robot-component-httpapi
[admin1234566/jailbot]: https://code.aliyun.com/admin1234566/jailbot
[Hstb1230/http-to-cq/php]: https://github.com/Hstb1230/http-to-cq/tree/master/demo/php
[fastgoo/cq-http-phpsdk]: https://github.com/fastgoo/cq-http-phpsdk 
[HiiLee/CoolQQ]: https://github.com/HiiLee/CoolQQ
[HuskyBabyY/http-to-cq]: https://github.com/Hstb1230/http-to-cq/tree/master/demo/python_byHuskyBabyY
[Hstb1230/http-to-cq/python]: https://github.com/Hstb1230/http-to-cq/tree/master/demo/python

[Last Commit]: https://img.shields.io/github/last-commit/Hstb1230/http-to-cq/2.5 "v2.5"
[Latest release]: https://img.shields.io/github/release/Hstb1230/http-to-cq.svg?label=Latest%20release "Latest release"
[Pre-release]: https://img.shields.io/github/v/release/Hstb1230/http-to-cq?include_prereleases&label=Pre-release "Pre-release"
[Download Count]: https://img.shields.io/github/downloads/Hstb1230/http-to-cq/total.svg "Download Count"
[Q群]: https://img.shields.io/badge/Q%E7%BE%A4-553601318-blue.svg "Q群"

[commit]: https://github.com/Hstb1230/http-to-cq/commits/2.5
[Release]: https://github.com/Hstb1230/http-to-cq/releases/
[Latest Release]: https://github.com/Hstb1230/http-to-cq/releases/latest

[richardchien/coolq-http-api]: https://github.com/richardchien/coolq-http-api

[20160915]: https://github.com/Hstb1230/http-to-cq/tree/fe10c5e12e605e7be9cb1bf99d4c9afd7cf92016/OldCode
[20170818]: https://github.com/Hstb1230/http-to-cq/tree/20fe309124880afd659dff5a5e8b9b850dbe9ed6/OldCode
