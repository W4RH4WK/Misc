#ifndef LIST_H
#define LIST_H

#include <stdbool.h>
#include <stdlib.h>

struct list_node {
    struct list_node* next;
    struct list_node* prev;
    void* data;
};

struct list_head {
    struct list_node* first;
    struct list_node* last;
    int size;
};

/* Returns a new, empty list or NULL on failure. */
struct list_head* list_create(void);

/* Destorys a list, your data is not freed. */
void list_destroy(struct list_head* list);

/* Appends an element to the list, returns its index or -1 on failure. */
int list_append(struct list_head* list, void* data);

/* Prepends an element to the list, returns its index or -1 on failure. */
int list_prepend(struct list_head* list, void* data);

/* Inserts an element at index, returns index or -1 on failure. */
int list_insert(struct list_head* list, int index, void* data);

/* Removes an element at index, returning its data or NULL on failure. */
void* list_remove(struct list_head* list, int index);

/* Returns an element at index or NULL on failure. */
void* list_get(const struct list_head* list, int index);

/* Removes all elements from the list. */
void list_clear(struct list_head* list);

/* Returns the index of the first element matching data or -1 if not found. */
int list_index_of(const struct list_head* list, void* data);

/* Returns the index of the last occurence matching data or -1 if not found. */
int list_index_of_last(const struct list_head* list, void* data);

/* Find the first element satisfying the callback function. -1 is returnd if
 * the end of the list is reached. */
int list_find(const struct list_head* list, bool (*cmp)(void* data));

/* True iff node in list contains data. */
bool list_contains(const struct list_head* list, void* data);

/* True iff the list is empty. */
bool list_is_empty(const struct list_head* list);

#endif
