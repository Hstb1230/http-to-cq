#!/usr/bin/python
# -*- coding:utf-8 -*-
import mysql.connector as mysql

mySQLConfig = {
    "host": "localhost",
    "user": 'root',
    'password': '1233211235',
    'database': 'fuck',
    'charset': 'utf8'
}


def SQLLog(txt):
    '''
    日志 以后拓展
    :param txt:
    :return:
    '''
    print(txt)




class ezSQL:



    @staticmethod
    def SQLQuery(table,par="*",where="",like=""):
        '''
        执行查询语句,返回查询结果
        :param table:欲查询的table
        :param par:欲查询的参数,不写则是所有
        :param where:有where语句 写在这里
        :param like:有like语句 写在这里
        :return: 查询的结果 用for循环导出来
        '''

        #mysql连接的基本信息


        #try 判断是否连接成功
        try:
            conn = mysql.connect(**mySQLConfig)
        except mysql.Error as e:
            SQLLog('MySQL Error .{}'.format(e))

        #编写SQL查询语句
        sql = 'select {par} from {table}'.format(par=par,table=table)
        if where !="":
            sql += ' where {}'.format(where)


        if like !="":
            sql += ' like {}'.format(like)

        cursot = conn.cursor()

        try:
            SQLLog('ezSQL : 执行查询语句: ' + sql)
            cursot.execute(sql)
        except mysql.Error as e:
            SQLLog('MySQL Error. {}'.format(e))
        finally:
            # cursot.close()
            #print(cursot.fetchall())
            #fet = cursot.fetchall()
            conn.close()
            # data = []
            # for a,b,c in cursot:
            #     data.append([a,b,c])
            return cursot.fetchall()

    @staticmethod
    def createSQL(table,values):
        '''
        用于创建SQL table
        :return:
        '''

        conn = mysql.connect(**mySQLConfig)
        cursor = conn.cursor()

        if ezSQL.likeSQL(table) == False:
            # table 不存在 创建table
            sql = "create table {table} {values}".format(table=table,values=values)
            try:
                SQLLog("ezSQL: 创建table: " + sql)
                cursor.execute(sql)
            except mysql.Error as e:
                SQLLog("MySQL Error :" + e)
            finally:
                conn.close()
                return True
        else:
            conn.close()

            return True

    @staticmethod
    def likeSQL(table):
        '''
        用于判断SQL table是否存在
        :param table: table的名字
        :return: Ture or False
        '''
        conn = mysql.connect(**mySQLConfig)
        cursor = conn.cursor()
        #判断table是否存在
        sql = "show tables like '{table}'".format(table=table)
        SQLLog("ezSQL: 判断table: " + sql)
        cursor.execute(sql)

        vua = [i for i in cursor.fetchall()]
        if len(vua) == 1:
            #表示 talble 存在
            conn.close()
            return True
        else:
            conn.close()
            return False

    @staticmethod
    def insSQL(table,values):
        '''
        用于向table中插入一段数据
        :param table:
        :param values:
        :return:
        '''
        conn = mysql.connect(**mySQLConfig)
        cursor = conn.cursor()

        sql = "insert into {table} values {values}".format(table=table,values=values)
        try:
            SQLLog("ezSQL: 插入数据: " + sql)

            cursor.execute(sql)
            conn.commit()

        except mysql.Error as e:
            SQLLog("MySQL Error :" + e)
        finally:
            conn.close()
            return True





