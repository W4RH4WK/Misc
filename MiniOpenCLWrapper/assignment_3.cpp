#include <iostream>
#include <sys/time.h>
#include <vector>

#ifdef __APPLE__
    #include "OpenCL/opencl.h"
#else
    #include "CL/cl.h"
#endif

#include "helper.h"

using namespace std;

int main(int argc, const char *argv[]) {
    vector<cl_platform_id> platform_ids = GetPlatformIds();
    for (cl_uint i = 0; i < platform_ids.size(); i++) {
        cout << "\t (" << i << ") : " << GetPlatformName(platform_ids[i]) << endl;
    }

    vector<cl_device_id> device_ids = GetDeviceIds(platform_ids[0]);
    for (cl_uint i = 0; i < device_ids.size(); i++) {
        cout << "\t\t (" << i << ") : " << GetDeviceName(device_ids[0]) << endl;
    }

    cl_context context = GetContext(platform_ids[0], device_ids);

    cl_command_queue queue = GetQueue(context, device_ids[0]);

    cl_program program = GetProgram(context, device_ids, "assignment_3.cl");

    cl_kernel kernel = GetKernel(program, "compare");

    // start timing
    timeval t1, t2;
    gettimeofday(&t1, NULL);

    // --------------------------------------------------------------------------------
    //                                  DO STUFF HERE
    // --------------------------------------------------------------------------------

    // stop timing
    gettimeofday(&t2, NULL);
    double elapsedTime = (t2.tv_sec - t1.tv_sec);
    elapsedTime += (t2.tv_usec - t1.tv_usec);
    cout << "time taken: " <<  elapsedTime << " us" << endl;

    // clean up
    clReleaseKernel(kernel);
    clReleaseProgram(program);
    clReleaseCommandQueue(queue);
    clReleaseContext(context);

    return EXIT_SUCCESS;
}