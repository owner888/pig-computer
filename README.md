# pig-computer

Computer use for the pig coding agent: see and operate the macOS desktop — screenshots, clicks, drags, scrolling, typing, keys and apps — in pure PHP, with only the tools macOS ships. No Docker, no browser service, no Python or Node.js bridge.

[中文](README.zh-CN.md)

## Installation

```bash
pig install git:github.com/owner888/pig-computer
```

macOS only; on other systems the tools say desktop automation is unavailable. The terminal (or whatever runs pig) needs two permissions, in **System Settings → Privacy & Security**:

- **Screen Recording**, for `screencapture`
- **Accessibility**, for the synthesized mouse and keyboard input

Computer use was bundled with pig until it became this package. `pig update` removes the old bundled copy and prints the install line above; `disabledExtensions: ["pig-computer"]` still reaches the package.

## How it works

Screenshots come from `/usr/sbin/screencapture` and are scaled and compressed with `/usr/bin/sips`; mouse and keyboard input goes through `/usr/bin/osascript` (JXA with CoreGraphics events, System Events for keystrokes).

Screenshots are scaled so the long side is at most 1568 px and the short side at most 980, and saved as JPEG in the extension's artifacts directory. Each observation reports `pixel_to_point`, the ratio between screenshot pixels and screen points: the model passes coordinates as it sees them, and the tools convert them, so clicks land right on Retina displays. Clicks get up to 2 points of jitter.

## Tools

| Tool | What it does |
| --- | --- |
| `computer_doctor` | Platform, whether automation is available, screen size, frontmost app, whether `screencapture` and `osascript` are there |
| `computer_ready` | Check the control channel; screen size, frontmost app, `pixel_to_point` and a first screenshot. Call it first |
| `computer_observe` | A screenshot and/or the frontmost app |
| `computer_click` | Click at screenshot coordinates: left, right or middle, double with `click_count: 2` |
| `computer_drag` | Drag between two points |
| `computer_scroll` | Scroll the wheel |
| `computer_type_text` | Type into the focused field; CJK, quotes and several lines go through the clipboard |
| `computer_press_key` | A key or a combination: `enter`, `tab`, `escape`, `cmd+c`, `cmd+space` |
| `computer_launch_app` | Open or focus an app by name, or open a URL |
| `computer_batch` | Up to 15 steps in order, 120–300 ms apart |

`observe` on the action tools (`none`, `screenshot`, `both`) returns the new screen with the action's report.

### Command

`/computer status` (the default), `/computer screenshot`, `/computer app <name>`.

### Skill

The `computer-use` skill keeps the desktop a last resort: what bash, an API or `fetch_web_page` can do is done that way, and the screen only when the person asks for it or nothing else can.

### Web UI

With `pig web`, `/api/computer/stream` shows the screen, refreshed every second. These routes capture the real screen; expose the web server only where that is acceptable.

## Development

The tests run against a pig checkout:

```bash
PIG_DIR=~/path/to/pig ~/path/to/pig/vendor/bin/phpunit -c phpunit.xml
```

`PIG_DIR` defaults to a `pig` directory next to this package.

## License

MIT
