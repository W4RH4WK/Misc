CFLAGS = -lstdc++ -lOpenCL

AMDOCLSDK=/scratch/c703/c703432/amd_ocl/AMD-APP-SDK-v2.6-RC3-lnx64
INC=-I$(AMDOCLSDK)/include
LIB=-L$(AMDOCLSDK)/lib/x86_64

assignment_3: assignment_3.cpp helper.cpp
	gcc $(INC) $(LIB) $(CFLAGS) -o $@ $^

clean:
	rm -f assignment_3