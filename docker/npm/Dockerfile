FROM node:20-alpine3.18

ENV LC_ALL=C.UTF-8 \
    LANG=en_US.UTF-8 \
    LANGUAGE=en_US.UTF-8
ENV PATH /var/www/html/node_modules/.bin:$PATH

WORKDIR /var/www/html

COPY ./src/package.json /var/www/html/package.json
COPY ./src/grunt-config.json /var/www/html/grunt-config.json
COPY ./src/Gruntfile.js /var/www/html/Gruntfile.js
COPY ./docker/npm/watcher.sh /usr/bin/grunt-watcher
RUN chmod +x /usr/bin/grunt-watcher

RUN npm install --save-dev
RUN npm install -g grunt-cli grunt bower --save-dev

CMD ["grunt-watcher"]
