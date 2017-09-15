TEX       = xelatex
TEXFLAGS  = -shell-escape -file-line-error -halt-on-error
BIB       = biber
REFS      = references.bib

.PHONY: all
all: thesis.pdf

.PHONY: clean
clean:
	-$(RM) -r *.aux *.bbl *.bcf *.blg *.lof *.log *.lol *.lot *.nav *.out \
	          *.pdf *.run.xml *.snm *.synctex *.toc *.thm *.pyg _minted*

thesis.pdf: thesis.tex thesis.bbl

%.pdf: %.tex
	$(TEX) $(TEXFLAGS) $<
	$(TEX) $(TEXFLAGS) $<

%.aux: %.tex
	$(TEX) $(TEXFLAGS) $<

%.bbl: %.bcf
	$(BIB) $<

%.bcf: %.tex
	$(TEX) $(TEXFLAGS) $<
