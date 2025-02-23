jQuery(document).ready(function($) {
    // 存储历史记录 (简化版)
    var generationHistory = [];

    // 监听标题输入框的变化
    $('#title').on('input', function() {
        if ($(this).val().trim() !== '') {
            $('#title-prompt-text').hide();
        } else {
            $('#title-prompt-text').show();
        }
    });

    // 生成内容按钮点击事件
    $('#deepseek-ai-generate-button').on('click', function() {
        var prompt = $('#deepseek-ai-prompt').val();
        var length = $('#deepseek-ai-length').val();
        var style = $('#deepseek-ai-style').val();
        var structure = $('#deepseek-ai-structure').val();


        if (prompt.trim() === '') {
            alert('请输入 AI 写作提示！');
            return;
        }

        $('#deepseek-ai-loading').show();
        $('#deepseek-ai-progress-bar-container').show(); // 显示进度条容器
        $('#deepseek-ai-progress-bar').width('0%');     // 重置进度条
        $('#deepseek-ai-generate-button').prop('disabled', true);

        // 模拟进度条 (实际进度需要服务器端配合)
        var progressInterval = setInterval(function() {
            var currentWidth = parseInt($('#deepseek-ai-progress-bar').width() / $('#deepseek-ai-progress-bar-container').width() * 100);
            if (currentWidth < 90) {
                $('#deepseek-ai-progress-bar').width((currentWidth + 10) + '%');
            }
        }, 500); // 每 500 毫秒更新一次进度


        // 清除旧标签
        if (typeof wp.tagsSuggest !== 'undefined') {
            $('#tagsdiv-post_tag .tagchecklist button').click();
        } else {
            $('#tagsdiv-post_tag .tagchecklist').empty();
        }

        $.ajax({
            url: deepseek_ai_writer_params.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'deepseek_ai_writer_generate_content',
                prompt: prompt,
                length: length, // 传递长度
                style: style,   // 传递风格
                structure: structure, // 传递结构
                _ajax_nonce: deepseek_ai_writer_params._ajax_nonce,
            },
            success: function(response) {
                if (response.success) {
                    if (response.data.title) {
                        $('#title').val(response.data.title).trigger('input');
                    }
                    if (response.data.content) {
                        if (typeof tinymce !== 'undefined' && tinymce.activeEditor) {
                            tinymce.activeEditor.setContent(response.data.content);
                        } else {
                            $('#content').val(response.data.content);
                        }
                    }
                    if (response.data.excerpt) {
                        $('#excerpt').val(response.data.excerpt);
                    }
                    if (response.data.tags) {
                        if (typeof wp.tagsSuggest !== 'undefined') {
                            for (var i = 0; i < response.data.tags.length; i++) {
                                wp.tagsSuggest.addTag(response.data.tags[i]);
                            }
                        } else {
                           var newTags = response.data.tags;
                            $('#new-tag-post_tag').val(newTags.join(','));
                            $('.tagadd').click();
                        }
                    }

                     // 添加到历史记录 (简化版)
                    generationHistory.push({
                        prompt: prompt,
                        title: response.data.title,
                        content: response.data.content
                    });


                    alert('AI 内容生成成功！');
                } else {
                    alert('错误：' + response.data.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('AJAX 请求失败：' + textStatus + ', ' + errorThrown);
            },
            complete: function() {
                $('#deepseek-ai-loading').hide();
                $('#deepseek-ai-progress-bar-container').hide(); //隐藏进度条
                clearInterval(progressInterval); // 清除进度条更新
                $('#deepseek-ai-generate-button').prop('disabled', false);
            }
        });
    });

    // 测试连接按钮点击事件 (保持不变)
    $('#deepseek-ai-test-button').on('click', function() {
    $('#deepseek-ai-test-result').text('正在测试...').show();

        $.ajax({
            url: deepseek_ai_writer_params.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'deepseek_ai_writer_test_connection',
                _ajax_nonce: deepseek_ai_writer_params._ajax_nonce,
            },
            success: function(response) {
                $('#deepseek-ai-test-result').text(response.data.message).css('color', 'green');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#deepseek-ai-test-result').text('测试失败：' + textStatus + ', ' + errorThrown).css('color', 'red');
            },
        });
    });
});