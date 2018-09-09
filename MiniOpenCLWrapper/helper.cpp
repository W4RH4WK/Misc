#include "helper.h"

using namespace std;

void CheckError(cl_int err) {
    CheckError(err, "");
}

void CheckError(cl_int err, const char *label) {
    if (err != CL_SUCCESS) {
        const char *name;
        switch (err) {
        case CL_SUCCESS:                            name = "Success!";break;
        case CL_DEVICE_NOT_FOUND:                   name = "Device not found.";break;
        case CL_DEVICE_NOT_AVAILABLE:               name = "Device not available";break;
        case CL_COMPILER_NOT_AVAILABLE:             name = "Compiler not available";break;
        case CL_MEM_OBJECT_ALLOCATION_FAILURE:      name = "Memory object allocation failure";break;
        case CL_OUT_OF_RESOURCES:                   name = "Out of resources";break;
        case CL_OUT_OF_HOST_MEMORY:                 name = "Out of host memory";break;
        case CL_PROFILING_INFO_NOT_AVAILABLE:       name = "Profiling information not available";break;
        case CL_MEM_COPY_OVERLAP:                   name = "Memory copy overlap";break;
        case CL_IMAGE_FORMAT_MISMATCH:              name = "Image format mismatch";break;
        case CL_IMAGE_FORMAT_NOT_SUPPORTED:         name = "Image format not supported";break;
        case CL_BUILD_PROGRAM_FAILURE:              name = "Program build failure";break;
        case CL_MAP_FAILURE:                        name = "Map failure";break;
        case CL_INVALID_VALUE:                      name = "Invalid value";break;
        case CL_INVALID_DEVICE_TYPE:                name = "Invalid device type";break;
        case CL_INVALID_PLATFORM:                   name = "Invalid platform";break;
        case CL_INVALID_DEVICE:                     name = "Invalid device";break;
        case CL_INVALID_CONTEXT:                    name = "Invalid context";break;
        case CL_INVALID_QUEUE_PROPERTIES:           name = "Invalid queue properties";break;
        case CL_INVALID_COMMAND_QUEUE:              name = "Invalid command queue";break;
        case CL_INVALID_HOST_PTR:                   name = "Invalid host pointer";break;
        case CL_INVALID_MEM_OBJECT:                 name = "Invalid memory object";break;
        case CL_INVALID_IMAGE_FORMAT_DESCRIPTOR:    name = "Invalid image format descriptor";break;
        case CL_INVALID_IMAGE_SIZE:                 name = "Invalid image size";break;
        case CL_INVALID_SAMPLER:                    name = "Invalid sampler";break;
        case CL_INVALID_BINARY:                     name = "Invalid binary";break;
        case CL_INVALID_BUILD_OPTIONS:              name = "Invalid build options";break;
        case CL_INVALID_PROGRAM:                    name = "Invalid program";break;
        case CL_INVALID_PROGRAM_EXECUTABLE:         name = "Invalid program executable";break;
        case CL_INVALID_KERNEL_NAME:                name = "Invalid kernel name";break;
        case CL_INVALID_KERNEL_DEFINITION:          name = "Invalid kernel definition";break;
        case CL_INVALID_KERNEL:                     name = "Invalid kernel";break;
        case CL_INVALID_ARG_INDEX:                  name = "Invalid argument index";break;
        case CL_INVALID_ARG_VALUE:                  name = "Invalid argument value";break;
        case CL_INVALID_ARG_SIZE:                   name = "Invalid argument size";break;
        case CL_INVALID_KERNEL_ARGS:                name = "Invalid kernel arguments";break;
        case CL_INVALID_WORK_DIMENSION:             name = "Invalid work dimension";break;
        case CL_INVALID_WORK_GROUP_SIZE:            name = "Invalid work group size";break;
        case CL_INVALID_WORK_ITEM_SIZE:             name = "Invalid work item size";break;
        case CL_INVALID_GLOBAL_OFFSET:              name = "Invalid global offset";break;
        case CL_INVALID_EVENT_WAIT_LIST:            name = "Invalid event wait list";break;
        case CL_INVALID_EVENT:                      name = "Invalid event";break;
        case CL_INVALID_OPERATION:                  name = "Invalid operation";break;
        case CL_INVALID_GL_OBJECT:                  name = "Invalid OpenGL object";break;
        case CL_INVALID_BUFFER_SIZE:                name = "Invalid buffer size";break;
        case CL_INVALID_MIP_LEVEL:                  name = "Invalid mip-map level";break;
        default: name = "Unknown";
        }
        cerr << "OpenCL error occurred " << label << ": ("<< err << ") " << name << endl;
        exit(err);
    }
}

Image LoadImage(const char* path) {
    ifstream in(path, ios::binary);

    string s;
    in >> s;

    if (s != "P6") {
        exit(EXIT_FAILURE);
    }

    // Skip comments
    for (;;) {
        getline(in, s);

        if (s.empty()) {
            continue;
        }

        if (s [0] != '#') {
            break;
        }
    }

    stringstream str(s);
    int width, height, maxColor;
    str >> width >> height;
    in >> maxColor;

    if (maxColor != 255) {
        exit (1);
    }

    {
        // Skip until end of line
        string tmp;
        getline(in, tmp);
    }

    vector<char> data(width * height * 3);
    in.read(reinterpret_cast<char*> (data.data()), data.size());

    const Image img = { data, width, height };
    return img;
}

void SaveImage(const Image& img, const char* path) {
    ofstream out(path, ios::binary);

    out << "P6" << endl;;
    out << img.width << " " << img.height << endl;
    out << "255" << endl;;
    out.write(img.pixel.data(), img.pixel.size());
}

Image RGBtoRGBA(const Image& input)
{
    Image result;
    result.width = input.width;
    result.height = input.height;

    for (size_t i = 0; i < input.pixel.size(); i += 3) {
        result.pixel.push_back(input.pixel[i + 0]);
        result.pixel.push_back(input.pixel[i + 1]);
        result.pixel.push_back(input.pixel[i + 2]);
        result.pixel.push_back(0);
    }

    return result;
}

Image RGBAtoRGB(const Image& input)
{
    Image result;
    result.width = input.width;
    result.height = input.height;

    for (size_t i = 0; i < input.pixel.size(); i += 4) {
        result.pixel.push_back(input.pixel[i + 0]);
        result.pixel.push_back(input.pixel[i + 1]);
        result.pixel.push_back(input.pixel[i + 2]);
    }

    return result;
}

vector<cl_platform_id> GetPlatformIds(void) {
    cl_uint count = 0;
    clGetPlatformIDs(0, 0, &count);

    if (count == 0) {
        cerr << "No OpenCL platform found" << endl;
        exit(EXIT_FAILURE);
    } else {
        cout << "Found " << count << " platforms" << endl;
    }

    vector<cl_platform_id> ids(count);
    clGetPlatformIDs(count, ids.data(), 0);

    return ids;
}

string GetPlatformName(cl_platform_id id) {
    size_t size = 0;
    clGetPlatformInfo(id, CL_PLATFORM_NAME, 0, 0, &size);

    string name;
    name.resize(size);
    clGetPlatformInfo(id, CL_PLATFORM_NAME, size, const_cast<char *> (name.data()), 0);

    return name;
}

vector<cl_device_id> GetDeviceIds(cl_platform_id platform_id) {
    cl_uint count = 0;
    clGetDeviceIDs(platform_id, CL_DEVICE_TYPE_ALL, 0, 0, &count);

    vector<cl_device_id> ids(count);
    clGetDeviceIDs(platform_id, CL_DEVICE_TYPE_ALL, count, ids.data(), 0);

    return ids;
}

string GetDeviceName(cl_device_id id) {
    size_t size = 0;
    clGetDeviceInfo(id, CL_DEVICE_NAME, 0, 0, &size);

    string name;
    name.resize(size);
    clGetDeviceInfo(id, CL_DEVICE_NAME, size, const_cast<char *> (name.data()), 0);

    return name;
}

cl_context GetContext(cl_platform_id platform_id, vector<cl_device_id> device_ids) {
    const cl_context_properties contextProperties [] = {
        CL_CONTEXT_PLATFORM, reinterpret_cast<cl_context_properties> (platform_id), 0, 0
    };

    cl_int err = CL_SUCCESS;
    cl_context context = clCreateContext(contextProperties, device_ids.size(), device_ids.data(), 0, 0, &err);
    CheckError(err, "in GetContext");

    return context;
}

cl_command_queue GetQueue(cl_context context, cl_device_id device_id) {
    cl_int err = CL_SUCCESS;
    cl_command_queue queue = clCreateCommandQueue(context, device_id, 0, &err);
    CheckError(err);

    return queue;
}

cl_program GetProgram(cl_context context, vector<cl_device_id> device_ids, const char* name) {
    // get program
    ifstream in(name);
    string source((istreambuf_iterator<char> (in)), istreambuf_iterator<char> ());
    size_t lengths[1] = {source.size()};
    const char* sources[1] = {source.data()};
    cl_int err = CL_SUCCESS;
    cl_program program = clCreateProgramWithSource(context, 1, sources, lengths, &err);
    CheckError(err, "at GetProgram");

    // build program
    err = clBuildProgram(program, device_ids.size(), device_ids.data(), "", 0, 0);
    if (err == CL_BUILD_PROGRAM_FAILURE) {
        size_t log_size;
        clGetProgramBuildInfo(program, device_ids.data()[0], CL_PROGRAM_BUILD_LOG, 0, NULL, &log_size);
        string log;
        log.resize(log_size);
        clGetProgramBuildInfo(program, device_ids.data()[0], CL_PROGRAM_BUILD_LOG, log_size, const_cast<char *> (log.data()), NULL);
        cout << "OpenCL Build Program Failure:" << endl;
        cout << log << endl;
        exit(CL_BUILD_PROGRAM_FAILURE);
    }

    return program;
}

cl_kernel GetKernel(cl_program program, const char* name) {
    cl_int err = CL_SUCCESS;
    cl_kernel kernel = clCreateKernel(program, name, &err);
    CheckError(err, "in GetKernel");

    return kernel;
}