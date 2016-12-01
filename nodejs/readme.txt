npm install forever -g
npm install forever-monitor
npm install hasmap ws socket.io redis express fluent-ffmpeg fs
forever start -a -l /var/log/node-forever.log -o /var/log/node-out.log -e /var/log/node-err.log wsservice.js
forever stop wsservice.js
