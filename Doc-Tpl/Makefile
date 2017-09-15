PAN             = pandoc
PANFLAGS        = --smart \
                  --standalone \
                  --number-sections \
                  --toc \
                  --toc-depth 2 \
                  --no-highlight \
                  --bibliography references.bib \
                  --verbose

PANFLAGS_HTML   = --to html5 \
                  --template tpl/tpl.html \
                  --self-contained

PANFLAGS_TEX    = --template tpl/tpl.tex \
                  --natbib

PANFILTERS      = --filter tpl/filter_exec \
                  --filter tpl/filter_tikz

PANFILTERS_HTML = --filter tpl/filter_prism \
                  --filter tpl/filter_tex2svg \
                  --filter pandoc-citeproc

PANFILTERS_TEX  = --filter tpl/filter_minted \

TEX             = xelatex
TEXFLAGS        = -shell-escape -output-directory=build

BIB             = bibtex
BIBFLAGS        = -terse

OUT             = example.html example.pdf

.PHONY: all clean

all: $(OUT)

clean:
	rm -rf $(OUT) "build"

%.html: %.md
	$(PAN) $(PANFLAGS) $(PANFLAGS_HTML) $(PANFILTERS) $(PANFILTERS_HTML) -o $@ $^

%.tex: %.md
	$(PAN) $(PANFLAGS) $(PANFLAGS_TEX) $(PANFILTERS) $(PANFILTERS_TEX) -o $@ $^

%.pdf: %.tex
	mkdir -p "build"
	$(TEX) $(TEXFLAGS) $<
	$(BIB) $(BIBFLAGS) "build/$(basename $<)"
	$(TEX) $(TEXFLAGS) $<
	$(TEX) $(TEXFLAGS) $<
	cp "build/$@" "$@"
	rm -rf "build"
