<?php
/**
 * Plugin Name: DeepSeek AI Writer
 * Description: 使用 DeepSeek 大模型 AI 功能辅助 WordPress 文章写作。
 * Version: 1.7.0 // 更新版本号 (字数控制、结构优化、选项持久化)
 * Author: deepods
 * Author URI: https://www.deepods.com/
 */

// 插件设置页面、注册设置、设置字段回调函数、验证设置 (这些都保持不变,直接用上一版的)
function deepseek_ai_writer_add_settings_page() {
 add_options_page(
  'DeepSeek AI Writer 设置',
  'DeepSeek AI Writer',
  'manage_options',
  'deepseek-ai-writer',
  'deepseek_ai_writer_settings_page_content'
 );
}
add_action('admin_menu', 'deepseek_ai_writer_add_settings_page');
function deepseek_ai_writer_settings_page_content() {
 ?>
 <div class="wrap">
  <h1>DeepSeek AI Writer 设置</h1>
  <form method="post" action="options.php">
            <?php
            settings_fields('deepseek_ai_writer_settings');
            do_settings_sections('deepseek-ai-writer');
            submit_button();
            ?>
        </form>
  <button type="button" id="deepseek-ai-test-button" class="button">测试连接</button>
  <div id="deepseek-ai-test-result"></div>
 </div>
 <?php
}
function deepseek_ai_writer_register_settings() {
 register_setting('deepseek_ai_writer_settings','deepseek_ai_writer_settings','deepseek_ai_writer_sanitize_settings');
 add_settings_section('deepseek_ai_writer_general_settings','常规设置','','deepseek-ai-writer');
 add_settings_field('deepseek_ai_writer_api_url','网址','deepseek_ai_writer_api_url_callback','deepseek-ai-writer','deepseek_ai_writer_general_settings');
 add_settings_field('deepseek_ai_writer_api_key','API Key','deepseek_ai_writer_api_key_callback','deepseek-ai-writer','deepseek_ai_writer_general_settings');
 add_settings_field('deepseek_ai_writer_model','模型名称','deepseek_ai_writer_model_callback','deepseek-ai-writer','deepseek_ai_writer_general_settings');
 add_settings_field('deepseek_ai_writer_system_prompt','系统提示词','deepseek_ai_writer_system_prompt_callback','deepseek-ai-writer','deepseek_ai_writer_general_settings');
}
add_action('admin_init', 'deepseek_ai_writer_register_settings');
function deepseek_ai_writer_api_url_callback() {
 $options = get_option('deepseek_ai_writer_settings');
 $api_url = isset($options['api_url']) ? esc_attr($options['api_url']) : '';
 echo "<input type='text' name='deepseek_ai_writer_settings[api_url]' value='$api_url' class='regular-text' />";
}
function deepseek_ai_writer_api_key_callback() {
 $options = get_option('deepseek_ai_writer_settings');
 $api_key = isset($options['api_key']) ? esc_attr($options['api_key']) : '';
 echo "<input type='text' name='deepseek_ai_writer_settings[api_key]' value='$api_key' class='regular-text' />";
}
function deepseek_ai_writer_model_callback() {
 $options = get_option('deepseek_ai_writer_settings');
 $model = isset($options['model']) ? esc_attr($options['model']) : '';
 echo "<input type='text' name='deepseek_ai_writer_settings[model]' value='$model' class='regular-text' />";
}
function deepseek_ai_writer_system_prompt_callback() {
 $options = get_option('deepseek_ai_writer_settings');
 $system_prompt = isset($options['system_prompt']) ? esc_attr($options['system_prompt']) : '你是专业的内容创作者';
 echo "<textarea name='deepseek_ai_writer_settings[system_prompt]' class='large-text' rows='5'>$system_prompt</textarea>";
 echo "<p class='description'>设置 DeepSeek 模型的系统提示词，用于指导 AI 的行为和角色。</p>";
}
function deepseek_ai_writer_sanitize_settings($input) {
  $sanitized_input = array();
 if (isset($input['api_url'])) {
  $sanitized_input['api_url'] = sanitize_text_field($input['api_url']);
 }
 if (isset($input['api_key'])) {
  $sanitized_input['api_key'] = sanitize_text_field($input['api_key']);
 }
 if (isset($input['model'])) {
  $sanitized_input['model'] = sanitize_text_field($input['model']);
 }
 if (isset($input['system_prompt'])) {
  $sanitized_input['system_prompt'] = sanitize_textarea_field($input['system_prompt']);
 }
 return $sanitized_input;
}

// 在文章编辑页面添加输入框和按钮 (修改了选项和布局)
function deepseek_ai_writer_add_input_box() {
    global $post_type;
    if ($post_type == 'post') {
        // 获取用户的偏好设置
        $user_id = get_current_user_id();
        $preferred_length = get_user_meta($user_id, 'deepseek_ai_writer_length', true) ?: 'medium'; // 默认中等
        $preferred_style = get_user_meta($user_id, 'deepseek_ai_writer_style', true) ?: 'formal'; // 默认正式
        $preferred_structure = get_user_meta($user_id, 'deepseek_ai_writer_structure', true) ?: 'basic'; //默认基本

        ?>
        <div id="deepseek-ai-writer-container">
             <div class="deepseek-ai-prompt-row">
                <label for="deepseek-ai-prompt">AI 写作提示：</label>
                <textarea id="deepseek-ai-prompt" name="deepseek-ai-prompt" rows="5" style="width: 80%;"></textarea>
            </div>

            <div class="deepseek-ai-options">
                <label for="deepseek-ai-length">文章长度：</label>
                <select id="deepseek-ai-length" name="deepseek-ai-length">
                    <option value="short" <?php selected($preferred_length, 'short'); ?>>短 (1000字以下)</option>
                    <option value="medium" <?php selected($preferred_length, 'medium'); ?>>中 (1000-3000字)</option>
                    <option value="long" <?php selected($preferred_length, 'long'); ?>>长 (3000字以上)</option>
                </select>

                <label for="deepseek-ai-style">文章风格：</label>
                <select id="deepseek-ai-style" name="deepseek-ai-style">
                    <option value="formal" <?php selected($preferred_style, 'formal'); ?>>正式</option>
                    <option value="casual" <?php selected($preferred_style, 'casual'); ?>>轻松</option>
                    <option value="professional" <?php selected($preferred_style, 'professional'); ?>>专业</option>
                    <option value="humorous" <?php selected($preferred_style, 'humorous'); ?>>幽默</option>
                    <option value="informative" <?php selected($preferred_style, 'informative'); ?>>信息丰富</option>
                </select>

               <label for="deepseek-ai-structure">文章结构：</label>
                <select id="deepseek-ai-structure" name="deepseek-ai-structure">
                    <option value="basic" <?php selected($preferred_structure, 'basic'); ?>>标准 (引言 + 主体 + 结论)</option>
                    <option value="seo" <?php selected($preferred_structure, 'seo'); ?>>SEO 优化 (多级标题)</option>
                    <option value="blog" <?php selected($preferred_structure, 'blog'); ?>>博客 (段落 + 小标题)</option>
                    <option value="news" <?php selected($preferred_structure, 'news'); ?>>新闻 (倒金字塔结构)</option>
                 </select>
            </div>
            <button type="button" id="deepseek-ai-generate-button" class="button button-primary">生成内容</button>
            <div id="deepseek-ai-loading" style="display: none;">正在生成...</div>
             <div id="deepseek-ai-progress-bar-container" style="display: none;">
                <div id="deepseek-ai-progress-bar"></div>
            </div>

        </div>
        <style>
            /* (样式保持不变,直接用上一版的) */
            #deepseek-ai-writer-container {
                margin-bottom: 10px;
                padding: 10px;
                background-color: #f9f9f9;
                border: 1px solid #ddd;
            }
           .deepseek-ai-prompt-row {
              display: flex; /* 使用 Flexbox */
              align-items: flex-start; /* 顶部对齐 */
          }

          .deepseek-ai-prompt-row label {
              margin-right: 10px;
              white-space: nowrap; /* 防止标签换行 */
              margin-top:5px; /* 与文本区域顶部对齐 */

          }
            .deepseek-ai-options{
                margin-top: 10px;
                margin-bottom: 10px;
            }
            .deepseek-ai-options label {
                margin-right: 5px;
            }
            .deepseek-ai-options select{
                margin-right: 15px;
            }
             #deepseek-ai-progress-bar-container {
                width: 100%;
                background-color: #ddd;
                margin-top:5px;
            }

            #deepseek-ai-progress-bar {
                width: 0%;
                height: 10px;
                background-color: #4CAF50;
                text-align: center;
                line-height: 30px;
                color: white;
            }
        </style>
        <?php
    }
}
add_action('edit_form_after_title', 'deepseek_ai_writer_add_input_box');

// 添加 JavaScript 代码 (稍后给出完整版)
function deepseek_ai_writer_enqueue_scripts() {
   global $post_type, $pagenow;
    if ( ($post_type == 'post' && in_array( $pagenow, array( 'post.php', 'post-new.php' ) )) || (isset($_GET['page']) && $_GET['page'] == 'deepseek-ai-writer')  ) {
        wp_enqueue_script('deepseek-ai-writer-script', plugin_dir_url(__FILE__) . 'deepseek-ai-writer.js', array('jquery'), '1.7.0', true); //更新版本

        $options = get_option('deepseek_ai_writer_settings');
        wp_localize_script('deepseek-ai-writer-script', 'deepseek_ai_writer_params', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'api_url'  => isset($options['api_url']) ? $options['api_url'] : '',
            'api_key'  => isset($options['api_key']) ? $options['api_key'] : '',
            'model'    => isset($options['model']) ? $options['model'] : '',
            'system_prompt' => isset($options['system_prompt']) ? $options['system_prompt'] : '你是专业的内容创作者',
            '_ajax_nonce' => wp_create_nonce('deepseek_ai_writer_nonce'),
        ));
    }
}
add_action('admin_enqueue_scripts', 'deepseek_ai_writer_enqueue_scripts');

// AJAX 处理函数 (修改了提示词的构建)
function deepseek_ai_writer_generate_content() {
    check_ajax_referer('deepseek_ai_writer_nonce', '_ajax_nonce');

    $options = get_option('deepseek_ai_writer_settings');
    $api_url = $options['api_url'] ?? '';
    $api_key = $options['api_key'] ?? '';
    $model = $options['model'] ?? '';
    $system_prompt = $options['system_prompt'] ?? '你是专业的内容创作者';

    $prompt = sanitize_text_field($_POST['prompt']);
    $length = sanitize_text_field($_POST['length']);
    $style = sanitize_text_field($_POST['style']);
    $structure = sanitize_text_field($_POST['structure']);

     // 保存用户的偏好设置
    $user_id = get_current_user_id();
    update_user_meta($user_id, 'deepseek_ai_writer_length', $length);
    update_user_meta($user_id, 'deepseek_ai_writer_style', $style);
    update_user_meta($user_id, 'deepseek_ai_writer_structure', $structure);

    // 构建更详细的提示词
    $new_prompt = "请根据以下主题生成一篇文章，包括标题、内容、摘要和关键词（用英文逗号分隔）：\n\n主题：$prompt\n\n要求：\n";

    // 文章长度
    switch ($length) {
        case 'short':
            $new_prompt .= "* 文章长度：简短 (约 800-1000 个中文字符)\n"; // 更精确的字数范围
            break;
        case 'medium':
            $new_prompt .= "* 文章长度：中等 (约 1800-2500 个中文字符)\n"; // 更精确的字数范围
            break;
        case 'long':
            $new_prompt .= "* 文章长度：详细 (约 3500-4000 个中文字符)\n"; // 更精确的字数范围
            break;
    }

    // 文章风格
    $new_prompt .= "* 文章风格：$style\n";

    // 文章结构
    switch ($structure) {
        case 'seo':
            $new_prompt .= "* 文章结构：针对 SEO 优化，包含多级标题 (H2, H3, H4)，并在标题中包含关键词。请生成元描述（Meta Description）。如果适用，请包含内部链接和外部链接。\n";
            break;
        case 'blog':
            $new_prompt .= "* 文章结构：博客文章，包含段落和小标题 (H2, H3)。\n";
            break;
        case 'news':
            $new_prompt .= "* 文章结构：新闻报道，采用倒金字塔结构（最重要的信息放在开头）。\n";
            break;
        case 'basic':
        default:
            $new_prompt .= "* 文章结构：标准结构，包含引言、主体和结论。\n";
            break;
    }

    $new_prompt .= "* 关键词3-5个。\n";
    $new_prompt .= "*   返回格式为：\n标题：[标题]\n\n内容：[内容]\n\n摘要：[摘要]\n\n关键词：[关键词1,关键词2,关键词3]";
    $headers = array(
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $api_key,
    );
    $data = array(
        'model' => $model,
        'messages' => array(
            array('role' => 'system', 'content' => $system_prompt),
            array('role' => 'user', 'content' => $new_prompt),
        ),
    );

    $response = wp_remote_post($api_url, array(
        'headers' => $headers,
        'body' => json_encode($data),
        'timeout' => 60,
    ));

    if (is_wp_error($response)) {
        wp_send_json_error(array('message' => '请求失败：' . $response->get_error_message()));
    }

    $response_code = wp_remote_retrieve_response_code($response);
    $response_body = wp_remote_retrieve_body($response);

    if ($response_code != 200) {
        wp_send_json_error(array('message' => "API 请求错误, 代码: $response_code, 返回值: " . $response_body));
    }

    $result = json_decode($response_body, true);

    if (isset($result['choices'][0]['message']['content'])) {
        $generated_content = $result['choices'][0]['message']['content'];

        $pattern = '/标题：(.*?)\n\n内容：(.*?)\n\n摘要：(.*?)\n\n关键词：(.*?)$/s';
        if (preg_match($pattern, $generated_content, $matches)) {
            $title = trim($matches[1]);
            $content = trim($matches[2]);
            $excerpt = trim($matches[3]);
            $keywords_str = trim($matches[4]);

            $title = str_replace(array('#', '*'), '', $title);
            $content = str_replace(array('#', '*'), '', $content);
            $excerpt = str_replace(array('#', '*'), '', $excerpt);

            if (empty($excerpt)) {
                $excerpt = wp_trim_words($content, 50, '...');
            }

            $tags = array_filter(array_map('trim', explode(',', $keywords_str)));
            $tags = array_slice($tags, 0, 10);

            $content = str_replace("\n\n", "</p><p>", $content);
            $content = str_replace("\n", "<br/>", $content);
            $content = "<p>".$content."</p>";
            wp_send_json_success(array(
                'title' => $title,
                'content' => $content,
                'excerpt' => $excerpt,
                'tags' => $tags,
            ));

        } else {
             // 解析失败，返回错误信息,并将原始内容返回
            wp_send_json_error(array('message' => 'AI 返回内容格式不正确，无法解析。原始内容：' . $generated_content));
        }
    } else {
        $error_message = isset($result['error']['message']) ? $result['error']['message'] : '未知错误';
        wp_send_json_error(array('message' => 'AI 内容生成失败：' . $error_message));
    }
}
add_action('wp_ajax_deepseek_ai_writer_generate_content', 'deepseek_ai_writer_generate_content');
add_action('wp_ajax_nopriv_deepseek_ai_writer_generate_content', 'deepseek_ai_writer_generate_content');

// 测试连接的 AJAX 处理函数 (保持不变)
function deepseek_ai_writer_test_connection() {
   check_ajax_referer('deepseek_ai_writer_nonce', '_ajax_nonce');

    $options = get_option('deepseek_ai_writer_settings');
    $api_url = isset($options['api_url']) ? $options['api_url'] : '';
    $api_key = isset($options['api_key']) ? $options['api_key'] : '';
    $model = isset($options['model']) ? $options['model'] : '';

    $test_prompt = "你好";

    $headers = array(
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $api_key,
    );
    $data = array(
        'model' => $model,
        'messages' => array(
            array('role' => 'user', 'content' => $test_prompt),
        ),
    );

    $response = wp_remote_post($api_url, array(
        'headers' => $headers,
        'body' => json_encode($data),
        'timeout' => 30,
    ));

    if (is_wp_error($response)) {
        wp_send_json_error(array('message' => '连接失败：' . $response->get_error_message()));
    }

    $response_code = wp_remote_retrieve_response_code($response);
    $response_body = wp_remote_retrieve_body($response);

    if ($response_code != 200) {
        wp_send_json_error(array('message' => "连接失败，状态码: $response_code, 返回值: " . $response_body));
    }

    $result = json_decode($response_body, true);
    if (isset($result['choices'][0]['message']['content'])) {
        wp_send_json_success(array('message' => '连接成功！返回内容：' . $result['choices'][0]['message']['content']));
    } else {
        $error_message = isset($result['error']['message']) ? $result['error']['message'] : '未知错误';
        wp_send_json_error(array('message' => '连接失败：' . $error_message));
    }
}
add_action('wp_ajax_deepseek_ai_writer_test_connection', 'deepseek_ai_writer_test_connection');