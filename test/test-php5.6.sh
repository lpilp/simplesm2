#!/usr/bin/env bash

set -e

DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )
cd "$DIR"

export DOCKER_CLI_HINTS=false
docker build -t smecc-test-php5.6 -f dockerfile-php5.6 .
docker run --rm --volume "$PWD/..:/data/smecc" smecc-test-php5.6 php /data/smecc/test/test.php
