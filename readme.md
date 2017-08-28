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

1. 从 [Release] 中下载最新版，并解压文件，
2. 将```org.inlinc.inhttp.cpk```放到```app```文件夹，重启酷Q并启用插件，

###  配置插件

* 打开设置，根据自身情况选择 提交方式 ，并合理设置相应的接口信息。
* 如果需要调用动态API，请设置 动态交互 的 监听端口。
* 如果需要保证数据一定的真实性，请开启 校验数据 开关，并设置key

## SDK文件

* [PHP SDK](https://github.com/Hstb1230/CtPe/tree/master/demo/php)
* [Python SDK](https://github.com/Hstb1230/CtPe/tree/master/demo/python)
 
## 文档

遇到使用问题时，可以先翻翻它：
* [wiki]
* [ZeroDoc]

## 反馈地址
* [Q群]
* [issue]
* [交流社区]


[issue]: https://github.com/Hstb1230/CtPe/issues
[Q群]: https://jq.qq.com/?_wv=1027&amp;k=4EvsX5W
[交流社区]: https://ask.1sls.cn
[wiki]: https://github.com/Hstb1230/CtPe/wiki
[ZeroDoc]: http://doc.inlinc.org/http-to-cq/
[Release]: https://github.com/Hstb1230/CtPe/releases
