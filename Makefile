# 概要: docker imageのビルド・デプロイを行うタスクランナー
include ${abspath makefiles/variables.mk}

# NOTE: 誤操作防止のためtarget指定なしの場合はエラー扱いにする
all:
	@echo Please specify the target. >&2
	@exit 1

# usage:
#	make build-image \
#		DOCKER_IMAGE_NAME={}
build-image:
	make build -C ${DOCKAE_IMAGE_BUILD_MAKE_PATH}


# usage:
# 	make deploy-image-ghcr \
#		DOCKER_IMAGE_NAME={} \
#		GHCR_OWNER={} \
#		GHCR_AUTH_TOKEN={}
deploy-image-ghcr:
	make deploy-image -C ${TASK_FILE_PATH} -f deploy-ghcr.mk
