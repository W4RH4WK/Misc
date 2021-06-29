#pragma once

#include <optional>
#include <ostream>
#include <string>
#include <type_traits>

namespace ph3 {

// Type trait indicating whether to_string is available.
template <typename T, class = void>
struct has_to_string : std::false_type {};

template <typename T>
struct has_to_string<T, std::void_t<decltype(to_string(std::declval<T>()))>> : std::true_type {};

template <typename T>
constexpr bool has_to_string_v = has_to_string<T>::value;

// Type trait indicating whether toString member function is available.
template <typename T, class = void>
struct has_toString : std::false_type {};

template <typename T>
struct has_toString<T, std::void_t<decltype(std::declval<T>().toString())>> : std::true_type {};

template <typename T>
constexpr bool has_toString_v = has_toString<T>::value;

// All types that have a toString member function support to_string.
template <typename T>
typename std::enable_if_t<has_toString_v<T>, std::string> to_string(const T& value)
{
	return value.toString();
}

// Type trait indicating whether fromString member function is available.
template <typename T, typename = void>
struct has_fromString : std::false_type {};

template <typename T>
struct has_fromString<T, std::void_t<decltype(T::fromString(std::declval<std::string_view>()))>> : std::true_type {};

template <typename T>
constexpr bool has_fromString_v = has_fromString<T>::value;

// Type trait indicating whether from_string_impl is available.
template <typename T, typename = void>
struct has_from_string_impl : std::false_type {};

template <typename T>
struct has_from_string_impl<
    T, std::void_t<decltype(from_string_impl(std::declval<std::string_view>(), std::declval<std::optional<T>&>()))>>
    : std::true_type {};

template <typename T>
constexpr bool has_from_string_impl_v = has_from_string_impl<T>::value;

// Default implementation for constructing an object from a string.
template <typename T>
std::optional<T> from_string(std::string_view input)
{
	std::optional<T> result;

	if constexpr (has_fromString_v<T>) {
		return T::fromString(input);
	}

	else if constexpr (has_from_string_impl_v<T>) {
		from_string_impl(input, result);
		return result;
	}

	else {
		static_assert("no from_string implementation");
	}
}

// All types that support to_string can be used with an output stream.
//
// Requires a `using ph3::operator<<;` to be used outside the ph3 namespace.
template <typename T>
typename std::enable_if_t<ph3::has_to_string_v<T>, std::ostream&> operator<<(std::ostream& out, const T& object)
{
	return out << to_string(object);
}

} // namespace ph3
