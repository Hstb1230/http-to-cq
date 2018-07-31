#!/usr/bin/python
# -*- coding:utf-8 -*-
from plugin import cq_class
import time
from plugin import SQL
import configparser
import os
import sys
print(sys.path)

ini = configparser.ConfigParser
ezSQL = SQL.ezSQL()
cq = cq_class.CoolQ()

signTable = "sign"
signTableValues = "(qq int, qqgroup int, time text)"

class Sign(object):
    '''
    签到Class
    '''

    def __init__(self):
        Sign.createSignSQL()
        if os.path.exists("ini/sign") == False:
            os.makedirs("ini/sign")




    @staticmethod
    def createSignSQL():
        if ezSQL.likeSQL(signTable) == False:
            ezSQL.createSQL(signTable,signTableValues)

    @staticmethod
    def nowSign(qq,group,msg,type):
        if msg == "签到":
            return "签到成功！" + cq.cq_at(qq) + Sign.getSignTime() + "\n 下次签到时间:" + Sign.getSignTime(time.localtime(time.time()+86400))
        return ""

    @staticmethod
    def getSignTime(Datatime=None):
        '''

        用于格式化时间

        :param Datatime:时间数据
        :return:格式化后的时间,只有年月日
        '''
        if Datatime == None:
            Datatime = time.localtime()
        nowTime = time.strftime("%Y/%m/%d", Datatime)
        # print(time.strftime("%Y-%m-%d %H:%M %p", time.localtime()))
        return nowTime

    @staticmethod
    def userSign(qq,group,split=True):
        '''
        判断QQ是否在这个群签到了
        :param qq: 签到者的QQ
        :param group: 签到者所在的群号
        :param split: True 为不分群
        :return:真or假
        '''

        if(split == True):
            # 代表不分群
            data = ezSQL.SQLQuery(signTable,"qq,time","qq = {qq} and time = \"{time}\" ".format(qq=qq,time=Sign.getSignTime()))
            data = [data for data in data]
            if len(data) == 0:
                #代表今天还未签到
                ezSQL.insSQL(signTable,"({qq},{group},\"{time}\")".format(qq=qq,group=group,time=Sign.getSignTime()))










sign = Sign()
sign.userSign("524","6666")





