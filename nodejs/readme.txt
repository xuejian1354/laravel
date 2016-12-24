npm install forever -g
npm install forever-monitor
npm install hashmap ws socket.io redis express fluent-ffmpeg fs node-schedule serialport
forever start -a -l node-forever.log -o node-out.log -e node-err.log wsservice.js
forever stop wsservice.js
