#include <stdio.h>
#include <stdlib.h>

void print_something(int times) {
	for (int i = 0; i < times; ++i) {
		puts("something");
	}
}

void print_usage() {
	puts("some usage");
}

int main(int argc, char* argv[]) {
	if (argc < 2) {
		print_usage();
		return EXIT_FAILURE;
	}
	print_something(atoi(argv[1]));
	return EXIT_SUCCESS;
}
