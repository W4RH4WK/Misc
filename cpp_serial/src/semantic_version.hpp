#pragma once

#include <cstdio>
#include <string>
#include <tuple>

#include "string_utils.hpp"

struct Version {
	static Version fromString(const std::string &input)
	{
		Version result;
		sscanf(input.c_str(), "%d.%d.%d", &result.major, &result.minor, &result.patch);
		return result;
	}

	std::string toString() const
	{
		using std::to_string;

		std::string s;
		s += to_string(major);
		s += '.';
		s += to_string(minor);
		s += '.';
		s += to_string(patch);
		return s;
	}

	int major = 0;
	int minor = 0;
	int patch = 0;
};

static inline bool operator==(const Version &a, const Version &b)
{
	return std::tie(a.major, a.minor, a.patch) == std::tie(b.major, b.minor, b.patch);
}

static inline bool operator!=(const Version &a, const Version &b)
{
	return std::tie(a.major, a.minor, a.patch) != std::tie(b.major, b.minor, b.patch);
}

static inline bool operator<(const Version &a, const Version &b)
{
	return std::tie(a.major, a.minor, a.patch) < std::tie(b.major, b.minor, b.patch);
}

static inline bool operator<=(const Version &a, const Version &b)
{
	return std::tie(a.major, a.minor, a.patch) <= std::tie(b.major, b.minor, b.patch);
}

static inline bool operator>(const Version &a, const Version &b)
{
	return std::tie(a.major, a.minor, a.patch) > std::tie(b.major, b.minor, b.patch);
}

static inline bool operator>=(const Version &a, const Version &b)
{
	return std::tie(a.major, a.minor, a.patch) >= std::tie(b.major, b.minor, b.patch);
}
