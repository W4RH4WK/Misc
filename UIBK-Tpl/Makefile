TEX       = xelatex
TEXFLAGS  = -shell-escape -file-line-error -halt-on-error
BIB       = biber
REFS      = references.bib
ALL       = short.pdf article.pdf book.pdf report.pdf beamer.pdf \
            beamer_handout.pdf

.PHONY: all
all: $(ALL)

.PHONY: clean
clean:
	-$(RM) -r *.aux *.bbl *.bcf *.blg *.lof *.log *.lol *.lot *.nav *.out \
	          *.pdf *.run.xml *.snm *.synctex *.toc *.thm *.pyg _minted*

book.pdf: book.tex book.bbl

%.pdf: %.tex
	$(TEX) $(TEXFLAGS) $<
	$(TEX) $(TEXFLAGS) $<

%_handout.pdf: %.tex
	$(TEX) $(TEXFLAGS) -jobname "$(@:.pdf=)" "\PassOptionsToClass{handout}{beamer}\input{$<}"
	$(TEX) $(TEXFLAGS) -jobname "$(@:.pdf=)" "\PassOptionsToClass{handout}{beamer}\input{$<}"

%.aux: %.tex
	$(TEX) $(TEXFLAGS) $<

%.bbl: %.bcf
	$(BIB) $<

%.bcf: %.tex
	$(TEX) $(TEXFLAGS) $<
