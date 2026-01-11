.PHONY: build

build:
	docker run --rm -it -e CGO_ENABLED=0 -v$(PWD):/app -w /app golang:1.25 go build -o shared-memory-read ./
