#include <optional>
#include <string>

#include "macros.hpp"

enum class ENUM_NAME {
#define ENUM_ENTRY(x) x,
	ENUM_ENTRIES
#undef ENUM_ENTRY
};

static inline std::string to_string(ENUM_NAME entry)
{
	switch (entry) {
#define ENUM_ENTRY(x) \
	case ENUM_NAME::x: \
		return {#x}; \
		break;

		ENUM_ENTRIES

#undef ENUM_ENTRY
	}

	return "<invalid " SERIAL_STR(ENUM_NAME) ">";
}

void from_string_impl(std::string_view input, std::optional<ENUM_NAME>& result)
{
	if (false) {
	}

#define ENUM_ENTRY(x) \
	else if (input == #x) { result = ENUM_NAME::x; }
	ENUM_ENTRIES
#undef ENUM_ENTRY

	else { result.reset(); }
}

#undef ENUM_NAME
#undef ENUM_ENTRIES
