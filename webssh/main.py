__author__ = 'xsank'
__editor__ = 'xuejian1354'

import os.path

import tornado.ioloop
import tornado.web
import tornado.httpserver
import tornado.options
from tornado.options import options

from config import init_config
from urls import handlers
from ioloop import IOLoop


settings = dict(
    template_path=os.path.join(os.path.dirname(__file__), "templates"),
    static_path=os.path.join(os.path.dirname(__file__), "static"),
)


class Application(tornado.web.Application):

    def __init__(self):
        tornado.web.Application.__init__(self, handlers, **settings)


def welcome():
    print '''
Welcome to the webssh!
                __              __
 _      _____  / /_  __________/ /_
| | /| / / _ \/ __ \/ ___/ ___/ __ \\
| |/ |/ /  __/ /_/ (__  |__  ) / / /
|__/|__/\___/_.___/____/____/_/ /_/

Webssh now start~
Please visit the localhost:9527 from the explorer~
    '''


def main():
    init_config()
    options.parse_config_file("webssh.conf")

    http_server = tornado.httpserver.HTTPServer(Application())
    http_server.listen(options.port)
    IOLoop.instance().start()
    welcome()
    tornado.ioloop.IOLoop.instance().start()


if __name__ == "__main__":
    main()
