#!/usr/bin/env sh

if [ -n "${USER_ID}" ] && [ "${USER_ID}" != "$(id -u)" ]
then
  sudo usermod -u "${USER_ID}" symfony
fi

if [ -n "${GROUP_ID}" ] && [ "${GROUP_ID}" != "$(id -g)" ]
then
  sudo groupmod -g "${GROUP_ID}" symfony
fi

if [ -n "${FTP_PASSWORD}" ] || [ -n "${FTP_USER}" ] || [ -n "${FTP_HOST}" ]
then
  sshpass -p "${FTP_PASSWORD}" ssh -o StrictHostKeyChecking=no "${FTP_USER}@${FTP_HOST}" || true
fi

exec "$@"
