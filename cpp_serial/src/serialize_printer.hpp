#pragma once

#include <iostream>
#include <string>

#include "semantic_version.hpp"

class SerialPrinter {
  public:
	explicit SerialPrinter(std::ostream& out = std::cout) : m_out(out) {}

	void begin(std::string_view name, Version version)
	{
		indent();
		m_out << name << " (" << version.toString() << ") {\n";
	}

	void end()
	{
		indent();
		m_out << "}\n";
	}

	void field(std::string_view name, int& value)
	{
		indent();
		m_out << "  " << name << ": " << value << "\n";
	}

	template <class T, class = void>
	void field(std::string_view name, T& value)
	{
		indent();

		m_out << "  " << name << ":";
		if constexpr (std::is_enum_v<T>) {
			m_out << " " << to_string(value) << "\n";
		} else {
			m_depth++;
			serialize(*this, value);
			m_depth--;
		}
	}

	template <typename T>
	void operator()(const T& object)
	{
		// serialize is typically only defined once for each object, taking a
		// non-const reference. Since this function is the entry point for the
		// serialization process, it is fine to strip away the const.
		const_cast<T&>(object).serialize(*this);
	}

  private:
	void indent()
	{
		for (auto i = 0; i < m_depth; i++) {
			m_out << "  ";
		}
	}

	int m_depth = 0;

	std::ostream& m_out;
};
