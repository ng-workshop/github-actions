FROM node:16

ARG GROUP_ID=1000
ARG USER_ID=1000

ENV HOME=/home/node
ENV YARN_FOLDER=${HOME}/.yarn
ENV YARN_CACHE_FOLDER=${YARN_FOLDER}/cache
ENV NPM_FOLDER=${HOME}/.npm

ADD ./entrypoint.sh /usr/local/bin/docker-vuejs-entrypoint.sh

RUN apt-get update \
    && apt-get install --assume-yes \
      libasound2 \
      libgbm-dev \
      libgconf-2-4 \
      libgtk2.0-0 \
      libgtk-3-0 \
      libnotify-dev \
      libnss3 \
      libxss1 \
      libxtst6 \
      sudo \
      xauth \
      xvfb \
    && usermod --login vuejs node \
    && groupmod --new-name vuejs node \
    && echo "%vuejs ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers.d/vuejs \
    && mkdir -p ${YARN_FOLDER} ${NPM_FOLDER} \
    && yarn config set cache-folder ${YARN_CACHE_FOLDER} \
    && chmod a+x /usr/local/bin/docker-vuejs-entrypoint.sh \
    && chown --recursive vuejs:vuejs ${YARN_FOLDER} ${NPM_FOLDER} /usr/local/bin/docker-vuejs-entrypoint.sh \
    && echo 'PATH="${PATH:+$PATH:}/home/node/.config/yarn/global/node_modules/.bin/"' >> ${HOME}/.bashrc \
    && apt-get autoclean \
    && apt-get autoremove \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /tmp/*

WORKDIR /var/www/vuejs

USER vuejs

RUN yarn global add @vue/cli

EXPOSE 8080

ENTRYPOINT ["/usr/local/bin/docker-vuejs-entrypoint.sh"]

CMD ["sh", "-c", "yarn && yarn serve"]
