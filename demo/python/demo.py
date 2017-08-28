from cq_class import CoolQ

cq = CoolQ()
cq.host = '127.0.0.1'
cq.port = 9999
cq.key = '456'
cq.time = 30

# 请在这加入解析酷Q端发来的数据的代码，并转为元组
# 作者刚学Python不久，不会写监听http，下面这行只是为了不报错

array = dict()

array = cq.receive(array)
if not len(array):
    exit()

qq = array['qq']

if 'msg' in array:
    msg = array['msg']
else:
    msg = ''
if 'originalMsg' in array:
    msg = array['originalMsg']

if array['type'] == 1:
    """私聊信息"""
    cq.send_private_msg(qq, '收到一条消息：%s' % msg)

elif array['type'] == 2:
    """群消息"""
    if msg == '你好':
        cq.send_group_msg(array['group'], '%s 我是小娜' % cq.cq_at(qq))
    else:
        cq.send_group_msg(array['group'], '收到一条消息：%s' % msg)

elif array['type'] == 4:
    """讨论组消息"""
    cq.send_discuss_msg(array['group'], '收到一条讨论组消息：%s' % msg)

elif array['type'] == 11:
    """上传群文件"""
    msg = cq.cq_at(qq) + '上传了文件'
    file = array['fileInfo']
    msg += "\r\n文件名：%s" % file['name']
    cq.send_group_msg(array['group'], msg)

elif array['type'] == 103:
    """群成员增加"""
    msg = '欢迎%s 加入本群' % cq.cq_at(array['beingOperateQQ'])
    cq.send_group_msg(array['group'], msg)
