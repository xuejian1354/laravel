#!/bin/bash

/home/easydarwin/easydarwin -c /home/easydarwin/easydarwin.xml
/usr/local/bin/forever start -a -l /home/sam/js/node-forever.log -o /home/sam/js/node-out.log -e /home/sam/js/node-err.log /home/sam/js/wsservice.js
