#!/usr/bin/env sh

if [ -n "${USER_ID}" ] && [ "${USER_ID}" != "$(id -u)" ]
then
  sudo usermod -u "${USER_ID}" vuejs
fi

if [ -n "${GROUP_ID}" ] && [ "${GROUP_ID}" != "$(id -g)" ]
then
  sudo groupmod -g "${GROUP_ID}" vuejs
fi

if [ -f "/home/vuejs/.bashrc" ]
then
  . /home/vuejs/.bashrc
fi

exec "$@"
