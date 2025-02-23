# DeepSeek AI Writer

[![WordPress 插件版本](https://img.shields.io/wordpress/plugin/v/deepseek-ai-writer.svg)](https://wordpress.org/plugins/你的插件短代码/)  [![WordPress 下载量](https://img.shields.io/wordpress/plugin/dt/deepseek-ai-writer.svg)](https://wordpress.org/plugins/你的插件短代码/)  [![许可证](https://img.shields.io/badge/license-GPL--2.0%2B-blue.svg)](https://www.gnu.org/licenses/gpl-2.0.html)

DeepSeek AI Writer 是一款基于 DeepSeek 大型语言模型的 WordPress 智能写作插件。它可以帮助您快速生成文章标题、正文和摘要，支持多种写作风格和文章结构，显著提高您的内容创作效率。

## 主要功能

*   **AI 内容生成：** 只需输入一个主题或简短的提示，即可快速生成文章的标题、正文和摘要。
*   **多种写作风格：** 支持正式、轻松、专业、幽默、信息丰富等多种写作风格，满足不同场景的需求。
*   **可定制的文章结构：** 您可以选择标准结构（引言、主体、结论）、SEO 优化结构（多级标题、元描述）、博客文章结构（段落、小标题）或新闻报道结构（倒金字塔）。
*   **用户偏好设置：** 插件会自动保存您选择的文章长度、风格和结构，方便您下次使用。
*   **兼容性：** 完美兼容 WordPress 经典编辑器和 Gutenberg 编辑器。
*   **易于使用：** 简洁直观的界面，无需任何技术背景，即可轻松上手。
*   **连接测试：** 支持 DeepSeek AI 模型连接测试。
*   **目前支持：** 支持火山引擎、腾讯云的Deepseek大模型调用。
*   **有需要增加新的第三方deepseek支持：** 可自行修改代码或者联系开发者。
*   **反馈：** ![微信](https://www.deepods.com/wp-content/uploads/2025/02/catfeeds_wechat.png=200x)

## 安装

1.  **上传：** 将 `deepseek-ai-writer` 文件夹上传到 `/wp-content/plugins/` 目录。或者通过 WordPress 插件管理后台安装。
2.  **激活：** 通过 WordPress 的“插件”菜单激活插件。
3.  **配置：** 在 WordPress 管理菜单中找到 "DeepSeek AI Writer" 并进行配置（填写您的 DeepSeek API 网址、API 密钥和模型名称）。

## 使用方法

1.  **打开文章：** 在 WordPress 中创建新文章或编辑现有文章。
2.  **找到 AI Writer 区域：** 您将在文章标题下方看到 "DeepSeek AI Writer" 区域。
3.  **输入提示：** 在“AI 写作提示”文本框中输入您的主题或简短描述。
4.  **选择选项：** 选择您想要的文章长度、风格和结构。
5.  **生成内容：** 点击“生成内容”按钮。
6.  **查看和编辑：** AI 将生成内容并填充到标题、内容和摘要字段中。请务必仔细检查和编辑生成的内容。*您对最终发布的内容负责。*
7.  **手动添加标签：**  插件目前不支持自动提取关键词, 请手动添加标签。

## 配置

*   **网址 (Website)：** 您的 DeepSeek API 端点 URL。
*   **API Key：** 您的 DeepSeek API 密钥。
*   **模型名称 (Model Name)：** 您要使用的 DeepSeek 模型名称。
*   **系统提示词 (System Prompt)：** 用于指导 AI 行为和角色的默认系统提示词（例如，“您是一位专业的内容创作者”）。

## 系统要求

*   WordPress 5.0 或更高版本
*   PHP 7.4 或更高版本
*   DeepSeek API 端点（第三方服务）和 API 密钥。 **本插件 *不* 提供 DeepSeek 模型访问权限。您必须拥有自己的访问权限。**
*   PHP 开启 cURL 扩展

## 常见问题解答 (FAQ)

**问：这个插件会自动发布文章到我的博客吗？**

答：不会。该插件在 WordPress 编辑器 *内* 生成内容。您仍然需要自己检查、编辑和发布文章。

**问：这个插件能保证生成的内容是唯一的、原创的吗？**

答：AI 生成的内容有时可能与现有内容相似。在发布之前，检查和编辑生成的内容以确保原创性并避免抄袭至关重要。建议使用查重工具。

**问：AI 生成的字数能完全准确吗？**

答：“短”、“中”、“长”选项提供的是字数范围, 并非精确控制。

**问：我可以将此插件用于商业用途吗？**

答：可以，但您有责任确保生成的内容符合您的需求并遵守任何相关的服务条款（例如 DeepSeek 的条款、WordPress 的条款）。

## 贡献

欢迎贡献！请在 [GitHub 仓库](你的 GitHub 仓库链接) 上提交 pull requests 或提出 issues。

## 许可证

本插件采用 GPL v2 或更高版本许可。

## 免责声明

本插件使用第三方 AI 服务 (DeepSeek)。生成内容的质量和准确性取决于 AI 模型和您的提示。插件作者不对 AI 生成的内容负责。在发布之前，请务必检查和编辑生成的内容。

# DeepSeek AI Writer

[![WordPress Plugin Version](https://img.shields.io/wordpress/plugin/v/deepseek-ai-writer.svg)](https://wordpress.org/plugins/your-plugin-slug/)  [![WordPress Downloads](https://img.shields.io/wordpress/plugin/dt/deepseek-ai-writer.svg)](https://wordpress.org/plugins/your-plugin-slug/)  [![License](https://img.shields.io/badge/license-GPL--2.0%2B-blue.svg)](https://www.gnu.org/licenses/gpl-2.0.html)

DeepSeek AI Writer is a WordPress plugin that utilizes the power of the DeepSeek large language model to assist you in writing articles more quickly and efficiently.

## Features

*   **AI-Powered Content Generation:** Generate article titles, content, and excerpts based on your topic or prompt.
*   **Multiple Writing Styles:** Choose from various writing styles (formal, casual, professional, humorous, informative) to match your needs.
*   **Customizable Article Structure:** Select different article structures (standard, SEO-optimized, blog post, news report) to fit your content goals.
*   **User Preferences:** Saves your preferred article length, style, and structure.
*   **Classic and Gutenberg Editor Support:** Works seamlessly with both the Classic Editor and the Gutenberg block editor.
*   **Easy to Use:** Simple and intuitive interface.
*   **DeepSeek API Connection Test:**  Built-in test to verify your API connection.

## Installation

1.  **Upload:** Upload the `deepseek-ai-writer` folder to the `/wp-content/plugins/` directory.  Or install via the WordPress Plugins admin screen.
2.  **Activate:** Activate the plugin through the 'Plugins' menu in WordPress.
3.  **Configure:** Go to "DeepSeek AI Writer" in the WordPress admin menu to configure your DeepSeek API settings (URL, API Key, Model).

## Usage

1.  **Open a Post:** Create a new post or edit an existing one in WordPress.
2.  **Find the AI Writer Box:** You'll find the "DeepSeek AI Writer" box below the post title.
3.  **Enter a Prompt:** Type a topic or a brief description of what you want to write about in the "AI Writing Prompt" textarea.
4.  **Choose Options:** Select your desired article length, style, and structure.
5.  **Generate Content:** Click the "Generate Content" button.
6.  **Review and Edit:** The AI will generate content and populate the title, content, and excerpt fields.  Review and edit the generated content as needed.  *You* are responsible for the final content.
7. **Manually Add Tags**: The plugin does not attempt automatic keyword/tag extraction from the result. Add tags manually.

## Configuration

*   **Website:** The URL of your DeepSeek API endpoint.
*   **API Key:** Your DeepSeek API key.
*   **Model Name:** The name of the DeepSeek model you want to use.
*   **System Prompt:** A default system prompt to guide the AI's behavior (e.g., "You are a professional content creator").

## Requirements

*   WordPress 5.0 or higher
*   PHP 7.4 or higher
*   A DeepSeek API endpoint (third-party service) and API key.  **This plugin does *not* provide access to the DeepSeek model itself. You must have your own access.**
*   cURL extension enabled in PHP.

## Frequently Asked Questions (FAQ)

**Q: Does this plugin automatically post articles to my blog?**

A: No. The plugin generates content *within* the WordPress editor. You still need to review, edit, and publish the post yourself.

**Q: Does this plugin guarantee unique, original content?**

A: AI-generated content can sometimes be similar to existing content. It's essential to review and edit the generated text to ensure originality and avoid plagiarism. Consider using a plagiarism checker.

**Q: What if the AI doesn't generate the exact number of words I selected?**

A: The word count is an *approximation*. Large language models don't have precise control over word count. The "short," "medium," and "long" options provide general guidance.

**Q: Can I use this plugin for commercial purposes?**

A: Yes, you can, but you are responsible for ensuring the generated content meets your needs and complies with any relevant terms of service (e.g., DeepSeek's terms, WordPress's terms).

## Contributing

Contributions are welcome! Please submit pull requests or open issues on the [GitHub repository](your-github-repo-link). (Replace `your-github-repo-link` with the actual link.)

## License

This plugin is licensed under the GPL v2 or later.

## Disclaimer

This plugin uses a third-party AI service (DeepSeek). The quality and accuracy of the generated content depend on the AI model and your prompts. The plugin author is not responsible for the content generated by the AI. Always review and edit the generated text before publishing.

---
