__kernel void compare (
    __global  char *inputA,
    __global  char *inputB,
    __global  int *output
    )
{
    int id = get_global_id(0);

    if (inputA[id] < inputB[id])
        output[id] = id + 1;
    else if (inputA[id] > inputB[id])
        output[id] = - (id + 1);
    else
        output[id] = 0;
}