JAVA  = java
JC    = javac
JAR   = jar
JUNIT = /usr/share/maven-repo/junit/junit/4.x/junit-4.x.jar

PKG = at.bluephoenix.javaranz
APP = $(lastword $(subst ., ,$(PKG))).jar
SRC = $(shell find src -name '*.java')
CLS = $(SRC:.java=.class)

space := $(subst ,, )
LIBS   = $(subst $(space),:,$(wildcard lib/*.jar))
CP     = src:$(LIBS)

TEST_SRC = $(shell find test -name '*.java')
TEST_CLS = $(TEST_SRC:.java=.class)
TEST_CP  = test:$(JUNIT):$(CP)

.PHONY: all
all: $(APP)

.PHONY: clean
clean:
	$(RM) $(APP) $(CLS) $(TEST_CLS)

$(APP): $(CLS)
	$(JAR) cfme $@ Manifest.txt $(PKG).Main \
		$(foreach cls,$(patsubst src/%,%,$^),-C src $(cls))
	@chmod +x $@

src/%.class: src/%.java
	$(JC) $(JFLAGS) -cp $(CP) $<

.PHONY: test
test: $(TEST_CLS)
	@$(JAVA) -cp $(TEST_CP) org.junit.runner.JUnitCore \
			$(subst /,.,$(patsubst test/%,%,$(^:.class=)))

test/%.class: test/%.java
	$(JC) $(JFLAGS) -cp $(TEST_CP) $<
