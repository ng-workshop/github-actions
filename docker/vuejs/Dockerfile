FROM node:16-alpine

ARG GROUP_ID=1000
ARG USER_ID=1000

ENV YARN_FOLDER=/home/node/.yarn
ENV YARN_CACHE_FOLDER=${YARN_FOLDER}/cache
ENV NPM_FOLDER=/home/node.npm

ADD ./entrypoint.sh /usr/local/bin/docker-vuejs-entrypoint.sh

RUN apk update \
    && apk add --no-cache \
      shadow \
      sudo \
    && usermod --login vuejs node \
    && groupmod --new-name vuejs node \
    && echo "%vuejs ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers.d/vuejs \
    && passwd --lock root \
    && passwd --delete root \
    && mkdir --parents ${YARN_FOLDER} ${NPM_FOLDER} \
    && yarn config set cache-folder ${YARN_CACHE_FOLDER} \
    && chmod a+x /usr/local/bin/docker-vuejs-entrypoint.sh \
    && chown --recursive vuejs:vuejs ${YARN_FOLDER} ${NPM_FOLDER} /usr/local/bin/docker-vuejs-entrypoint.sh \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/*

WORKDIR /var/www/vuejs

USER vuejs

RUN yarn global add @vue/cli

EXPOSE 8080

ENTRYPOINT ["/usr/local/bin/docker-vuejs-entrypoint.sh"]

CMD ["sh", "-c", "yarn && yarn serve"]
