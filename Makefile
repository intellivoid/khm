clean:
	rm -rf build

update:
	ppm --generate-package="src/khm"

build:
	mkdir build
	ppm --no-intro --compile="src/khm" --directory="build"

install:
	ppm --no-intro --no-prompt --fix-conflict --install="build/net.intellivoid.khm.ppm"