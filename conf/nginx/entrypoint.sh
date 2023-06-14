#!/usr/bin/env sh

set -e

/bin/confd -onetime -backend env

exec "$@"