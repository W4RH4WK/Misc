#include <optional>
#include <string>
#include <type_traits>

#include "serialize.hpp"
#include "serialize_loader.hpp"
#include "serialize_printer.hpp"

namespace foo {

#define ENUM_NAME Color
#define ENUM_ENTRIES \
	ENUM_ENTRY(Red) \
	ENUM_ENTRY(Green) \
	ENUM_ENTRY(Blue)
#include "enum.inc"

} // namespace foo

struct Extent {
	int x = 0;
	int y = 0;
};

namespace ph3 {
template <>
std::optional<Extent> from_string<Extent>(std::string_view)
{
	return Extent{1, 2};
}
} // namespace ph3

// Regular function defining serialization for Extent. This can be defined
// anywhere, not necessarily next to the definition of Extent.
template <class Serializer>
void serialize(Serializer& s, Extent& extent)
{
	s.begin("Extent", {0, 1});
	s.field("x", extent.x);
	s.field("y", extent.y);
	s.end();
}

class Config {
  public:
	foo::Color color() const { return m_color; }

	// Member function defining serialization for Config. This allows access to
	// privates. Another option would be to define a friend.
	template <class Serializer>
	void serialize(Serializer& s)
	{
		s.begin("Config", {0, 2});
		s.field("resolution", m_resolution);
		s.field("color", m_color);
		s.end();
	}

  private:
	Extent m_resolution = {1920, 1080};
	foo::Color m_color = foo::Color::Red;
};

int main()
{
	std::cout << ph3::from_string<Extent>("")->x << "\n";

	SerialPrinter print;
	SerialLoader load;

	const Config config1;
	// load(config1); // Error: loader requires non-const reference.
	print(config1);

	Config config2;
	load(config2);
	print(config2);

	using ph3::operator<<;

	std::cout << config1.color() << "\n";
}
