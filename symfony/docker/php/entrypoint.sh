#!/usr/bin/env sh

sudo usermod -u "${USER_ID}" php
sudo groupmod -g "${GROUP_ID}" php

exec "$@"
