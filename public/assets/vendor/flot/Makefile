.PHONY: all
all: $(patsubst %.js,%.min.js,$(filter-out %.min.js,$(wildcard *.js)))
%.min.js: %.js
	yui-compressor $< -o $@
test:
	./node_modules/.bin/jshint *jquery.flot.js
