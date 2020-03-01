HTTP API 插件
---
[![Build Status](https://img.shields.io/badge/build-passing-brightgreen.svg)]()
[![Release](https://img.shields.io/github/release/Hstb1230/CtPe.svg)][Release]
[![Download Count](https://img.shields.io/github/downloads/Hstb1230/CtPe/total.svg)][Release]
[![QQ群](https://img.shields.io/badge/QQ%E7%BE%A4-553601318-blue.svg)][Q群]

## **说明**

HTTP对接插件 是一套给 Web网站 开发者使用的应用程序开发框架和工具包。 它的目标是让你能够使用其他语言开发酷Q插件，它提供了酷Q大部分原生API，以及插件自集成的API，通过这些，丰富你的机器人功能。

## **功能**

1. 使用```JSON```/```key=value```数据格式
2. 使用```Socket```/```HTTP```方式提交数据
3. 使用```HTTP```协议动态调用 酷Q API
4. 使用 提交规则 和 校验数据 
5. 使用 定时任务 / 崩溃自重启 

## **安装与配置**

### 安装插件

1. 在 [Release] 中下载最新版文件(如果是压缩包, 需要先解压)，
2. 将```org.inlinc.inhttp.cpk```放到```\data\app\```目录下，重启酷Q并启用插件，

###  配置插件

* 打开设置，根据自身情况选择 提交方式 ，并合理设置相应的接口信息。
* 如果需要调用动态API，请设置 动态交互 的 监听端口。
* 如果需要保证数据一定的真实性，请开启 校验数据 开关，并设置key

## SDK

* 以下是部分语言的SDK，在感谢这些开发者的辛勤付出。

| 语言 | 地址 | 作者 | 备注 |
| --- | ---- | --- | --- |
| Java | [ForeverWJY/CoolQ_Java_Plugin] | ForeverWJY | 已兼容v2.x |
| PHP | [Hstb1230/http-to-cq/php] | Hstb1230 | 已兼容v2.x |
| PHP | [fastgoo/cq-http-phpsdk] | fastgoo | 已兼容v2.x |
| PHP | [HiiLee/CoolQQ] | HiiLee | 只兼容v1.3 |
| Python | [Hstb1230/http-to-cq/python] | Hstb1230 | 已兼容v2.x |
| Python | [HuskyBabyY/http-to-cq] | HuskyBabyY | 已兼容v2.x |

若您编写了SDK, 但未被收录, 请联系我添加.

## 使用文档

遇到使用问题时，可以先翻翻它：
* [ZeroDoc]
* [GithubWiki]

## 如何联系
* [Ask社区]
* [issue]

## 许可证说明

许可证本身并无什么法律效力, 只是为了提醒使用者遵守道德规范, 保持职业操守.

代码曾经开源过, 但最后还是发生了我所担心和反感的不合乎道德的重新分发行为, 因此转为闭源,

但为了防止自己哪天想不开, 又将代码开源, 却再出现不道德的行为, 因此花时间编写了本许可证.

关于特殊约定的修改权问题, 我能保证不添加过分的限制, 若您不放心, 认为部分限制存在问题, 可以提出质疑, 或使用其他软件.

[issue]: https://github.com/Hstb1230/CtPe/issues
[Q群]: https://jq.qq.com/?_wv=1027&k=4EvsX5W
[GithubWiki]: https://github.com/Hstb1230/Http-to-cq/wiki
[ZeroDoc]: https://www.kancloud.cn/zerolib/http-to-cq/387458
[Release]: https://github.com/Hstb1230/Http-to-cq/releases
[Ask社区]: https://ask.1sls.cn/

[ForeverWJY/CoolQ_Java_Plugin]: https://github.com/ForeverWJY/CoolQ_Java_Plugin
[Hstb1230/http-to-cq/php]: https://github.com/Hstb1230/http-to-cq/tree/master/demo/php
[fastgoo/cq-http-phpsdk]: https://github.com/fastgoo/cq-http-phpsdk 
[HiiLee/CoolQQ]: https://github.com/HiiLee/CoolQQ
[HuskyBabyY/http-to-cq]: https://github.com/Hstb1230/http-to-cq/tree/master/demo/python_byHuskyBabyY
[Hstb1230/http-to-cq/python]: https://github.com/Hstb1230/CtPe/tree/master/demo/python
