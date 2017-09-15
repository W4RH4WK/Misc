#include <stdio.h>
#include <stdlib.h>

int factorial(int x) {
	int y = x;
	int z = 1;
	while (y > 1) {
		z = z * y;
		y = y - 1;
	}
	y = 0;
	return z;
}

int main(int argc, char* argv[]) {
	int x = atoi(argv[1]);
	printf("%d! = %d\n", x, factorial(x));
	return EXIT_SUCCESS;
}
