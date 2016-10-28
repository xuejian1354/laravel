npm install forever -g
npm install forever-monitor
npm install hashmap
npm install mysql
npm install ws
npm install socket.io
forever start -a -l /var/log/node-forever.log -o /var/log/node-out.log -e /var/log/node-err.log wsservice.js
forever stop wsservice.js
