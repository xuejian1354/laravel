__author__ = 'xsank'

from handlers import *


handlers = [
    (r"/", TerminalHandler),
    (r"/ws", WSHandler)
]
