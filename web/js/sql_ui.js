function resizeEditor() {
    var height = $('.panel-top').height();
    $('#sql-editor-container').height(height - 2);
    var editor = ace.edit('sql-editor-container');
    editor.resize();
}

$('.panel-container-vertical').height(
        $('.wrap').height()
        - $('.wrap > .container').css('padding-top').replace("px", "")
        - $('.wrap > .container').css('padding-bottom').replace("px", "")
);

$(document).ready(function() {
    $('.panel-top').resizable({
        handleSelector: '.splitter',
        resizeWidth: false,
        onDrag: function (event, $el, opt) {
            resizeEditor();
        },
        onDragStop: function (event, $el, opt) {
            resizeEditor();
        },
        onDragEnd: function (event, $el, opt) {
            resizeEditor();
        }
    });
    
    $('.sql-output').html('');
    
    $('#run-button').click(function() {
        var btn = this;
        if (!btn.disabledRun) {
            btn.disabledRun = true;
            
            var editor = ace.edit('sql-editor-container');
            var data = {
                script: editor.getValue(),
                params: $('#params').val(),
                usefile: $('#use-file').prop('checked')
            };
            $.post('run', data, function(json) {
                var output = $('.sql-output');
                output.append(json.out);
                output.animate({ scrollTop: output.prop("scrollHeight") }, 1000);
            }, 'json');

            setTimeout(function() {
                btn.disabledRun = false;
            }, 500);
        }
    });
    
    $('#clean-button').click(function() {
        $('.sql-output').html('');
    });
});