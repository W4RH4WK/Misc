#pragma once

#include <type_traits>

// Type trait indicating whether serialize member function is present.
template <typename Serializer, typename T, typename = void>
struct has_serialize : std::false_type {
};

template <typename Serializer, typename T>
struct has_serialize<Serializer, T, std::void_t<decltype(std::declval<T>().serialize(std::declval<Serializer&>()))>>
    : std::true_type {
};

template <typename Serializer, typename T>
constexpr bool has_serialize_v = has_serialize<Serializer, T>::value;

// All types that have a serialize member function support serialization.
template <typename Serializer, typename T>
typename std::enable_if_t<has_serialize_v<Serializer, T>> serialize(Serializer& s, T& object)
{
	object.serialize(s);
}
