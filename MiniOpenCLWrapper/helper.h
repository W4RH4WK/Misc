#ifndef __HELPER_H_
#define __HELPER_H_

#include <fstream>
#include <iostream>
#include <sstream>
#include <vector>

#ifdef __APPLE__
    #include "OpenCL/opencl.h"
#else
    #include "CL/cl.h"
#endif

using namespace std;

struct Image {
    vector<char> pixel;
    int width, height;
};

// ------------------------------------------------------------ ERROR CHECKING
void CheckError(cl_int err);

void CheckError(cl_int err, const char *label);

// ------------------------------------------------------------ IMAGE HANDLING
Image LoadImage(const char* path);

void SaveImage(const Image& img, const char* path);

Image RGBtoRGBA(const Image& input);

Image RGBAtoRGB(const Image& input);

// ------------------------------------------------------------ OPENCL STUFF
vector<cl_platform_id> GetPlatformIds(void);

string GetPlatformName(cl_platform_id id);

vector<cl_device_id> GetDeviceIds(cl_platform_id platform_id);

string GetDeviceName(cl_device_id id);

cl_context GetContext(cl_platform_id platform_id, vector<cl_device_id> device_ids);

cl_command_queue GetQueue(cl_context context, cl_device_id device_id);

cl_program GetProgram(cl_context context, vector<cl_device_id> device_ids, const char* name);

cl_kernel GetKernel(cl_program program, const char* name);

#endif