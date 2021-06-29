#pragma once

#include <string>

#include "semantic_version.hpp"
#include "string_utils.hpp"

// Dummy loader that sets integers to 42.
class SerialLoader {
  public:
	void begin(std::string_view name, Version version) {}
	void end() {}

	void field(std::string_view name, int& value) { value = 42; }

	template <class T>
	void field(std::string_view name, T& value)
	{
		if constexpr (std::is_enum_v<T>) {
			value = ph3::from_string<T>("Blue").value_or(static_cast<T>(0));
		} else {
			serialize(*this, value);
		}
	}

	// Note the non-const reference here and compare with
	// SerialPrinter::operator().
	template <typename T>
	void operator()(T& object)
	{
		object.serialize(*this);
	}
};
