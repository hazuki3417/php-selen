# 概要: docker imageビルドを行うタスクランナー
include ${abspath ../../../makefiles/variables.mk}

# 入力値
VERSION ?=

# 固定値
ENVIRONMENT := develop
DOCKER_BASE_DIR := docker
DOCKER_IMAGE_NAME := php-selen



# NOTE: dslim/slimを利用してビルド
#       php module,extendionをインストールするためにビルドツールを入れている。
#       それらの影響でimage sizeが大きくなるため、最適化ツールを利用してビルドしている。
# NOTE: Github Actionsでチェックアウトするために使用
#       - /usr/bin/tar, /etc/os-release
# usage: make build VERSION={versionName}
build:
	docker run --rm \
		-v ${DOCKER_CONTEXT_PATH}:/tmp/work \
		-v /var/run/docker.sock:/var/run/docker.sock \
		dslim/slim build \
		--dockerfile-context /tmp/work \
		--dockerfile ${DOCKER_FILE_PATH} \
		--tag ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG} \
		--http-probe=false \
		--include-bin /usr/bin/openssl \
		--include-bin /usr/bin/ssl_client \
		--include-bin /usr/bin/tar \
		--include-bin /usr/local/bin/php \
		--include-bin /usr/local/bin/phpdbg \
		--include-path /etc/os-release \
		--include-path /usr/bin/composer \
		--include-path /usr/local \
		--include-path /var/www/html
