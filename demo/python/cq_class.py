
class StaticCoolQ (object):
    """
    静态API

    说明：
         * 此class只用于获取特定CQ码，并没有真正的调用API！！！
    """

    @staticmethod
    def cq_at(qq, need_space=True) -> str:
        """
        @某人(at)

        :param qq: 要艾特的QQ号，-1 为全体
        :param need_space: At后不加空格，默认为 True，可使At更规范美观。如果不需要添加空格，请置本参数为 False。
        :rtype: str
        :return: CQ码_At
        """
        qq = (qq == -1) and 'all' or '%d' % qq
        return ('[CQ:at,qq=%s] ' % qq) if need_space else ('[CQ:at,qq=%s]' % qq)

    @staticmethod
    def cq_emoji(_id) -> str:
        """
        发送Emoji表情(emoji)

        :param _id: 表情ID，emoji的unicode编号
        :rtype: str
        :return: CQ码_emoji
        """
        return '[CQ:emoji,id=%d]' % _id

    @staticmethod
    def cq_face(_id) -> str:
        """
        发送表情(face)

        :param _id: 表情ID，0 ~ 200+
        :rtype: str
        :return: CQ码_表情
        """
        return '[CQ:face,id=%d]' % _id

    @staticmethod
    def cq_shake() -> str:
        """
        发送窗口抖动(shake)

        仅支持好友，腾讯已将其改名为戳一戳

        :rtype: str
        :return: CQ码_窗口抖动
        """
        return '[CQ:shake]'

    @staticmethod
    def anti_escape(msg) -> str:
        """
        反转义

        :param msg: 原消息，要反转义的字符串
        :rtype: str
        :return: 反转义后的字符串
        """
        msg.replace('&#91;', '[')
        msg.replace('&#93;', ']')
        msg.replace('&#44;', ',')
        msg.replace('&amp;', '&')
        return msg

    @staticmethod
    def escape(msg, escape_comma=False) -> str:
        """
        转义

        :param msg: 要转义的字符串
        :param escape_comma: 转义逗号，默认不转义
        :rtype: str
        :return: 转义后的字符串
        """
        msg.replace('[', '&#91;')
        msg.replace(']', '&#93;')
        msg.replace('&', '&amp;')
        if escape_comma:
            msg.replace(',', '&#44;')
        return msg

    @classmethod
    def cq_share(cls, url, title='', content='', pic_url='') -> str:
        """
        发送链接分享(share)

        :param url: 分享链接，点击卡片后跳转的网页地址
        :param title: 标题，可空，分享的标题，建议12字以内
        :param content: 内容，可空，分享的简介，建议30字以内
        :param pic_url: 图片链接，可空，分享的图片链接，留空则为默认图片
        :rtype: str
        :return: CQ码_链接分享
        """
        msg = '[CQ:share,url=' + cls.escape(url, True)
        if title.strip():
            msg += ',title=' + cls.escape(title, True)
        if content.strip():
            msg += ',content=' + cls.escape(content, True)
        if pic_url.strip():
            msg += ',image=' + cls.escape(pic_url, True)
        return msg + ']'

    @classmethod
    def cq_card_share(cls, _id, _type='qq') -> str:
        """
        发送名片分享(contact)

        :param _id: 分享帐号，类型为qq，则为QQ号；类型为group，则为群号
        :param _type: 分享类型，目前支持 qq/好友分享 group/群分享
        :rtype: str
        :return: CQ码_名片分享
        """
        _type = cls.escape(_type, True)
        return '[CQ:contact,type=%s,id=%d]' % (_type, _id)

    @staticmethod
    def cq_anonymous(ignore=False) -> str:
        """
        匿名发消息（anonymous），仅支持群

        :param ignore: 是否不强制，默认为 False。如果希望匿名失败时，将消息转为普通消息发送（而不是取消发送），请置本参数为 True
        :rtype: str
        :return: CQ码_匿名
        """
        return '[CQ:anonymous,ignore=true]' if ignore else '[CQ:anonymous]'

    @classmethod
    def cq_image(cls, path) -> str:
        """
        CQ码_图片(image)

        :param path: 图片路径，可使用网络图片和本地图片．使用本地图片时需在路径前加入 file://
        :rtype: str
        :return: CQ码_图片
        """
        return '[CQ:image,file=%s]' % cls.escape(path, True)

    @classmethod
    def cq_location(cls, lat, lon, title, content, zoom=15) -> str:
        """
        取CQ码_位置分享(location)

        :param lat: 纬度
        :param lon: 经度
        :param title: 地点名称，建议12字以内
        :param content: 地址，建议20字以内
        :param zoom: 放大倍数，可空，默认为 15
        :rtype: str
        :return: CQ码_位置分享
        """
        title = cls.escape(title, True)
        content = cls.escape(content, True)
        return '[CQ:location,lat=%f,lon=%f,zoom=%d,title=%s,content=%s]' % (lat, lon, zoom, title, content)

    @classmethod
    def cq_music(cls, song_id, _type='qq', new_style=False) -> str:
        """
        取CQ码_音乐(music)

        :param song_id: 音乐的歌曲数字ID
        :param _type: 音乐网站类型，目前支持 qq/QQ音乐 163/网易云音乐 xiami/虾米音乐，默认为qq
        :param new_style: 是否启用新版样式，目前仅 QQ音乐 支持
        :rtype: str
        :return: CQ码_音乐
        """
        _type = cls.escape(_type, True)
        new_style = new_style and '1' or '0'
        return '[CQ:music,id=%d,type=%s,style=%s]' % (song_id, _type, new_style)

    @classmethod
    def cq_custom_music(cls, url, audio, title='', content='', image='') -> str:
        """
        取CQ码_音乐自定义分享(music)

        :param url: 分享链接，点击分享后进入的音乐页面（如歌曲介绍页）
        :param audio: 音频链接，音乐的音频链接（如mp3链接）
        :param title: 标题，可空，音乐的标题，建议12字以内
        :param content: 内容，可空，音乐的简介，建议30字以内
        :param image: 封面图片链接，可空，音乐的封面图片链接，留空则为默认图片
        :rtype: str
        :return: CQ码_音乐自定义分享
        """
        url = cls.escape(url, True)
        audio = cls.escape(audio, True)
        msg = '[CQ:music,type=custom,url=%s,audio=%s' % (url, audio)
        if title.strip():
            msg += ',title=' + cls.escape(title, True)
        if content.strip():
            msg += ',content=' + cls.escape(content, True)
        if image.strip():
            msg += ',image=' + cls.escape(image, True)
        return msg + ']'

    @classmethod
    def cq_record(cls, path) -> str:
        """
        取CQ码_语音(record)

        :param path: 语音路径，可使用网络和本地语音文件．使用本地语音文件时需在路径前加入 file://
        :rtype: str
        :return: CQ码_语音
        """
        return '[CQ:record,file=%s]' % cls.escape(path, True)

    @staticmethod
    def cq_big_face(p_id, _id) -> str:
        """
        取CQ码_大表情(bface)

        :param p_id: 大表情所属系列的标识
        :param _id: 大表情的唯一标识
        :rtype: str
        :return: CQ码_大表情
        """
        return '[CQ:bface,p=%d,id=%d]' % (p_id, _id)

    @staticmethod
    def cq_small_face(_id) -> str:
        """
        取CQ码_小表情(sface)

        :param _id: 小表情代码
        :rtype: str
        :return: CQ码_小表情
        """
        return '[CQ:sface,id=%d]' % _id

    @classmethod
    def cq_show(cls, _id, qq=0, content='') -> str:
        """
        取CQ码_厘米秀(show)

        :param _id: 动作代码
        :param qq: 动作对象，可空，仅在双人动作时有效
        :param content: 消息内容，建议8个字以内
        :rtype: str
        :return: CQ码_厘米秀
        """
        msg = '[CQ:show,id=%d' % _id
        if qq > 0:
            msg += ',qq=%d' % qq
        if content.strip():
            msg += ',content=' + cls.escape(content, True)
        return msg + ']'
    pass


class CoreCoolQ (StaticCoolQ):
    """
        动态API与静态API混合版

        若API返回状态码，状态码为0时表示成功
        若API返回数组，
            则数组成员[Status]的值表示状态码，
            状态码为0时表示成功
            状态码为负值时表示失败，部分情况下存在表示错误原因的成员errmsg，
            若不存在成员errMsg，则参考酷Q官方文库：
                *http://d.cqp.me/Pro/%E5%BC%80%E5%8F%91/Error
            若因网络因素无法成功调用API，则状态码[Status]为 -504
        如果不使用动态交互，即使用静态API，则部分API无法使用，此部分API调用时返回状态码 -501
    """
    __slots__ = ('host', 'port', 'key', 'time')

    def __init__(self, host='', port=80, key='', time=30):
        """

        :param host: 酷Q所在的主机的ip
        :param port: 插件端的监听端口
        :param key:
        :param time:
        """
        self.host = host
        self.port = port
        self.key = key
        self.time = time

    def __del__(self):
        print("\n[]")

    @staticmethod
    def get_http_data(host, port, data, time_out=8):
        import socket
        client = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        socket.setdefaulttimeout(time_out)
        try:
            client.connect((host, port))
        except (RuntimeError, TypeError, NameError):
            return ''
        data = "POST / HTTP 1.1\r\nHOST: %s\r\n\r\n%s" % (host, data)
        data = bytes(data, encoding='utf-8')
        try:
            client.sendall(data)
        except (RuntimeError, TypeError, NameError):
            return ''
        try:
            data = client.recv(1048560)
        except (RuntimeError, TypeError, NameError):
            return ''
        client.close()
        data = str(data, encoding="utf-8")
        data = data[data.find('\r\n\r\n')+4:]
        return data

    def get_source(self, _type, source, _format=''):
        array = self.new_array(_type)
        array['source'] = source
        if _format.strip():
            array['format'] = _format
        return self.send_data(array)

    @staticmethod
    def new_array(_type, group_id=0, qq=0, msg=''):
        array = dict(fun=_type)
        if group_id > 0:
            array['group'] = group_id
        if qq > 0:
            array['qq'] = qq
        if msg.strip():
            array['msg'] = msg
        return array

    def send_data(self, array, time_out=8) -> dict:
        import json
        from datetime import datetime
        if not self.host.strip():
            import re
            if re.match(r'(send|set|addLog|rebootService)', array['fun']):
                print(json.dumps(array))
                return dict(status=0)
            return dict(status=-501, errmsg='因策略原因，无法调用此API')
        if self.key.strip():
            import hashlib
            time = int(datetime.now().timestamp())
            array['authTime'] = time
            md5 = hashlib.md5()
            string = bytes('%s:%d' % (self.key, time), encoding='utf-8')
            md5.update(string)
            array['authToken'] = md5.hexdigest()
        data = self.get_http_data(self.host, self.port, json.dumps(array), time_out)
        array = json.loads(data)
        if len(array):
            return array
        return dict(status=-504, errmsg='无法连接到服务端')

    def send_msg(self, _type, group_id=0, qq=0, msg=''):
        array = self.new_array(_type, group_id, qq, msg)
        array = self.send_data(array)
        return array['status']

    def get_no_param_return(self, _type):
        return self.send_data(dict(fun=_type))

    def receive(self, array):
        if self.key.strip():
            if 'authTime' in array and 'authToken' in array:
                time = array['authTime']
                if isinstance(time, str):
                    time = int(time)
                from datetime import datetime
                now_time = int(datetime.now().timestamp())
                if now_time - time <= self.time:
                    token = array['authToken'].tolow()
                    import hashlib
                    md5 = hashlib.md5()
                    true_token = bytes('%s:%d' % (self.key, time), encoding='utf-8')
                    md5.update(true_token)
                    true_token = md5.hexdigest()
                    if token == true_token:
                        array['authTime'].remove()
                        array['authToken'].remove()
                    else:
                        return dict()
                else:
                    return dict()
            else:
                return dict()
        return array

    pass


class GetCoolQ (CoreCoolQ):

    def get_anonymous_info(self, source: str) -> object:
        """
        取匿名成员信息

        :param source: 匿名成员的标识
        :return: 成功时，数组中成员Status的值为0，并在成员Result中返回：该匿名成员的信息
        """
        return self.get_source('get_anonymous_info', source)

    def get_auth_info(self) -> object:
        """
        获取权限信息

        :rtype: object
        :return: 成功时，数组中成员Status的值为0，并在成员Result中返回：AuthCode，Cookies，CsrfToken
        """
        array = self.get_no_param_return('getAuthCode')
        return int(array['result'] if not array['status'] else array['status'])

    def get_ban_list(self, group_id) -> object:
        """
        取指定群中被禁言用户列表

        :auth: 20
        :param group_id: 目标群
        :rtype: object
        :return: 成功时，数组中成员Status的值为0，并在成员Result中返回：该群中被禁言的用户列表
        """
        arr = self.new_array('getBanList', group_id)
        return self.send_data(arr)

    def get_file_info(self, source) -> object:
        """
        取文件信息

        :param source: 文件标识
        :rtype: object
        :return: 成功时，数组中成员Status的值为0，并在成员Result中返回：该文件的文件属性
        """
        return self.get_source('get_file_info', source)

    def get_friend_list(self) -> object:
        """
        取好友列表

        :rtype: object
        :return: 成功时，数组中成员Status的值为0，并在成员Result中返回：当前机器人所加的好友信息列表
        """
        return self.get_no_param_return('get_friend_list')

    def get_group_info(self, group_id) -> object:
        """
        取群详细信息

        :auth: 20
        :param group_id: 目标群
        :return: 成功时，数组中成员Status的值为0，并在成员Result中返回：该群的详细信息
        """
        array = self.new_array('get_group_info', group_id)
        return self.send_data(array)

    def get_group_top_note(self, group_id) -> object:
        """
        取群置顶公告

        :auth: 20
        :param group_id: 目标群
        :return: 成功时，数组中成员Status的值为0，并在成员Result中返回：该群的置顶公告(本群须知)信息
        """
        array = self.new_array('get_group_top_note', group_id)
        return self.send_data(array)

    def get_image_info(self, path, need_file=True) -> object:
        """
        取图片信息

        :param path: 图片文件名，不带路径，并且必须是酷Q收到的图片
        :param need_file: 回传文件内容，True/回传，False/不回传
        :return: 成功时，数组中成员Status的值为0，并在成员Result中返回：该图片信息
        """
        array = dict(fun='get_image_info', source=path, needFile=need_file)
        return self.send_data(array)

    def get_group_homework_list(self, group_id) -> object:
        """
        取群作业列表

        :auth: 20
        :param group_id: 目标群
        :return: 成功时，数组中成员Status的值为0，并在成员Result中返回：该群的作业列表(不存在未指定给机器人查看的作业)
        """
        array = self.new_array('get_group_homework_list', group_id)
        return self.send_data(array)

    def get_group_link_list(self, group_id, number=10) -> object:
        """
        取群链接列表

        :auth: 20
        :param group_id: 目标群
        :param number: 数量，默认20
        :return: 成功时，数组中成员Status的值为0，并在成员Result中返回：在该群中发过的链接列表
        """
        array = self.new_array('get_group_link_list', group_id)
        array['number'] = number
        return self.send_data(array)

    def get_group_list(self) -> object:
        """
        取群列表

        :auth: 161
        :return: 成功时，数组中成员Status的值为0，并在成员Result中返回：目前机器人所加入的群列表信息
        """
        return self.get_no_param_return('get_group_list')

    def get_group_member_info(self, group_id, qq, use_cache=True) -> object:
        """
        取群成员信息

        :auth: 130
        :param group_id:
        :param qq: 目标QQ
        :param use_cache: 使用缓存，True/使用 False/不使用，默认为 True
        :return: 成功时，数组中成员Status的值为0，并在成员Result中返回：该群指定群成员的个人信息
        """
        array = self.new_array('getGroupMemberInfo', group_id, qq)
        array['cache'] = 1 if use_cache else 0
        return self.send_data(array)

    def get_group_member_list(self, group_id) -> object:
        """
        取群成员列表

        :auth: 160
        :rtype: object
        :param group_id: 目标群
        :return: 成功时，数组中成员Status的值为0，并在成员Result中返回：该群的群成员列表
        """
        array = self.new_array('get_group_member_list', group_id)
        return self.send_data(array)

    def get_group_note_list(self, group_id, number=10) -> object:
        """
        取群公告列表

        :param number:
        :auth: 20
        :param group_id: 目标群
        :param number: 公告数量，默认 10
        :rtype: object
        :return: 成功时，数组中成员Status的值为0，并在成员Result中返回：该群的公告列表
        """
        array = self.new_array('get_group_note_list', group_id)
        array['number'] = number
        return self.send_data(array)

    def get_login_info(self) -> object:
        """
        取登录QQ的信息

        该API可能需要获取Cookies权限
        :auth: 20
        :rtype: object
        :return: 当前登录QQ的相关信息
        """
        return self.get_no_param_return('get_login_info')

    def get_more_group_headimg(self, group_list='') -> object:
        """
        批量取群头像

        :auth: 20,161
        :param group_list: 群列表，每个群用 - 分开，可空，参数值为空时，取所有群的头像
        :rtype: object
        :return: 成功时，数组中成员Status的值为0，并在成员Result中返回：所提供的群号的头像链接列表
        """
        return self.send_data(dict(fun='get_more_group_headimg', groupList=group_list))

    def get_more_qq_info(self, qq_list) -> object:
        """
        批量取QQ信息

        :auth: 20
        :param qq_list: QQ列表，每个QQ用 - 分开
        :rtype: object
        :return: 成功时，数组中成员Status的值为0，并在成员Result中返回：所提供的QQ的昵称列表
        """
        array = dict(fun='get_more_qq_info', qqList=qq_list)
        return self.send_data(array)

    def get_record(self, file_name, _format='mp3', need_file=True) -> object:
        """
        接收消息中的语音(record)

        :auth: 30
        :param file_name: 文件名，收到消息中的语音文件名(file)
        :param _format: 转码成何种音频文件，目前支持 mp3,amr,wma,m4a,spx,ogg,wav,flac，默认 mp3
        :param need_file: 回传文件，True/回传，False/不回传
        :rtype: object
        :return: 成功时，数组中成员Status的值为0，并在成员Result中返回：解析该文件后，保存在 \data\record\ 目录下的语音文件名
        """
        array = dict(fun='getRecord', source=file_name, format=_format, needFile=need_file)
        array = self.send_data(array)
        return array

    def get_run_status(self, time=3) -> bool:
        """
        取运行状态

        向服务端发送一条消息，确认是否奔溃

        :param time: 最长等待时间，单位/秒，默认3秒
        :rtype: bool
        :return: 运行正常返回 True，奔溃情况下返回 False
        """
        array = self.send_data(dict(fun='check_run'), time)
        return True if not array['status'] else False

    def get_share_list(self, group_id) -> object:
        """
        取群文件列表

        :auth: 20
        :param group_id: 目标群
        :rtype: object
        :return: 成功时，数组中成员Status的值为0，并在成员Result中返回：该群的群文件信息列表
        """
        arr = self.new_array('get_share_list', group_id)
        return self.send_data(arr)

    def get_sign_list(self, group_id):
        """
        取群签到列表

        :auth: 20
        :param group_id: 目标群
        :rtype: object
        :return: 成功时，数组中成员Status的值为0，并在成员Result中返回：该群的群签到信息
        """
        arr = self.new_array('getSignList', group_id)
        return self.send_data(arr)

    def get_stranger_info(self, qq, use_cache=True):
        """
        取陌生人信息

        :auth: 131
        :param qq: 目标QQ
        :param use_cache: 使用缓存，True/使用 False/不使用，默认为 True
        :return: 成功时，数组中成员Status的值为0，并在成员Result中返回：该QQ的部分个人信息
        """
        arr = self.new_array('getStrangerInfo', 0, qq)
        arr['cache'] = 1 if use_cache else 0
        return self.send_data(arr)

    def get_version(self):
        """
        取版本信息

        :return: 成功时，数组中成员Status的值为0，并在成员Result中返回：酷Q版本(air/pro)、插件版本
        """
        return self.get_no_param_return('getVersion')

    pass


class SendCoolQ (GetCoolQ):

    def send_discuss_msg(self, group, msg) -> int:
        """
        发送讨论组信息

        :auth: 103
        :param group: 目标讨论组
        :param msg: 消息内容
        :rtype: int
        :return: 状态码
        """
        return self.send_msg('send_discuss_msg', group, 0, msg)

    def send_flower(self, group, qq) -> int:
        """
        送花

        :auth: 103
        :param group: 目标群
        :param qq: QQ号
        :rtype: int
        :return: 状态码
        """
        return self.send_msg('send_flower', group, qq)

    def send_group_msg(self, group, msg) -> int:
        """
        发送群消息

        :auth: 101
        :param group: 目标群
        :param msg: 消息内容
        :rtype: int
        :return: 状态码
        """
        return self.send_msg('send_group_msg', group, 0, msg)

    def send_like(self, qq, count=1) -> int:
        """
        发送名片赞

        :auth: 110
        :param qq: 目标QQ
        :param count: 赞的次数，最多10次，默认为1次，平板协议只能赞一次
        :rtype: int
        :return: 状态码
        """
        array = self.new_array('send_like', 0, qq)
        array['number'] = count
        array = self.send_data(array)
        return array['status']

    def send_private_msg(self, qq, msg):
        """
        发送私聊信息

        :auth: 106
        :param qq: 目标QQ
        :param msg: 消息内容
        :rtype: int
        :return: 状态码，0为成功
        """
        return self.send_msg('send_private_msg', 0, qq, msg)

    pass


class SetCoolQ (SendCoolQ):

    def set_discuss_leave(self, group) -> int:
        """
        置讨论组退出

        :auth: 140
        :param group: 目标讨论组号
        :rtype: int
        :return: 状态码，0为成功
        """
        array = self.new_array('set_discuss_leave', group)
        return array['status']

    def set_friend_add_request(self, response_flag, sub_type, name='') -> int:
        """
        置好友添加请求

        :auth: 150
        :param response_flag: 反馈标识，请求事件收到的"$responseFlag"参数
        :param sub_type: 反馈类型，1/通过 2/拒绝
        :param name: 添加后的好友备注
        :rtype: int
        :return: 状态码，0为成功
        """
        array = dict(fun='set_friend_add_request', responseFlag=response_flag, subType=sub_type, name=name)
        array = self.send_data(array)
        return array['status']

    def set_group_add_request(self, response_flag, sub_type, _type, msg='') -> int:
        """
        置群添加请求

        :auth: 151
        :param response_flag: 反馈标识，请求事件收到的"$responseFlag"参数
        :param sub_type: 请求类型，1/群添加 2/群邀请
        :param _type: 反馈类型，1/通过 2/拒绝
        :param msg: 操作理由，可空，仅 群添加 & 拒绝 情况下有效
        :rtype: int
        :return: 状态码，0为成功
        """
        array = dict(fun='set_group_add_request', responseFlag=response_flag, subType=sub_type, type=_type, msg=msg)
        array = self.send_data(array)
        return array['status']

    def set_group_admin(self, group, qq, become=False) -> int:
        """
        置群管理员

        :auth: 122
        :param group: 目标所在群
        :param qq: 目标QQ
        :param become: 操作类型，True/设置管理员 False/取消管理员
        :rtype: int
        :return: 状态码，0为成功
        """
        array = self.new_array('set_group_admin', group, qq)
        array['become'] = become
        array = self.send_data(array)
        return array['status']

    def set_group_anonymous(self, group, _open=False) -> int:
        """
        置群匿名设置

        :auth: 125
        :param group: 目标群
        :param _open: 操作类型，True/开启匿名 False/关闭匿名
        :rtype: int
        :return: 状态码
        """
        array = self.new_array('set_group_anonymous', group)
        array['open'] = _open
        array = self.send_data(array)
        return array['status']

    def set_group_anonymous_ban(self, group, anonymous, time) -> int:
        """
        置匿名群员禁言

        :auth: 124
        :param group: 目标所在群
        :param anonymous: 匿名标识，群消息事件收到的"$fromAnonymous"参数
        :param time: 禁言时间，单位为秒。不支持解禁
        :rtype: int
        :return: 状态码
        """
        array = self.new_array('set_group_anonymous_ban', group)
        array['anonymous'] = anonymous
        array['time'] = time
        array = self.send_data(array)
        return array['status']

    def set_group_ban(self, group, qq, time=0) -> int:
        """
        置群成员禁言

        :auth: 121
        :param group: 目标所在群
        :param qq: 目标QQ
        :param time: 禁言的时间，单位为秒，可空。如果要解禁，这里填写 0；不得超过 2592000 (一个月)
        :rtype: int
        :return: 状态码
        """
        array = self.new_array('set_group_ban', group, qq)
        array['time'] = time
        array = self.send_data(array)
        return array['status']

    def set_group_card(self, group, qq, card=''):
        """
        置群成员名片

        :auth: 126
        :param group: 目标所在群
        :param qq: 目标QQ
        :param card: 新名片
        :rtype: int
        :return: 状态码
        """
        array = self.new_array('set_group_card', group, qq)
        array['card'] = card
        array = self.send_data(array)
        return array['status']

    def set_group_leave(self, group, disband=False) -> int:
        """
        置群退出

        :auth； 127
        :param group: 操作类型
        :param disband: 操作类型，True/解散本群(群主) False/退出本群(管理、群成员)，默认为 False
        :rtype: int
        :return: 状态码
        """
        array = self.new_array('set_group_leave', group)
        disband = disband
        array['disband'] = disband
        array = self.send_data(array)
        return array['status']

    def set_group_kick(self, group, qq, refuse_join=False) -> int:
        """
        置群成员移除

        :auth: 120
        :param group: 目标群
        :param qq: 目标QQ
        :param refuse_join: 拒绝再加群，True/不再接收此人加群申请，默认为 False
        :rtype: int
        :return: 状态码
        """
        array = self.new_array('set_group_kick', group, qq)
        array['refuseJoin'] = refuse_join
        array = self.send_data(array)
        return array['status']

    def set_group_sign(self, group=0) -> int:
        """
        置群签到

        :auth: 20,161
        :param group: 群号，可空，空时签到所有群
        :rtype: int
        :return: 成功时，数组中成员Status的值为 0，并在成员Result中返回：本次签到成功的群数量
        """
        array = self.new_array('set_group_sign', group)
        array = self.send_data(array)
        return array['status']

    def set_group_special_title(self, group, qq, tip='', time=-1) -> int:
        """
        置群头衔

        :auth: 128
        :param group: 目标所在群
        :param qq: 目标QQ
        :param tip: 头衔，可空。如果要删除，这里填空
        :param time: 专属头衔有效期，单位为秒，可空。如果永久有效，这里填写-1
        :rtype: int
        :return: 状态码
        """
        arr = self.new_array('set_group_special_title', group, qq)
        arr['tip'] = tip
        arr['time'] = time
        arr = self.send_data(arr)
        return arr['status']

    def set_group_whole_ban(self, group, _open=False) -> int:
        """
        置全群禁言

        :auth: 123
        :param group: 目标群
        :param _open: 开启禁言，True/开启 False/关闭，默认为 False
        :rtype: int
        :return: 状态码
        """
        arr = self.new_array('set_group_whole_ban', group)
        arr['open'] = _open
        arr = self.send_data(arr)
        return arr['status']

    def set_sign(self) -> object:
        """
        置QQ打卡

        调用此API时，需要机器人QQ完成财付通实名认证

        :auth: 20
        :return: 成功时，数组中成员Status的值为 0，并在成员Result中返回：本次签到的额外信息
        """
        return self.get_no_param_return('set_sign')

    def set_status(self, data, unit, color) -> str:
        """
        置悬浮窗信息

        :param data: 数据内容
        :param unit: 数据单位
        :param color: 颜色，1/绿 2/橙 3/红 4/深红 5/黑 6/灰
        :return: 悬浮窗文本，无用
        """
        array = dict(fun='set_status', data=data, unit=unit, color=color)
        array = self.send_data(array)
        return array['result'] if not array['status'] else ''

    pass


class CoolQ (SetCoolQ):
    # 日志_调试
    log_debug = 0
    # 日志_信息
    log_info = 10
    # 日志_信息_成功
    log_infoSuccess = 11
    # 日志_信息_接收
    log_infoReceive = 12
    # 日志_信息_发送
    log_infoSend = 13
    # 日志_警告
    log_warming = 20
    # 日志_错误
    log_error = 30
    # 日志_致命错误
    log_fatal = 40

    def add_log(self, level=0, _type='', text='') -> int:
        """
        添加日志

        :param level: 优先级，请使用 log_ 开头的常量，如 cq.log_debug
        :param _type: 日志类型
        :param text: 日志内容
        :rtype: int
        :return: 成功时，数组中成员Status的值为0，Result为日志ID
        """
        arr = dict(fun='addLog', level=level, type=_type, text=text)
        arr = self.send_data(arr)
        return int(arr['result']) if not arr['status'] else arr['status']

    def down_file(self, url, name='', _type=1, md5='') -> object:
        """
        下载文件

        :param url: 文件的URL地址
        :param name: 文件名，可空，为空时使用md5值
        :param _type: 文件类型，可空，1/图片 2/语音，默认为 1
        :param md5: 传入32位小写的文件校验码，可空，未传入时不校验文件
        :rtype: object
        :return: 成功时，数组中成员Status的值为0，Result为文件的相对路径
        """
        arr = dict(fun='down_file', url=url, name=name, type=_type, md5=md5)
        return self.send_data(arr)

    def reboot_service(self):
        """
        重启服务

        需先创建快速登录文件
        当酷Q崩溃(指无响应)时无法使用
        此API执行成功时状态码为-2
        :return:
        """
        return self.get_no_param_return('reboot_service')
    pass
