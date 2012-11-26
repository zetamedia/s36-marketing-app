<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script src="js/JqueryFileUploader/vendor/jquery.ui.widget.js"></script>
    <script src="js/JqueryFileUploader/jquery.iframe-transport.js"></script>
    <script src="js/JqueryFileUploader/jquery.fileupload.js"></script>
    <style>
        .clearer{ clear: both; }
        #drop_zone{ padding: 50px; border: 1px solid; width: 50px; height: 50px; }
        .upload_preview{ display: none; }
        .upload_preview img, .upload_preview .progress_container, .upload_preview .delete{ float: left; }
        .progress_container{ width: 250px; }
        .progress_shade{ width: 0%; height: 15px; background: green; }
    </style>
</head>
<body>

    <form method="post" enctype="multipart/form-data">
        <input type="text" id="url" placeholder="url" size="100" value="http://mashable.com/2012/01/25/get-old-facebook-back" />
        <input type="button" value="test" id="test" /><br/><br/>
        
        
        <input type="file" multiple id="file_uploader" data-url="jqueryfileuploader" />
        <input type="submit" value="Save" />
        
        
        <div id="drop_zone">drop zone</div>
        <div id="upload_preview_container">
            <div class="upload_preview">
                <img />
                <div class="progress_container">
                    <div class="progress_shade"></div>
                </div>
                <!--<input type="button" class="delete" value="Delete" data-type="" data-url="" />-->
                <input type="hidden" name="names[]" class="name" />
                <input type="hidden" name="image_urls[]" class="image_url" />
                <div class="clearer"></div>
            </div>
        </div><br/><br/>
        
        
        <div id="url_preview">
            <?php echo file_get_contents('http://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20FROM%20html%20WHERE%20url%3D%22http%3A%2F%2Fmashable.com%2F2012%2F01%2F25%2Fget-old-facebook-back%22%20AND%20xpath%3D%22%2F%2Ftitle%7C%2F%2Fhead%2Fmeta%22&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=cbfunc'); ?>
        </div>
    </form>
    
</body>
</html>

<script type="text/javascript">
    
    $('#test').click(function(){
        
        var url = $('#url').val();
        var query = 'http://query.yahooapis.com/v1/public/yql?q=' + encodeURIComponent('SELECT * FROM html WHERE url="' + url + '" AND xpath="//title|//head/meta"') + '&format=json&callback=cbfunc';
        
        $.ajax({
            type: 'GET',
            dataType: 'jsonp',
            //url: query,
            url: 'http://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20FROM%20html%20WHERE%20url%3D%22http%3A%2F%2Fmashable.com%2F2012%2F01%2F25%2Fget-old-facebook-back%22%20AND%20xpath%3D%22%2F%2Ftitle%7C%2F%2Fhead%2Fmeta%22&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=cbfunc',
            success: function(data){
                alert(data);
            },
            error: function(a, b, c){
                alert(a); alert(b); alert(c);
            }
        });
        
    });
    
    
    
    $('#file_uploader').fileupload({
        dropZone: $('#drop_zone'),
        add: function(e, data){
            $('.upload_preview').eq(0).clone().appendTo('#upload_preview_container');
            $('.upload_preview').last().css('display', 'block');
            data.submit();
        },
        progress: function(e, data){
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('.upload_preview').last().find('.progress_shade').css('width', progress + '%');
        },
        dataType: 'json',
        done: function(e, data){
            $('.upload_preview').last().find('img').attr('src', data.result[0].thumbnail_url);
            $('.upload_preview').last().find('.delete').attr('data-type', data.result[0].delete_type);
            $('.upload_preview').last().find('.delete').attr('data-url', data.result[0].delete_url);
            $('.upload_preview').last().find('.name').attr('value', data.result[0].name);
            $('.upload_preview').last().find('.image_url').attr('value', data.result[0].url);
        }
    });
    
</script>