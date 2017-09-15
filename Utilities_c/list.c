#include "list.h"

#include <stdbool.h>
#include <stdlib.h>

static struct list_node* list_get_node(const struct list_head* list, int index);

struct list_head* list_create(void) {
    struct list_head* list = malloc(sizeof(struct list_head));
    if (list == NULL) {
        return NULL;
    }
    list->first = NULL;
    list->last  = NULL;
    list->size  = 0;
    return list;
}

void list_destroy(struct list_head* list) {
    list_clear(list);
    free(list);
}

int list_append(struct list_head* list, void* data) {
    return list_insert(list, list->size, data);
}

int list_prepend(struct list_head* list, void* data) {
    return list_insert(list, 0, data);
}

int list_insert(struct list_head* list, int index, void* data) {
    /* out of bounds check */
    if (index < 0 || index > list->size) {
        return -1;
    }

    /* create new node */
    struct list_node* node =  malloc(sizeof(struct list_node));
    if (node == NULL) {
        return -1;
    }
    node->data = data;

    if (list_is_empty(list)) {
        /* handle empty list */
        node->prev = NULL;
        node->next = NULL;
    } else if (index == list->size) {
        /* handle append */
        node->prev = list->last;
        node->next = NULL;
        node->prev->next = node;
    } else {
        struct list_node* target = list_get_node(list, index);

        /* set node pointers */
        node->prev = target->prev;
        node->next = target;

        /* update chain */
        if (node->prev != NULL) {
            node->prev->next = node;
        }
        if (node->next != NULL) {
            node->next->prev = node;
        }
    }

    /* update head */
    if (index == 0) {
        list->first = node;
    }
    if (index == list->size) {
        list->last = node;
    }

    list->size++;
    return index;
}

void* list_remove(struct list_head* list, int index) {
    /* out of bounds check */
    if (index < 0 || index >= list->size) {
        return NULL;
    }

    /* find target */
    struct list_node* target = list_get_node(list, index);

    /* update chain */
    if (target->prev != NULL) {
        target->prev->next = target->next;
    }
    if (target->next != NULL) {
        target->next->prev = target->prev;
    }

    /* update head */
    if (index == 0) {
        list->first = target->next;
    }
    if (index == list->size) {
        list->last = target->prev;
    }

    void* data = target->data;
    free(target);
    return data;
}

void* list_get(const struct list_head* list, int index) {
    struct list_node* node = list_get_node(list, index);
    if (node == NULL) {
        return NULL;
    }
    return node->data;
}

void list_clear(struct list_head* list) {
    for (struct list_node* node = list->first; node != NULL;) {
        struct list_node* node2 = node;
        node = node->next;
        free(node2);
    }
    list->first = NULL;
    list->last = NULL;
    list->size = 0;
}

int list_index_of(const struct list_head* list, void* data) {
    if (list->size == 0) {
        return -1;
    }

    struct list_node* node = list->first;
    for (int i = 0; i < list->size; i++) {
        if (node->data == data) {
            return i;
        }
        node = node->next;
    }

    return -1;
}

int list_index_of_last(const struct list_head* list, void* data) {
    if (list->size == 0) {
        return -1;
    }

    struct list_node* node = list->last;
    for (int i = list->size - 1; i >= 0; i--) {
        if (node->data == data) {
            return i;
        }
        node = node->prev;
    }

    return -1;
}

int list_find(const struct list_head* list, bool (*cmp)(void* data)) {
    if (list->size == 0) {
        return -1;
    }

    struct list_node* node = list->first;
    for (int i = 0; i < list->size; i++) {
        if (cmp(node->data)) {
            return i;
        }
        node = node->next;
    }

    return -1;
}

bool list_contains(const struct list_head* list, void* data) {
    return list_index_of(list, data) != -1;
}

bool list_is_empty(const struct list_head* list) {
    return list->size == 0;
}

static struct list_node* list_get_node(const struct list_head* list, int index) {
    /* out of bounds check */
    if (index < 0 || index >= list->size) {
        return NULL;
    }

    /* find target */
    struct list_node* target = NULL;
    if (index < list->size / 2) {
        target = list->first;
        for (int i = 0; i < index; i++) {
            target = target->next;
        }
    } else {
        target = list->last;
        for (int i = list->size; i > index + 1; i--) {
            target = target->prev;
        }
    }

    return target;
}
