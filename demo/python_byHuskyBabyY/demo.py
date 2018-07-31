#!/usr/bin/python
# -*- coding:utf-8 -*-
from plugin import cq_class
import json
import web
from plugin import sign


cq = cq_class.CoolQ()
sign = sign.Sign()
cq.host = '127.0.0.1'
cq.port = 9999
cq.key = '456'
cq.time = 30

urls = (
    '/', 'Msg'
)

app = web.application(urls, globals())

class Msg:

    def GET(self):
        print(1)
        # render = web.template.render('templates/')
        # name = 'Bob'
        # return render.index(name)
        # form = web.form
        # login = form.Form(
        #     form.Textbox('username'),
        #     form.Password('password'),
        #     form.Button('Login'),
        # )
        # f = login()
        # print(f.render())

    def POST(self):
        postTxt = list(web.input())
        postTxt = str(postTxt).strip('[\']').encode('gb2312').decode('unicode-escape')
        print(postTxt)
        #print(json.loads(postTxt)['msg'])
        postTxt = json.loads(postTxt)

        array = postTxt
        array = cq.receive(array)
        if not len(array):
            exit()

        qq = array['qq']
        group = array['group']
        type = array['type']
        if 'msg' in array:
            msg = array['msg']
        else:
            msg = ''
        if 'originalMsg' in array:
            msg = array['originalMsg']

        sendMsg = sign.nowSign(qq,group,msg,type)
        if sendMsg != "":
            cq.send_group_msg(group,sendMsg)



        # if array['type'] == 1:
        #     """私聊信息"""
        #     cq.send_private_msg(qq, '收到一条消息：%s' % msg)
        #
        #
        # elif array['type'] == 2:
        #     """群消息"""
        #     if msg == '你好':
        #         cq.send_group_msg(array['group'], '%s 我是小娜' % cq.cq_at(qq))
        #         cq.send_group_msg(array['group'], '你是我的闺蜜Siri吗')
        #     else:
        #         cq.send_group_msg(array['group'], '收到一条消息：%s' % msg)
        #
        # elif array['type'] == 4:
        #     """讨论组消息"""
        #     cq.send_discuss_msg(array['group'], '收到一条讨论组消息：%s' % msg)
        #
        # elif array['type'] == 11:
        #     """上传群文件"""
        #     msg = cq.cq_at(qq) + '上传了文件'
        #     file = array['fileInfo']
        #     msg += "\r\n文件名：%s" % file['name']
        #     cq.send_group_msg(array['group'], msg)
        #
        # elif array['type'] == 103:
        #     """群成员增加"""
        #     msg = '欢迎%s 加入本群' % cq.cq_at(array['beingOperateQQ'])
        #     cq.send_group_msg(array['group'], msg)


if __name__ == "__main__":
    app.run()



    # 请在这加入解析酷Q端发来的数据的代码，并转为元组
# 作者刚学Python不久，不会写监听http，下面这行只是为了不报错


