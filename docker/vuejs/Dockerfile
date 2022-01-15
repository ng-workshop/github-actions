FROM node:16-alpine

ARG GROUP_ID=1000
ARG USER_ID=1000

ENV HOME=/home/node
ENV YARN_FOLDER=${HOME}/.yarn
ENV YARN_CACHE_FOLDER=${YARN_FOLDER}/cache
ENV NPM_FOLDER=${HOME}/.npm
ENV ENV=/etc/profile

ADD ./entrypoint.sh /usr/local/bin/docker-vuejs-entrypoint.sh

RUN apk add --update --no-cache shadow sudo \
    && usermod --login vuejs node \
    && groupmod --new-name vuejs node \
    && echo "%vuejs ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers.d/vuejs \
    && passwd --lock root \
    && passwd --delete root \
    && mkdir --parents ${YARN_FOLDER} ${NPM_FOLDER} \
    && yarn config set cache-folder ${YARN_CACHE_FOLDER} \
    && chmod a+x /usr/local/bin/docker-vuejs-entrypoint.sh \
    && chown --recursive vuejs:vuejs ${YARN_FOLDER} ${NPM_FOLDER} /usr/local/bin/docker-vuejs-entrypoint.sh \
    && echo 'PATH="${PATH:+$PATH:}/home/node/.config/yarn/global/node_modules/.bin/"' >> /etc/profile \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/*

WORKDIR /var/www/vuejs

USER vuejs

RUN yarn global add @vue/cli

EXPOSE 8080

ENTRYPOINT ["/usr/local/bin/docker-vuejs-entrypoint.sh"]

CMD ["sh", "-c", "yarn && yarn serve"]
