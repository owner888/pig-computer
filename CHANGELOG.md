# Changelog

What changed, newest first, in pig's format: `## [x.y.z] - YYYY-MM-DD`, then only the sections that
have entries (`### New Features`, `### Added`, `### Changed`, `### Fixed`). Notes under
`## Unreleased` belong to no version yet; the version itself lives in the git tag.

## [0.1.0] - 2026-11-02

### New Features

- Computer use as its own package — The extension that was bundled with pig as `extensions/pig-computer` is now this package, installed with `pig install git:github.com/owner888/pig-computer`. Tools, command, skill and web page are the ones pig shipped; the classes moved from `Pig\Extensions\Computer\` to `PigComputer\`, and the extension is still named `pig-computer`, so `disabledExtensions` keeps working.
