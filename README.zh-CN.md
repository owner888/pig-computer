# pig-computer

给 pig 编码助手用的 Computer Use 扩展：用纯 PHP 看见并操作 macOS 桌面——截图、点击、拖拽、滚动、输入文字、按键和打开应用，只用 macOS 自带的工具。不用 Docker，没有浏览器服务，也没有 Python 或 Node.js 桥接。

[English](README.md)

## 安装

```bash
pig install git:github.com/owner888/pig-computer
```

仅支持 macOS；在其他系统上，工具会说明桌面自动化不可用。终端（或运行 pig 的进程）需要两项权限，在 **系统设置 → 隐私与安全性** 中授予：

- **屏幕录制**，供 `screencapture` 使用
- **辅助功能**，用于合成鼠标和键盘输入

Computer Use 以前随 pig 内置，现在独立成了这个包。`pig update` 会删掉旧的内置副本，并打印上面的安装命令；`disabledExtensions: ["pig-computer"]` 对这个包照样有效。

## 工作原理

截图来自 `/usr/sbin/screencapture`，由 `/usr/bin/sips` 缩放和压缩；鼠标和键盘输入通过 `/usr/bin/osascript` 完成（JXA 配合 CoreGraphics 事件，按键用 System Events）。

截图会缩放到长边最多 1568 像素、短边最多 980 像素，以 JPEG 格式保存在扩展的 artifacts 目录里。每次观察都会返回 `pixel_to_point`，即截图像素和屏幕点之间的比例：模型按截图上看到的坐标传参，工具负责换算，所以在 Retina 屏上也能点准。点击带最多 2 个点的抖动。

## 工具

| 工具 | 做什么 |
| --- | --- |
| `computer_doctor` | 平台、自动化是否可用、屏幕尺寸、最前端的应用、`screencapture` 和 `osascript` 是否存在 |
| `computer_ready` | 检查控制通道；返回屏幕尺寸、最前端的应用、`pixel_to_point` 和第一张截图。最先调用它 |
| `computer_observe` | 截图和/或最前端的应用 |
| `computer_click` | 按截图坐标点击：左键、右键或中键，`click_count: 2` 为双击 |
| `computer_drag` | 在两点之间拖拽 |
| `computer_scroll` | 滚动鼠标滚轮 |
| `computer_type_text` | 往获得焦点的输入框里打字；中日韩文字、引号和多行文本走剪贴板 |
| `computer_press_key` | 按一个键或组合键：`enter`、`tab`、`escape`、`cmd+c`、`cmd+space` |
| `computer_launch_app` | 按名称打开或切换到应用，或打开 URL |
| `computer_batch` | 依次执行最多 15 步，步与步之间间隔 120–300 毫秒 |

操作类工具的 `observe`（`none`、`screenshot`、`both`）会把新画面和操作报告一起返回。

### 命令

`/computer status`（默认）、`/computer screenshot`、`/computer app <名称>`。

### Skill

`computer-use` 这个 skill 把桌面操作当作最后手段：bash、API 或 `fetch_web_page` 能做的事就用它们做，只有用户要求、或别的办法都做不到时才去操作屏幕。

### Web 界面

用 `pig web` 时，`/api/computer/stream` 显示屏幕画面，每秒刷新一次。这些路由截取的是真实屏幕，只在可以接受的地方开放 Web 服务。

## 开发

测试需要一个 pig 源码目录：

```bash
PIG_DIR=~/path/to/pig ~/path/to/pig/vendor/bin/phpunit -c phpunit.xml
```

`PIG_DIR` 默认是本包旁边的 `pig` 目录。

## 许可证

MIT
