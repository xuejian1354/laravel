npm install forever -g
npm install forever-monitor
npm install hasmap ws socket.io redis express fluent-ffmpeg fs
forever start -a -l node-forever.log -o node-out.log -e node-err.log wsnode.js
forever stop wsservice.js
