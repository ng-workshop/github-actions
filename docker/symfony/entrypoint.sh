#!/usr/bin/env sh

sudo usermod -u "${USER_ID}" symfony
sudo groupmod -g "${GROUP_ID}" symfony

sshpass -p "${FTP_PASSWORD}" ssh -o StrictHostKeyChecking=no "${FTP_USER}@${FTP_HOST}" || true

exec "$@"
