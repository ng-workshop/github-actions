#!/usr/bin/env sh

sudo usermod -u "${USER_ID}" vuejs
sudo groupmod -g "${GROUP_ID}" vuejs

if [ -f "/home/vuejs/.bashrc" ]
then
  . /home/vuejs/.bashrc
fi

exec "$@"
